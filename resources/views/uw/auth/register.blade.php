@extends('layouts.uw')

@section('title', '新規登録')

@section('head_title', '新規登録')

@section('content')

<div class="wrapper">
    <div class="wrap_inner">

        {!! show_messes() !!}
       
        @if(isset($pincode) && !$errors->has('pincode'))
        {!! Form::open(['method' => 'post', 'route' => 'uw.post_register']) !!}

            <div class="form-group mgb-35">
                <label>郵便番号[任意]</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" disabled name="email" value="{{$email}}" class="fl_txt disabled" placeholder="example@example.com">
                </div>
            </div>

            <div class="form-group mgb-35">
                <label>パスワード[必須]</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" name="passwd" class="fl_txt">
                </div>
                {!! error_field('passwd', $errors) !!}
            </div>

            <div class="form-group mgb-35">
                <label>ユーザ名[必須]</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" name="name" value="{{old('name')}}" class="fl_txt">
                </div>
                {!! error_field('name', $errors) !!}
            </div>

            <div class="form-group mgb-35">
                <p><label>性別[任意]</label></p>
                <label class="mgr-25 txt-black txt-normal">{!! Form::radio('gender', 1, 1==old('gender')) !!} 女性</label>
                <label class="mgr-25 txt-black txt-normal">{!! Form::radio('gender', 2, 2==old('gender')) !!} 男性</label>
                <label class="txt-black txt-normal">{!! Form::radio('gender', 0, old('gender') ? false : true) !!} 指定なし</label>
            </div>

            <div class="form-group g_date mgb-35 row">
                <label class="col-xs-12">生年月日[任意]</label>
                <div class="col-sm-4 col-xs-10">
                    {!! option_range('byear', 1970, 2016, old('byear')) !!}
                </div>
                <div class="col-sm-1 col-xs-2 br"><span class="mtop">年</span></div>
                <div class="col-sm-3 col-xs-4">
                    {!! option_range('bmonth', 1, 12, old('bmonth')) !!}
                </div>
                <div class="col-sm-1 col-xs-2"><span class="mtop">月</span></div>
                <div class="col-sm-2 col-xs-4">
                    {!! option_range('bday', 1, 31, old('bday')) !!}
                </div>
                <div class="col-sm-1 col-xs-2"><span class="mtop">日</span></div>
            </div>

            <div class="form-group mgb-35">
                <label>郵便番号[任意]</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><i class="fa fa-file-zip-o"></i></span>
                    <input type="text" name="zipcode" value="{{old('zipcode')}}" class="fl_txt">
                </div>
                {!! error_field('zipcode', $errors) !!}
            </div>

            <div class="form-group mgb-35">
                <label>電話番号[必須]</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                    <input type="text" name="phone" value="{{old('phone')}}" class="fl_txt">
                </div>
                {!! error_field('phone', $errors) !!}
            </div>

            <div class="form-group mgb-45">
                {!! Form::hidden('pincode', $pincode) !!}
                {!! error_field('pincode', $errors) !!}
                <button type="submit" class="gr_btn"><img src="/uweb/images/icon/regmail-icon.png"> <span>会員登録</span></button>
            </div>

            <p class="successMess pmess txt-gray">
                会員登録すると、あなたがサービスの利用規約、<a href="#">プライバシーポリシー</a>の すべての条件に同意したことになります。
            </p>

        {!! Form::close() !!}
        
        @else
        {!! error_field('pincode', $errors) !!}
        @endif
    </div>
</div>

@stop

