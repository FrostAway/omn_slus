@extends('layouts.uw')

@section('title', '新規登録')

@section('head_title', '新規登録')

@section('content')

<div class="wrapper">
    <div class="wrap_inner">
        @if(!is_null(old('email')))
        <div class="input-group gr_text mgb-45">
            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
            <input type="email" disabled value="{{old('email')}}" class="fl_txt text-center">
        </div>

        <div class="form-group mgb-45">
            {!! show_pmesses() !!}
        </div>
        @else
        <div class="alert alert-danger">{{trans('message.na_error')}}</div>
        @endif
    </div>
</div>

@stop

