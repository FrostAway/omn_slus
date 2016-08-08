@extends('layouts.uw')

@section('title', 'エラーが発生しました')
@section('head_title', 'エラーが発生しました')

@section('content')

<div class="wrapper">
    <div class="wrap_inner">
        {!! show_messes() !!}
    </div>
</div>

@stop

