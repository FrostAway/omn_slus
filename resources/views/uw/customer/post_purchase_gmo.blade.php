<meta charset="utf-8">
<!--<div id="status">Waiting...</div>-->
<form method="post" class="hidden" id="purchase_target_form" action="{{$link.$shop_id.'/Multi/Entry'}}">

    <input type="hidden" name="ShopID" value="{{$shop_id}}">
    <input type="hidden" name="OrderID" value="{{$order_id}}">
    <input type="hidden" name="Amount" value="{{$passport->price}}">
    <input type="hidden" name="Tax" value="{{$tax}}">
    <input type="hidden" name="ShopPassString" value="{{$shop_pass_string}}">
    <input type="hidden" name="RetURL" value="{{route('uw.passport_purchase_fn')}}">
    <input type="hidden" name="CancelURL" value="{{route('uw.passport_purchase_fn')}}">
    <input type="hidden" name="DateTime" value="{{$date_time}}">
    <input type="hidden" name="SessionTimeout" value="1800">
    <input type="hidden" name="ClientField1" value="{{'slorn_gmo_'.$user->id}}">
    <input type="hidden" name="ClientField2" value="{{$user->email}}">
    <input type="hidden" name="ClientField3" value="{{$passport->id}}">
    <input type="hidden" name="Confirm" value="1">
    <input type="hidden" name="UseCredit" value="1">
    <input type="hidden" name="JobCd" value="CAPTURE">
    <input type="hidden" name="TemplateNo" value="1">
    <input type="hidden" name="SiteID" value="{{$site_id}}">
    <input type="hidden" name="ItemCode" value="">
    <input type="hidden" name="MemberID" value="{{'slorn_gmo_'.$user->id}}">
    <input type="hidden" name="MemberPassString" value="{{$member_pass_string}}">
</form>

<script src="/js/jquery.min.js"></script>

<script>
    (function($){
        $('#purchase_target_form').submit();
//        $.ajax({
//            type: 'POST',
//            dataType: 'json',
//            url: '<?php // echo route('uw.gmo.save_member') ?>',
//            data: {_token: '<?php // echo csrf_token(); ?>'},
//            success: function(data){
//                if(data.success || (data.result.ErrInfo === 'E01390010')){
//                    $('#status').html('OK');
//                   $('#purchase_target_form').submit();
//                }else{
//                    $('#status').html('<?php // echo trans('message.na_error') ?>');
//                    window.location.href = '<?php // echo route('uw.mytop'); ?>';
//                }
//            },
//            error: function(err){
//                console.log(err);
//                window.location.href = '<?php // echo route('uw.mytop'); ?>';
//            }
//        });
    })(jQuery);
</script>

