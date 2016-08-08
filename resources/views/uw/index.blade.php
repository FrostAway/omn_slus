@extends('layouts.uw')

@section('title', 'Global top')

@section('content')

<div class="wrap">
    <div class="wrap_inner">
        <div class="index_logo text-center"><img class="img-responsive" src="/uweb/images/logo.png"></div>
        <div class="logon_btns">
            <a href="{{route('uw.get_reg_mail')}}" class="btn btn-block btn-login">新規登録</a>
            <a href="{{route('uw.get_login')}}" class="btn btn-block btn-register">ログイン</a>
        </div>
    </div>
</div>

@stop
