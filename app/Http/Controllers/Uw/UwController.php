<?php

namespace App\Http\Controllers\Uw;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Mail;

class UwController extends Controller {

    public function index() {
        return view('uw.index');
    }
    
    public function getContact(){
        return view('uw.contact_form');
    }
    
    public function postContact(Request $request){
        $valid = Validator::make($request->all(), [
            'email' => 'email|required',
            'name' => 'required',
            'content' => 'required'
        ]);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        
        $contact = [
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'content' => $request->input('content')
        ];
        
        Mail::send('mails.email_contact', $contact, function($mail) use ($contact){
            $from = env('MAIL_FROM');
            $to = env('MAIL_TO');
            $mail->from($from, $contact['name']);
            $mail->to($to);
            $mail->subject(trans('message.mail_contact_subject', ['name' => $contact['name']]));
        });
        
        if(count(Mail::failures()) > 0){
            return redirect()->back()->withInput()->with('errorMess', trans('message.err_send_mail'));
        }
        
        return view('uw.contact_sent', $contact);
    }
    
    public function errorMess(){
        return view('errors.uwmess');
    }

}
