@extends('layouts.uw')

@section('title', 'パスワード再設定')

@section('head_title', 'パスワード再設定')

@section('content')

<div class="wrapper">
    <div class="wrap_inner">
        <h2 class="page-title text-center mgy-120">パスワードを変更しました。</h2>

        {!! show_messes() !!}
        
        {!! Form::open(['method' => 'post', 'route' => 'uw.post_login']) !!}

            <div class="form-group mgb-30">
                <label>メールアドレス</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" name="email" value="{{old('email')}}" class="fl_txt" placeholder="example@example.com">
                </div>
                {!! error_field('email', $errors) !!}
            </div>

            <div class="form-group mgb-30">
                <label>新しいパスワード（確認）</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><img src="/uweb/images/icon/lock-icon.png"></span>
                    <input type="password" name="passwd" value="{{old('passwd')}}" class="fl_txt">
                </div>
                {!! error_field('passwd', $errors) !!}
            </div>

            <div>
                <button type="submit" class="gr_btn"><i class="fa fa-sign-in"></i> <span>ログインへ</span></button>
            </div>
        
        {!! Form::close() !!}
    </div>
</div>

@stop

