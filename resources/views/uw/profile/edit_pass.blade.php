@extends('layouts.uw')

@section('title', 'プロフィール編集')

@section('head_title', 'プロフィール編集')

@section('content')

<div class="wrapper">
    <div class="wrap_inner v_top no-pdy">
        <a href="{{URL::previous()}}" class="back_btn"><i class="fa fa-arrow-left"></i>戻る</a>
        
        {!! show_messes() !!}

        <div class="wrap_box">

            {!! Form::open(['method' => 'post', 'route' => 'uw.update_pass']) !!}
            <div class="form-group mgb-25">
                <label>現在のパスワード</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><img src="/uweb/images/icon/lock-icon.png"></span>
                    <input type="password" name="oldpass" value="{{old('oldpass')}}" class="fl_txt">
                </div>
                {!! error_field('oldpass', $errors) !!}
            </div>

            <div class="form-group mgb-25">
                <label>新しいパスワード</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><img src="/uweb/images/icon/lock-icon.png"></span>
                    <input type="password" name="newpass" value="{{old('newpass')}}" class="fl_txt">
                </div>
                {!! error_field('newpass', $errors) !!}
            </div>

            <div class="form-group mgb-35">
                <label>新しいパスワード（確認）</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><img src="/uweb/images/icon/lock-icon.png"></span>
                    <input type="password" name="newpass_confirmation" value="{{old('newpass_confirmation')}}" class="fl_txt">
                </div>
            </div>

            <button type="submit" class="gr_btn"><i class="fa fa-refresh"></i> <span>パスワードを変更する</span></button>

            {!! Form::close() !!}

        </div>
    </div>
</div>

@stop
