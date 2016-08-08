@extends('layouts.uw')

@section('title', 'パスワード再設定')

@section('head_title', 'パスワード再設定')

@section('content')

<div class="wrapper">
    <div class="wrap_inner">
        {!! show_messes() !!}
        
        @if(!isset($pincode) || $errors->has('pincode'))
        
        {!! error_field('pincode', $errors) !!}
        
        @else
        
        <h2 class="page-title mgy-120"> 新しいパスワードを入力してください</h2>
        {!! Form::open(['method' => 'post', 'route' => 'uw.post_reset_pass']) !!}
        
            <div class="form-group mgb-30">
                <label>新しいパスワード</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><img src="/uweb/images/icon/lock-icon.png"></span>
                    <input type="password" name="passwd" value="{{old('passwd')}}" class="fl_txt">
                </div>
                {!! error_field('passwd', $errors) !!}
            </div>

            <div class="form-group mgb-30">
                <label>新しいパスワード（確認）</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><img src="/uweb/images/icon/lock-icon.png"></span>
                    <input type="password" name="passwd_confirmation" value="{{old('passwd_confirmation')}}" class="fl_txt">
                </div>
            </div>

            <div>
                <input type="hidden" name="pincode" value="{{$pincode}}">
                {!! error_field('pincode', $errors) !!}
                <button type="submit" class="gr_btn"><i class="fa fa-refresh"></i> <span> パスワード変更する</span></button>
            </div>
        
        {!! Form::close() !!}
        
        @endif
    </div>
</div>

@stop

