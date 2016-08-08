@extends('layouts.uw')

@section('title', 'パスワード再設定')

@section('head_title', 'パスワード再設定')

@section('content')

<div class="wrapper">
    <div class="wrap_inner">

        {!! show_messes() !!}

        {!! Form::open(['method' => 'post', 'route' => 'uw.post_forget_pass_mail']) !!}

            <div class="border_box mgb-45">
                ご登録いただいたメールアドレスを入力してください。 <br /> メールアドレス宛にパスワード変更ページのURLが記載されたメールを送信しま
            </div>

            <div class="form-group mgb-45">
                <label>メールアドレス</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" name="email" class="fl_txt" placeholder="example@example.com">
                </div>
                {!! error_field('email', $errors) !!}
            </div>

            <div class="mgb-15">
                <a href="{{route('uw.get_login')}}" class="gr_btn"><i class="fa fa-arrow-left"></i> <span>戻る</span></a>
            </div>

            <div class="mgb-15">
                <button type="submit" class="gr_btn"><i class="fa fa-send"></i> <span>送信する</span></button>
            </div>
        
        {!! Form::close() !!}
    </div>
</div>

@stop

