<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        SLoRN運営会社からのお知らせ ――――――――――――――――――<br>
        メールアドレスの変更依頼を受けました。<br>
        ▼▼ 24時間以内に下記のPINコードをアプリに入力して、メールアドレス変更を完了させてください ▼▼<br>
        {{$user->pincode}} または <a href="{{route('uw.confirm_edit_email', ['pincode' => $user->pincode])}}">ここをクリック</a>
        <br><br>
        メールの内容に覚えがない場合は、お手数ですが下記までご連絡ください。<br>
        <a href="mailto:customer@slorn.jp">customer@slorn.jp</a><br />
        ---------------------<br />
        ■SLoRNサービスについて<br />
        <a href="http://slorn.jp/" target="_blank">http://slorn.jp/</a><br /><br>

        ■個人情報の取り扱いについては個人情報保護方針をご覧ください。<br />
        <a href="http://slorn.jp/policy/" target="_blank">http://slorn.jp/policy/</a><br />
    </body>
</html>

