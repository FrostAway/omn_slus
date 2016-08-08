@extends('layouts.uw')

@section('title', 'パスポート購入c履歴')

@section('head_title', 'パスポート購入c履歴')

@section('content')

<div class="wrapper">
    <div class="wrap_inner v_top no-pdy">
        <a href="{{route('uw.mytop')}}" class="back_btn"><i class="fa fa-arrow-left"></i> マイトップに戻る</a>

        <div class="wrap_box">
            
            @if(!$purchases->isEmpty())
            <div class="items mgb-30">
                <div class="row mgb-30">
                    <div class="col-xs-3">購入年月日</div>
                    <div class="col-xs-7">購入内容</div>
                    <div class="col-xs-2">備考</div>
                </div>
                @foreach($purchases as $pc)
                <div class="item mgb-30 row">
                    <div class="date col-xs-3">{{date('Y-m-d', strtotime($pc->purchase_date))}}</div>
                    <div class="item_desc col-xs-7">{{$pc->pass_name}} ({{date('Y年m月分')}})</div>
                    <div class="col-xs-2">{{$pc->str_payment_result()}}</div>
                </div>
                @endforeach
            </div>
            @endif
            
            <div class="mgb-30 tl_btns text-center">
                @if($purchases->previousPageUrl())
                <a href="{{$purchases->previousPageUrl()}}" class="tl_btn">前へ</a>
                @endif
                @if($purchases->nextPageUrl())
                <a href="{{$purchases->nextPageUrl()}}" class="tl_btn">次へ</a>
                @endif
                <a class="tl_btn">{{$purchases->currentPage()}}/{{$purchases->lastPage()}}ページ</a>
            </div>
            
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <a href="{{route('uw.mytop')}}" class="gr_btn"><i class="fa fa-arrow-left"></i> <span>  戻る</span></a>
                </div>
            </div>

        </div>

    </div>
</div>

@stop

