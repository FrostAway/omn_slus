<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Reset password on {{ request()->getHost() }}</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>Your pincode: {{$user->pincode}}</div>
        <p>Or <a href="{{ route('uw.get_reset_pass', ['pincode' => $user->pincode]) }}">click here</a> to reset your password</p>
    </body>
</html>

