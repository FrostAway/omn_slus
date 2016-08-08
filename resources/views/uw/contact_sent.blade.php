@extends('layouts.uw')

@section('title', 'お問合せ')
@section('head_title', 'お問合せ')

@section('content')

<div class="wrapper">
    <div class="wrap_inner">
        
        <div class="border_box mgb-35">
            <label class="txt-reg">以下の 内容でお問合せを承りました。</label>
        </div>

        <div class="form-group mgb-25">
            <label>お名前</label>
            <p class="p_show">{{$name}}</p>
        </div>

        <div class="form-group mgb-25">
            <label>メールアドレス</label>
            <p class="p_show">{{$email}}</p>
        </div>

        <div class="form-group mgb-35">
            <label>お問合せ内容</label>
            <p class="p_show">
                {{$content}}
            </p>
        </div>
        
    </div>
</div>

@stop
