@extends('layouts.uw')

@section('title', 'プロフィール編集')

@section('head_title', 'プロフィール編集')

@section('content')

<div class="wrapper">
    <div class="wrap_inner v_top no-pdy">
        <a href="{{URL::previous()}}" class="back_btn"><i class="fa fa-arrow-left"></i>戻る</a>

        {!! show_messes() !!}

        <div class="wrap_box">
            <div class="form-group mgb-25">
                <label>変更前メールアドレス</label>
                <p class="p_show">{{$user->email}}</p>
            </div>

            {!! Form::open(['method' => 'post', 'route' => 'uw.update_email']) !!}

            <div class="form-group mgb-25">
                <label>変更後メールアドレス</label>
                <div class="input-group gr_text">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" name="newmail" value="{{old('newmail')}}" class="fl_txt" placeholder="example@example.com">
                </div>
                {!! error_field('newmail', $errors) !!}
            </div>

            <div class="mgb-30">
                <button type="submit" class="gr_btn"><i class="fa fa-gear"></i> <span>メールアドレス変更</span></button>
            </div>

            {!! Form::close() !!}

            <p class="pmess">※送信される確認メールより認証を行ってください。</p>
        </div>
    </div>
</div>

@stop
