@extends('layouts.uw')

@section('title', 'プラン変更・キャンセル')

@section('head_title', 'プラン変更・キャンセル')

@section('content')

<div class="wrapper">
    <div class="wrap_inner  no-pdy">
        <a href="{{URL::previous()}}" class="back_btn"><i class="fa fa-arrow-left"></i> マイトップに戻る</a>

        <div class="wrap_box">

            <div class="items">
                @if(Session::has('c_passport_name'))
                    <div class="item mgb-35">
                        <h3 class="title" style="color: #434242;">今月保有中のパスポートプラン</h3>
                        <ul class="sp_desc">
                            <li>{{Session::get('c_passport_name')}}</li>
                        </ul>
                    </div>
                
                    <div class="item mgb-35">
                        @if(Session::has('n_passport_name'))
                        <h3 class="title" style="color: #434242;">来月保有予定のパスポートプラン</h3>
                        <ul class="sp_desc">
                            <li class="txt-main">{{Session::get('n_passport_name')}}</li>
                        </ul>
                        @endif
                        @if(Session::has('cancel_passport'))
                        <h3 class="title" style="color: #434242">来月保有予定のパスポートプラン</h3>
                        <ul class="sp_desc">
                            <li class="txt-main">・なし</li>
                        </ul>
                        @endif
                    </div>
                    <?php 
                    Session::forget('c_passport_name'); 
                    Session::forget('n_passport_name'); 
                    Session::forget('cancel_passport'); 
                    ?>
                @endif
            </div>
            
        </div>     

    </div>
</div>

@stop

