@extends('layouts.uw')

@section('title', '新規登録')

@section('head_title', '新規登録')

@section('content')

<div class="wrapper">
    <div class="wrap_inner">
        @if(Session::has('successMess'))
        <div class="mgb-45 text-center">
        {!! show_pmesses() !!}
        </div>
        
        <div class="col-sm-8 col-sm-offset-2">
            <a href="{{route('uw.home')}}" class="gr_btn"><i class="fa fa-home"></i> <span>マイトップへ</span></a>
        </div>
        @else
        <div class="alert alert-danger">{{trans('message.na_error')}}</div>
        @endif
    </div>
</div>

@stop

