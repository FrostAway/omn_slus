<?php

namespace App\Http\Controllers\Uw;

use Illuminate\Http\Request;
//use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CusTemp;
use Validator;
use Mail;
use Auth;
use DB;

class AuthController extends Controller {

    public function getRegMail() {
        return view('uw.auth.reg_mail');
    }

    public function postRegMail(Request $request, CusTemp $custemp) {
        $valid = Validator::make($request->all(), [
                    'email' => 'email|required|unique:customers,email'
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }

        $email = $request->input('email');
        $user = CusTemp::where('email', $email)->first();
        $pincode = makePin($custemp);

        DB::beginTransaction();
        if ($user) {
            $user->pincode = $pincode;
            $user->mtime = date('Y-m-d H:i:s', time());
            $user->save();
        } else {
            $user = new CusTemp([
                'email' => $email,
                'pincode' => $pincode,
                'passwd' => bcrypt(randomString(10)),
                'name' => explode('@', $email)[0],
                'sl_inviter_type' => 0
            ]);
            $user->save();
        }
        
        $from = env('MAIL_FROM', 'customer@slorn.jp');
        Mail::send('mails.email_active', ['user' => $user], function($m) use ($email, $from) {
            $m->from($from);
            $m->to($email);
            $m->subject(trans('message.new_active_mail_subject'));
        });

        if (count(Mail::failures()) > 0) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['email' => trans('message.err_send_mail')]);
        }
        DB::commit();
        return redirect()->route('uw.fn_reg_mail')->withInput()->with('successMess', trans('message.active_mail_success'));
    }

    public function finishRegMail() {
        return view('uw.auth.fn_reg_mail');
    }

    public function getRegister(Request $request) {
        $valid = Validator::make($request->all(), [
                    'pincode' => 'required'
        ], [
            'pincode.required' => trans('message.invalid_pincode')
        ]);
        if ($valid->fails()) {
            return view('uw.auth.register')->withErrors($valid->errors());
        }
        
        $user = CusTemp::where('pincode', $request->get('pincode'))->where('mtime', '>', date('Y-m-d H:i:s', time() - 3600))->first();
        if (!$user) {
            return view('uw.auth.register')->withErrors(['pincode' => trans('message.invalid_pincode')]);
        }
        
        return view('uw.auth.register', ['pincode' => $user->pincode, 'email' => $user->email]);
    }

    public function postRegister(Request $request) {
        $valid = Validator::make($request->all(), [
                    'passwd' => 'required',
                    'name' => 'required',
                    'zipcode' => 'size:5|alpha_num',
                    'pincode' => 'required'
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
       
        $user = CusTemp::where('pincode', $request->input('pincode'))->where('mtime', '>', date('Y-m-d H:i:s', time() - 3600))->first();
        if (!$user) {
            return redirect()->back()->withInput()->withErrors(['pincode' => trans('message.invalid_pincode')]);
        }
        $birth = $request->input('byear') . '-' . $request->input('bmonth') . '-' . $request->input('bday');
        $birth = date('Y-m-d H:i:s', strtotime($birth));

        DB::beginTransaction();
        $newuser = new Customer([
            'name' => $request->input('name'),
            'email' => $user->email,
            'passwd' => bcrypt($request->input('passwd')),
            'hashcode' => bcrypt($request->input('passwd')),
            'birthday' => $birth,
            'gender' => $request->input('gender'),
            'zipcode' => $request->input('zipcode'),
            'phone' => $request->input('phone'),
            'sl_inviter_type' => 0,
        ]);
        $newuser->save();

        if (!CusTemp::where('email', $user->email)->delete()) {
            DB::rollBack();
            return redirect()->route('uw.fn_register')->with('errorMess', trans('message.na_errors'));
        }
        
        DB::commit();
        return redirect()->route('uw.fn_register')->with('successMess', trans('message.register_success'));
    }

    public function fnRegister() {
        return view('uw.auth.fn_register');
    }

    public function getLogin() {
        return view('uw.auth.login');
    }

    public function postLogin(Request $request) {
        if (Auth::guard('customer')->check()) {
            return redirect()->intended('/uw/home');
        }

        $valid = Validator::make($request->all(), [
                    'email' => 'email|required',
                    'passwd' => 'required|min:6'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }

        $user = Customer::where('email', $request->input('email'))->first();
        if (!$user || (!\Hash::check($request->input('passwd'), $user->passwd))) {
            return redirect()->back()->withInput()->with('errorMess', trans('message.invalid_login'));
        }

        c_auth()->login($user, false);
        return redirect()->intended(route('uw.mytop'));
    }

    public function logout() {
        if (c_auth()->check()) {
            c_auth()->logout();
        }
        return redirect()->route('uw.home');
    }

    public function getForgetPassMail() {
        return view('uw.auth.forget_passwd');
    }

    public function postForgetPassMail(Request $request, Customer $customer) {
        $valid = Validator::make($request->all(), [
                    'email' => 'email|required'
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        $email = $request->input('email');
        $user = Customer::where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->withInput()->withErrors(['email' => trans('message.email_not_exists')]);
        }

        DB::beginTransaction();
        $user->pincode = makePin($customer);
        $user->create_time = date('Y-m-d H:i:s', time());
        $user->save();

        Mail::send('mails.email_passwordreset', ['user' => $user], function($mail) use ($user) {
            $mail->from(env('MAIL_FROM', 'customer@slorn.jp'));
            $mail->to($user->email);
            $mail->subject(trans('message.mail_reset_password_subject', ['host' => request()->getHost()]));
        });

        if (count(Mail::failures()) > 0) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('errorMess', trans('message.err_send_mail'));
        }

        DB::commit();
        return redirect()->route('uw.fn_forget_pass_mail')->withInput();
    }

    public function fnForgetPassMail() {
        return view('uw.auth.fn_forget_passwd');
    }

    public function getResetPass(Request $request) {
        $valid = Validator::make($request->all(), [
                    'pincode' => 'required'
                        ], [
                    'pincode.required' => trans('message.invalid_pincode')
        ]);
        if ($valid->fails()) {
            return view('uw.auth.reset_passwd')->withErrors($valid->errors());
        }

        $user = Customer::where('pincode', $request->get('pincode'))->where('create_time', '>', date('Y-m-d H:i:s', time() - 3600))->first();
        if (!$user) {
            return view('uw.auth.reset_passwd')->withErrors(['pincode' => trans('message.invalid_pincode')]);
        }

        return view('uw.auth.reset_passwd', ['pincode' => $user->pincode]);
    }

    public function postResetPass(Request $request) {
        $valid = Validator::make($request->all(), [
                    'pincode' => 'required',
                    'passwd' => 'required|confirmed'
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }

        $user = Customer::where('pincode', $request->input('pincode'))->where('create_time', '>', date('Y-m-d', time() - 3600))->first();
        if (!$user) {
            return redirect()->back()->withInput()->withErrors(['pincode' => trans('message.invalid_pincode')]);
        }
        $user->passwd = bcrypt($request->input('passwd'));
        $user->pincode = null;
        $user->create_time = null;
        $user->save();

        return redirect()->route('uw.fn_reset_pass');
    }

    public function fnResetPass() {
        return view('uw.auth.fn_reset_passwd');
    }

}
