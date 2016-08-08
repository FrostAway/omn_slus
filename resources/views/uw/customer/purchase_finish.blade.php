
@extends('layouts.uw')

@section('title', 'パスポート購入完了')

@section('content')

<div class="wrapper">
    <div class="wrap_inner">
        
        @if(!$err_message)
        
        <div class="sp_desc mgb-45">
            <p class="mgb-35"><b class="txt-main">SLORN</b>パスポートの購入が完了いたしました。 ご利用いただきありがとうございます。</p>
            <p>購入されたパスポートは<b class="txt-main">SLORN</b>アプリでもご確認できます。</p>
        </div>
        <h3 class="gtitle mgb-10">購入したSLoRNパスポートプラン</h3>
        <form action="">
            <div class="item mgb-45">
                @if($passport)
                <label class="txt-black"><input type="radio" checked value="{{$passport->id}}"> {{$passport->price}}円</label>
                <p class="sp_desc">{!! $passport->description !!}</p>
<!--                <ul class="sp_desc">
                    <li>初回無料クーポン　上限なし</li>
                    <li>初回無料クーポン　７ショップまで 翌月まで繰り越し可</li>
                    <li>割引クーポン　　　１０回 同一ショップは２回まで</li>
                </ul>-->
                @endif
            </div>

            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <!--<button type="submit" class="gr_btn"><i class="fa fa-home"></i> <span>マイトップへ</span></button>-->
                    <a href="{{route('uw.mytop')}}" class="gr_btn"><i class="fa fa-home"></i> <span>マイトップへ</span></a>
                </div>
            </div>
        </form>
        
        @else
        <div class="gtitle text-center">{{$err_message}}</div>
        @endif
    </div>
</div>

@stop