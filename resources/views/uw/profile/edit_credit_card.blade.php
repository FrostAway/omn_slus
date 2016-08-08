@extends('layouts.uw')

@section('title', 'クレジットカード情報変更')

@section('head_title', 'クレジットカード情報変更')

@section('content')

<div class="wrapper">
    <div class="wrap_inner v_top no-pdy">
        <a href="{{route('uw.profile')}}" class="back_btn"><i class="fa fa-arrow-left"></i>戻る</a>

        {!! show_messes() !!}

        <div class="wrap_box">
            {!! Form::open(['method' => 'post', 'route' => 'uw.update_creditcard']) !!}
            <div class="form-group mgb-30">
                <label>クレジットカード情報</label>
                <div class="p_show">
                    @if($card)
                    <div class="row mgb-5">
                        <div class="col-xs-5 col-sm-3">カード会社</div>
                        <div class="col-xs-7 col-sm-9">{{$card['card_name']}}</div>
                    </div>
                    <div class="row mgb-5">
                        <div class="col-xs-5 col-sm-3">カード番号</div>
                        <div class="col-xs-7 col-sm-9">{{$card['card_number']}}</div>
                    </div>
                    @else
                    <div class="mgb-5">No card</div>
                    @endif
                </div>
            </div>

            <div class="mgb-30">
                <button type="submit" class="gr_btn"><i class="fa fa-gear"></i> <span>変更確認</span></button>
            </div>

            {!! Form::close() !!}
        </div>

    </div>
</div>

@stop