<?php

namespace App\Http\Controllers\Uw;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquents\PassportEloquent;
use Validator;
use App\Models\Purchase;
use GMO\Payment\Consts;
use GMO\Payment\SiteApi;
use DB;

class CustomerController extends Controller {

    protected $passport;

    public function __construct(PassportEloquent $passport) {
        $this->passport = $passport;
    }

    public function myTop() {
        $passports = $this->passport->all();
        return view('uw.customer.mytop', ['passports' => $passports]);
    }

    public function showPassport($pid) {
        $passport = $this->passport->show($pid);
        return view('uw.customer.passport', ['passport' => $passport]);
    }

    public function purchasePassport(Request $request) {
        $valid = Validator::make($request->all(), [
                    'passport' => 'required|exists:passports,id'
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }

        $user = c_auth()->user();
        $passport_id = $request->input('passport');
        $passport = $this->passport->show($passport_id);

        //check user passport;
        $customer_passport = DB::table('customers_passports as cp')
                ->where('customer_id', $user->id)
                ->where('to_date', '>=', date('Y-m-d H:i:s'))
                ->where('set_flag', 1)
                ->select('cp.passport_id')
                ->lists('cp.passport_id');

        if (count($customer_passport) > 0) {
            $passport_cat = DB::table('passports')
                    ->whereIn('category', function($query) use ($customer_passport) {
                        $query->select('category')
                        ->from('passports')
                        ->whereIn('id', $customer_passport);
                    })
                    ->select('category')
                    ->find($passport_id);
            if ($passport_cat) {
                return redirect()->back()->withInput()->withErrors(['passport' => trans('message.user_purchased_passport')]);
            }
        }

        $link = config('gmo.link');
        $shop_id = config('gmo.shop_id');
        $shop_pass = config('gmo.shop_pass');
        $site_id = config('gmo.site_id');
        $site_pass = config('gmo.site_pass');
        $date_time = date('YmdHis');
        $order_id = $passport->id . $date_time;
        $tax = 0;
        $shop_pass_string = md5($shop_id . $order_id . $passport->price . $tax . $shop_pass . $date_time);
        $member_pass_string = md5($site_id . 'slorn_gmo_' . $user->id . $site_pass . $date_time);

        // check member saved
        $site = new SiteApi(config('gmo.payment_link'), $site_id, $site_pass);
        try {
            $site->saveMember('slorn_gmo_' . $user->id, $user->email);
        } catch (\Exception $ex) {
            return redirect()->back()->withInput()->withErrors(['passport' => $ex->getMessage()]);
        }

        return view('uw.customer.post_purchase_gmo', compact(
                        'passport', 'link', 'shop_id', 'site_id', 'user', 'order_id', 'tax', 'date_time', 'shop_pass_string', 'member_pass_string'
        ));
    }

    public function purchasePassportFinish(Request $request) {
        if (!$request->isMethod('POST')) {
            die();
        }
        $user = c_auth()->user();
        $data = $request->all();
        $err_message = null;

        $purchase = new Purchase();
        $purchase->user_id = $user->id;
        $purchase->order_id = $data['OrderID'];
        $purchase->tax = isset($data['Tax']) ? $data['Tax'] : 0;
        $purchase->amount = $data['Amount'];
        $purchase->passport_id = $data['ClientField3'];
        $purchase->payment_type = 1;

        if ($data['ErrInfo']) {
            $err_message = Consts::getErrorMessage($data['ErrInfo']);
            $purchase->payment_result = 2;
            $purchase->error_message = $err_message;
            $purchase->save();
            
            event(new \App\Events\PurchasedPassPort(2));
            return view('uw.customer.purchase_finish', compact('data', 'err_message'));
        }
        
        $purchase->payment_result = 1;
        $purchase->save();

        $date_time = date('Y-m-d H:i:s');
        $customer_passport = DB::table('customers_passports')->insert([
            'customer_id' => $user->id,
            'passport_id' => $purchase->passport_id,
            'next_passport_id' => $purchase->passport_id,
            'from_date' => $date_time,
            'to_date' => getDateNextMonth(),
            'auth_date' => $date_time,
            'set_date' => $date_time,
            'auth_flag' => 1,
            'set_flag' => 1,
            'first_flag' => 1,
            'amount' => $data['Amount']
        ]);
        
        event(new \App\Events\PurchasedPassPort(1));
        $passport = $this->passport->show($purchase->passport_id);
        return view('uw.customer.purchase_finish', compact('data', 'err_message', 'passport'));
    }

    public function changePlan() {
        $passports = $this->passport->all();
        $c_passport = c_auth()->user()->getPassport();
        $n_passport = $this->passport->show($c_passport->next_passport_id);
        return view('uw.customer.change_plan', compact('passports', 'c_passport', 'n_passport'));
    }

    public function updatePlan(Request $request) {
        $valid = Validator::make($request->all(), [
                    'passport' => 'required|exists:passports,id'
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        $c_passport = c_auth()->user()->getPassport();
        $r_passport_id = $request->get('passport');
        if ($c_passport->next_passport_id == $r_passport_id) {
            return redirect()->back()->withInput()->withErrors(['passport' => trans('message.next_passport_no_change')]);
        }
        $update = DB::table('customers_passports')
                ->where('passport_id', $c_passport->id)
                ->where('customer_id', c_auth()->id())
                ->where('to_date', '>', date('Y-m-d H:i:s'))
                ->where('set_flag', 1)
                ->update(['next_passport_id' => $r_passport_id]);
        if (!$update) {
            return redirect()->back()->withInput()->withErrors(['passport' => trans('message.na_error')]);
        }
        $r_passport = $this->passport->show($r_passport_id, ['pass_name']);
        return redirect()->route('uw.change_plan_fn')->with('n_passport_name', $r_passport->pass_name)
                        ->with('c_passport_name', $c_passport->pass_name);
    }

    public function cancelPlan(Request $request) {
        $c_passport = c_auth()->user()->getPassport();
        $update = DB::table('customers_passports')
                ->where('passport_id', $c_passport->id)
                ->where('customer_id', c_auth()->id())
                ->where('to_date', '>', date('Y-m-d H:i:s'))
                ->where('set_flag', 1)
                ->update(['next_passport_id' => null]);
        if (!$update) {
            return redirect()->back()->withInput()->withErrors(['passport' => trans('message.na_error')]);
        }

        return redirect()->route('uw.change_plan_fn')->with('cancel_passport', '')
                        ->with('c_passport_name', $c_passport->pass_name);
    }

    public function updatePlanFn() {
        return view('uw.customer.change_plan_finish');
    }

    public function purchaseHistory() {
        $purchases = Purchase::join('passports as pp', 'purchase.passport_id', '=', 'pp.id')
                ->where('user_id', c_auth()->id())
                ->select('purchase.*', 'pp.pass_name', 'pp.price')
                ->paginate(10);
        return view('uw.customer.purchase_history', compact('purchases'));
    }

}
