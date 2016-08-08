@extends('layouts.uw')

@section('title', 'ログイン')

@section('head_title', 'ログイン')

@section('content')

<div class="wrap">
    <div class="wrap_inner">
        <div class="index_logo text-center"><img class="img-responsive" src="/uweb/images/logo.png"></div>
        
        {!! show_messes() !!}
        
        {!! Form::open(['method' => 'post', 'route' => 'uw.post_login']) !!}
        
            <div class="form-group mgb-40">
                <label class="txt-white">メールアドレス</label>
                <div class="input-group gr_text txt_bg">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" name="email" value="{{old('email')}}" class="fl_txt">
                </div>
                {!! error_field('email', $errors) !!}
            </div>

            <div class="form-group mgb-40">
                <label class="txt-white">パスワード</label>
                <div class="input-group gr_text txt_bg">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" name="passwd" value="{{old('passwd')}}" class="fl_txt">
                </div>
                {!! error_field('passwd', $errors) !!}
            </div>

            <div class="form-group mgb-40">
                <button type="submit" class="gr_btn"><i class="fa fa-users"></i> <span>会員登録</span></button>
            </div>
        
        {!! Form::close() !!}
        
        <a href="{{route('uw.get_forget_pass_mail')}}" class="ext_link">パスワード忘れた場合はこちら</a>
    </div>
</div>

@stop

