@extends('layouts.uw')

@section('title', 'お問合せ')

@section('head_title', 'お問合せ')

@section('content')

<div class="wrapper">
    <div class="wrap_inner">
        {!! Form::open(['method' => 'post', 'route' => 'uw.post_contact']) !!}
            <div class="form-group mgb-25">
                <label>お名前</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" name="email" value="{{old('email')}}" class="fl_txt" placeholder="example@example.com">
                </div>
                {!! error_field('email', $errors) !!}
            </div>

            <div class="form-group mgb-25">
                <label>メールアドレス</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" name="name" value="{{old('name')}}" class="fl_txt">
                </div>
                {!! error_field('name', $errors) !!}
            </div>

            <div class="form-group mgb-35">
                <label>お問い合わせ内容</label>
                <textarea class="fl_txt" name="content" rows="5">{{old('content')}}</textarea>
                {!! error_field('content', $errors) !!}
            </div>
            <button type="submit" class="gr_btn"><i class="fa fa-book"></i> <span>お問合せする</span></button>
        {!! Form::close() !!}
    </div>
</div>

@stop

