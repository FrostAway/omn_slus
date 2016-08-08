@extends('layouts.uw')

@section('title', 'プロフィール編集')

@section('head_title', 'プロフィール編集')

@section('content')

<div class="wrapper">
    <div class="wrap_inner v_top no-pdy">
        <a href="{{route('uw.mytop')}}" class="back_btn"><i class="fa fa-arrow-left"></i> マイトップに戻る</a>

        {!! show_messes('txt-main', 'text-center') !!}

        <div class="wrap_box">

            <div class="text-center mgb-25"><label>メールアドレス</label></div>
            <div class="row mgb-45">
                <div class="col-xs-3 col-md-2">
                    <div class="gr_file text-center">
                        <!--<a class="">$user->avtImg(1, 'thumbnail', 'c_avatar')</a>-->
                    </div>
                </div>
                <div class="col-xs-9 col-md-10">
                    <div class="row mgb-5">
                        <div class="col-xs-5">会員ID：</div>
                        <div class="col-xs-7">{{$user->id}}</div>
                    </div>
                    <div class="row mgb-5">
                        <div class="col-xs-5">ユーザー名：</div>
                        <div class="col-xs-7">{{$user->name}}</div>
                    </div>
                    <div class="row mgb-5">
                        <div class="col-xs-5">性別：</div>
                        <div class="col-xs-7">{{$user->gender()}}</div>
                    </div>
                    <div class="row mgb-5">
                        <div class="col-xs-5">生年月日：</div>
                        <div class="col-xs-7">{{$user->birthday->format('Y')}}年{{$user->birthday->format('m')}}月{{$user->birthday->format('d')}}日</div>
                    </div>
                    <div class="row mgb-5">
                        <div class="col-xs-5">郵便番号：</div>
                        <div class="col-xs-7">{{$user->zipcode}}</div>
                    </div>
                    <div class="row mgb-5">
                        <div class="col-xs-5">電話番号：</div>
                        <div class="col-xs-7">{{$user->phone}}</div>
                    </div>
                </div>
            </div>

            <div class="">
                <a href="{{route('uw.edit_profile')}}" class="gr_btn"><i class="fa fa-gear"></i> <span>プロフィールを編集する</span></a>
            </div>

        </div>

        <div class="wrap_box">
            <div class="form-group mgb-20">
                <label>メールアドレスを変更する</label>
                <p class="p_show">{{$user->email}}</p>
            </div>
            <div class="">
                <a href="{{route('uw.edit_email')}}" class="gr_btn"><i class="fa fa-gear"></i> <span>メールアドレスを変更する</span></a>
            </div>
        </div>

        <div class="wrap_box">
            <div class="form-group mgb-20">
                <label>パスワード</label>
                <p class="p_show">************</p>
            </div>
            <div class="">
                <a href="{{route('uw.edit_pass')}}" class="gr_btn"><i class="fa fa-gear"></i> <span>メールアドレスを変更する</span></a>
            </div>
        </div>

        <div class="wrap_box">
            <?php 
            $site_id = config('gmo.site_id');
            $site_pass = config('gmo.site_pass');
            $shop_id = config('gmo.shop_id');
            $shop_pass = config('gmo.shop_pass');
            $user = c_auth()->user();
            $dateTime = date('YmdHis');
            ?>
            {!! Form::open(['method' => 'post', 'url' => config('gmo.link').$shop_id.'/Member/Edit', 'id' => 'edit_card_form']) !!}
            <div class="form-group mgb-30">
                <label>クレジットカード情報</label>
                <div class="p_show">
                    <div class="row mgb-5">
                        <div class="col-xs-5 col-sm-3">カード会社</div>
                        <div class="col-xs-7 col-sm-9" id="card_name">....</div>
                    </div>
                    <div class="row mgb-5">
                        <div class="col-xs-5 col-sm-3">カード番号</div>
                        <div class="col-xs-7 col-sm-9" id="card_no">....</div>
                    </div>
                </div>
            </div>
            <div class="mgb-35">
                
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
                
                <button type="button" class="gr_btn" id="check_gmo_member"><i class="fa fa-gear"></i> <span> クレジットカード情報を変更する</span></button>
                
                <div class="hidden mgt-10" id="loading"><i class="fa fa-spinner"></i> Waiting...</div>
            </div>
            {!! Form::close() !!}
        </div>

    </div>
</div>

<script>
    
    (function($){
        console.log('loading credit card ...');
        $.ajax({
           type: 'GET',
           url: '<?php echo route('uw.get_creditcard', ['user_id' => c_auth()->id()]) ?>',
           success: function(data){
               console.log(data);
               if(data.success){
                    $('#card_name').text(data.result.card_name);
                    $('#card_no').text(data.result.card_no);
                }
           },
           error: function(){
               console.log('Network error!');
           }
        });
        
        $('#check_gmo_member').click(function(e){
            e.preventDefault();
            $(this).prop('disabled', true);
            var form = $('#edit_card_form');
            $('#loading').removeClass('hidden');
            $.ajax({
                type: 'POST',
                url: '<?php echo route('uw.gmo.save_member') ?>',
                data: {_token: '<?php echo csrf_token(); ?>'},
                success: function(data){
                    if(data.success || (data.result.ErrInfo === 'E01390010')){
                        console.log(data);
                       form.submit();
                    }else{
                        $('#loading').addClass('hidden');
                       console.log(data); 
                    }
                },
                error: function(err){
                    $('#loading').addClass('hidden');
                    csonole.log(err);
                    return false;
                }
            });
        });
    })(jQuery);
    

</script>

@stop

