<?php

namespace App\Http\Controllers\Uw;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Eloquents\ImageEloquent;
use Validator;
use DB;
use Mail;
use Auth;
use Session;
use GMO\Payment\SiteApi;
use GMO\Payment\Consts;

class ProfileController extends Controller {

    protected $image;

    public function __construct(ImageEloquent $image) {
        $this->image = $image;
    }

    public function profile(Request $request) {
        if($request->isMethod('POST')){
            if(!$request->get('ErrCode')){
                Session::put('successMess', trans('message.updated_card'));
            }else{
                Session::put('errorMess', Consts::getErrorMessage($request->get('ErrCode')));
            }
        }
        
        return view('uw.profile.index', [
            'user' => Customer::with(['avatar' => function($query) {
                            $query->select('id', 'url');
                        }])
                    ->find(c_auth()->id(), ['id', 'name', 'birthday', 'gender', 'email', 'zipcode', 'image_id', 'phone', 'card_id'])
        ]);
    }

    public function editEmail() {
        return view('uw.profile.edit_email', ['user' => Customer::find(c_auth()->id())], ['id', 'email']);
    }

    public function updateEmail(Request $request, Customer $customer) {
        $user_id = c_auth()->id();
        $valid = Validator::make($request->all(), [
                    'newmail' => 'email|required|unique:customers,email'
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }

        $user = Customer::find($user_id);
        $newmail = $request->input('newmail');

        DB::beginTransaction();
        $user->pincode = makePin($customer);
        $user->create_time = date('Y-m-d H:i:s', time());
        $user->email_tmp = $newmail;
        $user->save();

        Mail::send('mails.email_confirm', ['newmail' => $newmail, 'user' => $user], function($m) use ($newmail) {
            $m->from(env('MAIL_USERNAME', 'uw@gmail.com'), 'UW');
            $m->to($newmail);
            $m->subject(trans('message.change_mail_subject'));
        });

        if (count(Mail::failures()) > 0) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('errorMess', trans('message.err_send_mail'));
        }

        DB::commit();
        return redirect()->route('uw.send_edit_email')->withInput(); /* ->with('successMess', trans('message.change_mail_sent')); */
    }

    public function confirmChangeMail(Request $request) {
        $valid = Validator::make($request->all(), [
                    'pincode' => 'required'
                        ], [
                    'pincode.required' => trans('message.invalid_pincode')
        ]);

        if ($valid->fails()) {
            return redirect()->route('uw.edit_email')->withInput()->withErrors($valid->errors());
        }

        $user = Customer::where('pincode', $request->get('pincode'))->where('create_time', '>', date('Y-m-d H:i:s', time() - 3600))->first();
        if (!$user) {
            return redirect()->route('uw.error_mess')->with('errorMess', trans('message.invalid_pincode'));
        }

        $user->email = $user->email_tmp;
        $user->create_time = null;
        $user->email_tmp = null;
        $user->pincode = null;
        $user->save();

        return redirect()->route('uw.profile')->with('successMess', trans('message.updated_email'));
    }

    public function sendChangeMail() {
        return view('uw.profile.edit_email_sent');
    }

    public function editPassword() {
        return view('uw.profile.edit_pass');
    }

    public function updatePassword(Request $request) {
        $valid = Validator::make($request->all(), [
                    'oldpass' => 'required',
                    'newpass' => 'required|confirmed'
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }

        $user_id = c_auth()->id();
        $oldpass = $request->input('oldpass');
        $newpass = $request->input('newpass');

        $user = Customer::find($user_id, ['id', 'passwd']);
        if (!\Hash::check($oldpass, $user->passwd)) {
            return redirect()->back()->withInput()->withErrors(['oldpass' => trans('message.invalid_passwd')]);
        }

        $user->passwd = bcrypt($newpass);
        $user->save();

        return redirect()->route('uw.profile')->with('successMess', trans('message.updated_passwd'));
    }

    public function getCard($user_id, $seq_mode = 0) {
        $payment_link = config('gmo.payment_link');
        $site_id = config('gmo.site_id');
        $site_pass = config('gmo.site_pass');

        $site = new SiteApi($payment_link, $site_id, $site_pass);

        $response = $site->searchCard('slorn_gmo_' . $user_id, $seq_mode);

        return $response;
    }
    
    public function saveMember(){
        $payment_link = config('gmo.payment_link');
        $site_id = config('gmo.site_id');
        $site_pass = config('gmo.site_pass');
        $site = new SiteApi($payment_link, $site_id, $site_pass);
        
        $user = c_auth()->user();
        try{
            $response = $site->saveMember('slorn_gmo_'.$user->id, $user->email);
            return $response;
        }catch(\Exception $e){
            return $e->getMessage();
        }
        
    }

    public function editCreditCard() {
 
    }

    public function updateCreditCard(Request $request) {

    }

    public function editProfile() {
        return view('uw.profile.edit', [
            'user' => Customer::
                    with(['avatar' => function($query) {
                            $query->select('id', 'url');
                        }])
                    ->find(c_auth()->id(), ['id', 'name', 'birthday', 'gender', 'zipcode', 'image_id', 'phone'])
        ]);
    }

    public function updateProfile(Request $request) {
        $valid = Validator::make($request->all(), [
                    'name' => 'required',
                    'avatar' => 'mimes:jpeg,png,gif|max:5120',
                    'zipcode' => 'size:5|alpha_num'
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid->errors());
        }

        $user_id = c_auth()->id();
        DB::beginTransaction();
        $image = null;
        try {
            if ($request->hasFile('avatar')) {
                $image = $this->image->upload($request->file('avatar'), 1, $user_id, 1);
            }
            $user = Customer::find($user_id);
            $user->name = $request->input('name');
            if ($request->has('zipcode')) {
                $user->zipcode = $request->input('zipcode');
            }
            if ($request->has('gender')) {
                $user->gender = $request->input('gender');
            }
            if ($request->has('phone')) {
                $user->phone = $request->input('phone');
            }
            $birth = $request->input('byear') . '-' . $request->input('bmonth') . '-' . $request->input('bday');
            $birth = date('Y-m-d H:i:s', strtotime($birth));
            $user->birthday = $birth;

            if ($image) {
                $old_image_id = $user->image_id;
                $user->image_id = $image->id;
            }
            $user->save();
            if ($image) {
                $this->image->delete($old_image_id);
            }

            DB::commit();
            return redirect()->route('uw.profile')->with('successMess', trans('message.updated_profile'));
        } catch (Exception $e) {
            DB::rollBack();
            if ($image) {
                $this->image->delete($image);
            }
            return redirect()->back()->with('errorMess', trans('message.na_error'));
        }
    }

}
