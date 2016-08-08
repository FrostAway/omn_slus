@extends('layouts.uw')

@section('title', 'プラン変更・継続中止')

@section('head_title', 'プラン変更・継続中止')

@section('content')

<div class="wrapper">
    <div class="wrap_inner  no-pdy">
        <a href="{{route('uw.mytop')}}" class="back_btn"><i class="fa fa-arrow-left"></i> マイトップに戻る</a>

        <div class="wrap_box">

            <div class="items">
                @if($c_passport)
                <div class="item mgb-35">
                    <h3 class="title">今月保有中のパスポートプラン</h3>
                    <ul class="sp_desc">
                        <li>{{$c_passport->pass_name}}</li>
                    </ul>
                </div>
                @if($n_passport)
                <div class="item mgb-35">
                    <h3 class="title">来月保有予定のパスポートプラン</h3>
                    <ul class="sp_desc">
                        <li>{{$n_passport->pass_name}}</li>
                    </ul>
                </div>
                @endif
                @endif
            </div>

            <h2 class="gtitle mgb-10">プラン変更</h2>

            {!! error_field('passport') !!}

            {!! Form::open(['method' => 'post', 'route' => 'uw.update_plan']) !!}
            <div class="items passports mgb-45">
                @if($passports)
                @foreach($passports as $pp)
                <div class="item mgb-30">
                    <?php 
                    $checked = false; 
                    if($n_passport){
                        if($n_passport->id == $pp->id){
                            $checked = true;
                        }
                    }
                    ?>
                    <h4 class="title t_normal mgb-15">{!! Form::radio('passport', $pp->id, $checked) !!} {{$pp->price}} 円</h4>
                    <p class="sp_desc">{!! $pp->description !!}</p>
                </div>
                @endforeach
                @endif
            </div>
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <button type="submit" class="gr_btn"><img src="/uweb/images/icon/p-change.png" alt=" "> <span> 変更手続き</span></button>
                </div>
            </div>
            {!! Form::close() !!}

        </div>

        <div class="wrap_box">
            <h2 class="box-title mgb-15">キャンセル</h2>
            <div class="box_conten mgb-45 txt-gray">
                <p>保有しているパスポートの利用を中止する場合、キャンセルをクリックして下さい。</p>
                <p>※キャンセルが反映するのは来月からとなります。</p>
                <p>※残りのクーポンは有効期間中利用いただけます。</p>
            </div>

            {!! Form::open(['method' => 'post', 'route' => 'uw.cancel_plan', 'class' => 'confirm_form']) !!}
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <button type="submit" class="gr_btn"><img src="/uweb/images/icon/close-icon.png" alt=" "> <span> 変更手続き</span></button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
</div>

<script>
    (function ($) {
        $('.confirm_form').submit(function () {
            var cf = confirm('<?php echo trans('message.confirm_cancel') ?>');
            if (cf) {
                return true;
            } else {
                return false;
            }
        });
    })(jQuery);
</script>

@stop

