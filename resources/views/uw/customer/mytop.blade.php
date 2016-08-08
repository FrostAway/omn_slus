@extends('layouts.uw')

@section('title', 'My top')

@section('head_title', 'My top')

@section('content')

<h2 class="single-title">マイトップ</h2>
<p class="nameid sg_sub mgb-30">会員ID：XXX　○○様</p>

<div class="wrapper">
    <div class="wrap_inner v_top pd-30">
        <h3 class="box-title mgb-30">SLoRNパスポートプラン一覧</h3>
        <div class="excerpt mgb-30">
            <p class="mgb-20"><b>SLoRN</b>パスポートを月額継続サービス。購入す<br /> ると<b>SLoRN</b>ショップにて、お得に飲めるクーポンを毎月受け取れます。</p>
            <p>プランは３つ、以下のクーポンの組み合わせとなります。</p>
        </div>

        <div class="b_content">
            <div class="items list_items">
                <?php for ($i = 0; $i < 3; $i++) { ?>
                    <div class="item mgb-30">
                        <h4 class="title"><a href="uw-083-80.php">【初回無料クーポン】</a></h4>
                        <ul class="item_desc">
                            <li>初めてのお店ならどこでも500円分無料で飲めます。</li>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="br_h"></div>

<div class="wrapper">
    <div class="wrap_inner v_top pd-30"> 
        @if(c_auth()->user()->hasPassport())
        <?php
        $user = c_auth()->user();
        $c_passport = $user->getPassport(); 
        ?>
        <h3 class="box-title text-center mgb-35">パスポート保有状況</h3>
        <div class="b_sub mgb-45 text-center">{{$c_passport->pass_name}}</div>

        <div class="b_content">
            <div class="items pp_options">
                <div class="item text-center active">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <h4 class="title mgb-35 text-center">クレジットカード決済ができておりません。 <br /> クレジットカード情報を確認、変更してください。</h4>
                            
                            <?php 
                            $link = config('gmo.link');
                            $site_id = config('gmo.site_id');
                            $site_pass = config('gmo.site_pass');
                            $shop_id = config('gmo.shop_id');
                            $dateTime = date('YmdHis');
                            ?>
                            <form method="post" action="{{$link.$shop_id.'/Member/Edit'}}">
                                <input type="hidden" name="SiteID" value="{{ $site_id }}" />
                                <input type="hidden" name="MemberID" value="{{ 'slorn_gmo_'.$user->id }}" />
                                <input type="hidden" name="MemberName" value="{{ $user->name }}" />
                                <input type="hidden" name="ShopID" value="{{ $shop_id }}" />
                                <input type="hidden" name="MemberPassString" value="{{ md5($site_id . 'slorn_gmo_'.$user->id . $shop_id . $site_pass . $dateTime) }}" />

                                <input type="hidden" name="RetURL" value="{{ route('uw.profile') }}" />
                                <input type="hidden" name="CancelURL" value="{{ route('uw.profile') }}" />
                                <input type="hidden" name="DateTime" value="{{ $dateTime }}" />
                                <input type="hidden" name="SessionTimeout" value="1800" />
                                <input type="hidden" name="Confirm" value="1" />
                                <input type="hidden" name="UserInfo" value="pc" >

                                <button type="submit" class="gr_btn"><img src="/uweb/images/icon/credit-card.png"> <span>クレジットカード情報変更</span></button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="item text-center">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <h4 class="title mgb-35 text-center">翌月のパスポートのプラン変更、または定期 <br /> 購入をキャンセルする場合はこちら</h4>
                            <a href="{{route('uw.change_plan')}}" class="gr_btn"><img src="/uweb/images/icon/p-change.png"> <span>クレジットカード情報変更</span></a>
                        </div>
                    </div>
                </div>

                <div class="item text-center">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <h4 class="title mgb-35 text-center"> 今までのパスポート購入履歴を確認する場合はこちら</h4>
                            <a href="{{route('uw.purchase_history')}}" class="gr_btn"><img src="/uweb/images/icon/passport-icon.png"> <span>パスポート購入履歴</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @else

        <h3 class="box-title mgb-30 text-center">SLoRNパスポートプラン一覧</h3>

        <div class="b_content">
            <?php 
            $payment_link = config('gmo.link');
            $site_id = config('gmo.site_id');
            $site_pass = config('gmo.site_pass');
            $shop_id = config('gmo.shop_id');
            $shop_pass = config('gmo.shop_pass');
            $user = c_auth()->user();
            $dateTime = date('YmdHis');
            ?>
            {!! Form::open(['method' => 'post', 'id' => 'purchase_form', 'route' => 'uw.purchase_passport', 'request-url' => $payment_link.$shop_id.'/Multi/Entry']) !!}
                <div class="items passports mgb-45">
                    {!! error_field('passport', $errors) !!}
                    @foreach ($passports as $pp)
                    <div class="item mgb-30">
                        <h4 class="title mgb-15 txt-reg">{!! Form::radio('passport', $pp->id, $pp->id == old('passport')) !!}  {{$pp->price}} 円</h4>
                        <p class="sp_desc pdl-20">
                            {!! $pp->description !!}
                        </p>
<!--                        <ul class="sp_desc">
                            <?php // for ($j = 0; $j < 3; $j++) { ?>
                                <li><span class="mgr-25">初回無料クーポン</span> 上限なし</li>
                            <?php // } ?>
                        </ul>-->
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <button type="submit" class="gr_btn"><i class="fa fa-shopping-cart"></i> <span>購入手続きをする</span></button>
                    </div>
                </div>
            {!! Form::close() !!}
            
        </div>

        @endif
    </div>
</div>

<div class="br_h"></div>

<div class="br_h"></div>

<div class="wrapper">
    <div class="wrap_inner">
        <h3 class="box-title text-center mgb-35">アカウント情報</h3>
        <div class="b_sub mgb-45 text-center">アカウント情報を確認・変更する場合はこちら</div>

        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <a href="{{route('uw.profile')}}" class="gr_btn"><img src="/uweb/images/icon/info-icon.png"> <span>アカウント情報</span></a>
            </div>
        </div>
    </div>
</div>

@stop

@section('foot')

<script>

</script>

@stop

