@extends('layouts.uw')

@section('title', '新規登録')

@section('head_title', '新規登録')

@section('content')

<div class="wrapper">
    <div class="wrap_inner">
        <h2 class="page-title mgy-120">メールアドレスを入力して仮登録します。</h2>

        {!! show_messes() !!}
        
        {!! Form::open(['method' => 'post', 'route' => 'uw.post_reg_mail']) !!}
            
            <div class="form-group mgb-45">
                <input type="email" value="{{old('email')}}" name="email" class="fl_txt text-center" placeholder="メールアドレスを入力して">
                {!! error_field('email', $errors) !!}
            </div>

            <div class="form-group mgb-45">
                <button type="submit" class="gr_btn"><img src="/uweb/images/icon/regmail-icon.png"> <span>仮登録</span></button>
            </div>
            <div class="form-group mgb-45">
                <a href="#" class="gr_btn"><img src="/uweb/images/icon/pass-icon.png"> <span>プライバシーポリシー</span></a>
            </div>

        {!! Form::close() !!}

    </div>
</div>

@stop

