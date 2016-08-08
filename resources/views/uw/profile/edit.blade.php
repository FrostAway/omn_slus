@extends('layouts.uw')

@section('title', 'プロフィール編集')

@section('head_title', 'プロフィール編集')

@section('content')

<div class="wrapper">
    <div class="wrap_inner v_top no-pdy">
        <a href="{{URL::previous()}}" class="back_btn"><i class="fa fa-arrow-left"></i>戻る</a>

        <div class="border_box">
            <p class="pmess">情報を入力するほど、お店から様々なサービスを受けられる ようになります。</p>
        </div>

        <div class="wrap_box pdt-40">

            {!! show_messes() !!}

            {!! Form::open(['method' => 'post', 'route' => 'uw.update_profile', 'files' => true]) !!}

            <div class="form-group mgb-25">
                <label>メールアドレス</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" name="name" value="{{$user->name}}" class="fl_txt" placeholder="鈴木太郎">
                </div>
                {!! error_field('name', $errors) !!}
            </div>

            <div class="text-center mgb-25"><label>メールアドレス</label></div>
            <div class="row mgb-20">
                <div class="col-xs-4 col-sm-3">
                    <div class="gr_file text-center">
                        <a class="btn_file">{!! $user->avtImg(1, 'thumbnail') !!}</a>
                    </div>
                </div>
                <div class="col-xs-8 col-sm-9">
                    <div class="file_valid sp_desc txt-gray mgb-20">
                        <p class="mgb-0">※ファイル形式：JPEG、PNG、GIF</p>
                        <p class="mgb-0">※ファイル容量：5MB以下</p>
                    </div>
                    <div class="form-group">
                        <p><label>性別[任意]</label></p>
                        <label class="mgr-15 txt-black txt-normal">{!! Form::radio('gender', 1, 1==$user->gender) !!} 女性</label>
                        <label class="mgr-15 txt-black txt-normal">{!! Form::radio('gender', 2, 2==$user->gender) !!} 男性</label>
                        <label class="txt-black txt-normal">{!! Form::radio('gender', 0, 0==$user->gender) !!} 指定なし</label>
                    </div>
                </div>
            </div>

            <div class="mgb-25 gr_upload">
                <input type="file" name="avatar" class="input_upload">
                <button type="button" class="gr_btn upload_btn"><i class="fa fa-upload"></i> <span> パスワードを変更する</span></button>
                {!! error_field('avatar', $errors) !!}
            </div>

            <div class="form-group g_date mgb-25 row">
                <label class="col-xs-12">性別[任意]</label>
                <div class="col-sm-4 col-xs-10">
                    {!! option_range('byear', 1970, 2016, $user->birthday->format('Y')) !!}
                </div>
                <div class="col-sm-1 col-xs-2 br"><span class="mtop">年</span></div>
                <div class="col-sm-3 col-xs-4">
                    {!! option_range('bmonth', 1, 12, $user->birthday->format('m')) !!}
                </div>
                <div class="col-sm-1 col-xs-2"><span class="mtop">月</span></div>
                <div class="col-sm-2 col-xs-4">
                    {!! option_range('bday', 1, 31, $user->birthday->format('d')) !!}
                </div>
                <div class="col-sm-1 col-xs-2"><span class="mtop">日</span></div>
            </div>

            <div class="form-group mgb-25">
                <label>郵便番号[任意]</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><img src="/uweb/images/icon/lock-edit.png"></span>
                    <input type="text" name="zipcode" value="{{$user->zipcode}}" class="fl_txt">
                </div>
                {!! error_field('zipcode', $errors) !!}
            </div>

            <div class="form-group mgb-25">
                <label>電話番号[必須]</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                    <input type="text" name="phone" value="{{$user->phone}}" class="fl_txt">
                </div>
                {!! error_field('phone', $errors) !!}
            </div>

            <button type="submit" class="gr_btn"><i class="fa fa-save"></i> <span>保存する</span></button>

            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop
