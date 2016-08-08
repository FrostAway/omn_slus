@extends('layouts.uw')

@section('title', 'パスワード再設定')

@section('head_title', 'パスワード再設定')

@section('content')

<div class="wrapper">
    <div class="wrap_inner">

        <form action="">

            <div class="form-group mgb-30">
                <label>メールアドレス</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" disabled value="{{old('email')}}" class="fl_txt disabled" placeholder="example@example.com">
                </div>
            </div>

            <div class="border_box mgb-35 minh-200">
                <p>入力されたメールアドレス宛にメールを送信しました。60分以内にご確認をお願いします。</p>
            </div>

            <div class="mgb-15">
                <a href="{{route('uw.get_login')}}" class="gr_btn"><i class="fa fa-arrow-left"></i> <span>戻る</span></a>
            </div>

            <div class="mgb-15">
                <button type="submit" class="gr_btn"><i class="fa fa-send"></i> <span>送信する</span></button>
            </div>
            
        </form>
    </div>
</div>

@stop

