@extends('layouts.uw')

@section('title', 'クレジットカード情報変更')

@section('head_title', 'クレジットカード情報変更')

@section('content')

<div class="wrapper">
    <div class="wrap_inner v_top no-pdy">
        <a href="{{route('uw.profile')}}" class="back_btn"><i class="fa fa-arrow-left"></i>戻る</a>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                {!! show_messes() !!}

                <div class="wrap_box">
                    {!! Form::open(['method' => 'post', 'route' => 'uw.update_creditcard']) !!}

                    <div class="card_input mgb-25">
                        <div class="c_boxs">
                            <div class="c_box"><input type="text" class="c_num"></div>
                            <div class="c_box"><input type="text" class="c_num"></div>
                            <div class="c_box"><input type="text" class="c_num"></div>
                            <div class="c_box"><input type="text" class="c_num"></div>
                        </div>
                        <div class="c_boxs">
                            <div class="c_box"><label>有効期限</label></div>
                            <div class="c_box"><input type="text" class="c_num"></div>
                            <div class="c_box"><input type="text" class="c_num"></div>
                        </div>
                        <div class="c_boxs">
                            <div class="c_box c_box_2"><label>セキュリティコード</label></div>
                            <div class="c_box"><input type="text" class="c_num"></div>
                        </div>
                    </div>

                    <div class="form-group mg-btm-35">
                        <input type="text" class="fl_txt">
                    </div>

                    <div class="mgb-30">
                        {!! requestInput() !!}
                        <button type="submit" class="gr_btn"><i class="fa fa-gear"></i> <span>変更確認</span></button>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<!--<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <h1 class="page-header">Credit card</h1>
        
        {!! Form::open(['method' => 'post', 'route' => 'uw.update_creditcard']) !!}
        
        
        <div class="form-group row">
            <label class="col-xs-12">Num</label>
            <div class="col-xs-3">
                <input type="text" name="cnumber[]" value="{{old('cnumber')[0]}}" class="form-control">
                {!! error_field('cnumber.0', $errors) !!}
            </div>
            <div class="col-xs-3">
                <input type="text" name="cnumber[]" value="{{old('cnumber')[1]}}" class="form-control">
                {!! error_field('cnumber.1', $errors) !!}
            </div>
            <div class="col-xs-3">
                <input type="text" name="cnumber[]" value="{{old('cnumber')[2]}}" class="form-control">
                {!! error_field('cnumber.2', $errors) !!}
            </div>
            <div class="col-xs-3">
                <input type="text" name="cnumber[]" value="{{old('cnumber')[3]}}" class="form-control">
                {!! error_field('cnumber.3', $errors) !!}
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="form-group row">
            <label class="col-xs-3">Date</label>
            <div class="col-xs-3">
                <input type="text" name="dMonth" value="{{ old('dMonth') }}" class="form-control">
                {!! error_field('dMonth', $errors) !!}
            </div>
            <div class="col-xs-3">
                <input type="text" name="dYear" value="{{ old('dYear') }}" class="form-control">
                {!! error_field('dYear', $errors) !!}
            </div>
        </div>
        
        <button type="submit" class="btn btn-default btn-block">Submit</button>
        
        {!! Form::close() !!}
    </div>
</div>-->

@stop