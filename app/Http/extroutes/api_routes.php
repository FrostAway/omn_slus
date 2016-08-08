<?php

use Illuminate\Http\Request;
use GMO\Payment\SiteApi;

Route::group(['prefix' => 'api'], function() {
    Route::get('/passports', function() {
        return \App\Models\Passport::all();
    });
    Route::get('/passport/{id}', function($id) {
        return \App\Models\Passport::find($id);
    });
    Route::post('/checkout', function(Request $request) {
        return $request->all();
    });
    Route::any('/result', function(Request $request) {
        $data = $request->all();
        DB::table('checkout')->where('name', 'process')->update(['success' => 1, 'data' => json_encode($data)]);
        var_dump($data);
    });
    Route::get('/checkout-result', function() {
        $item = DB::table('checkout')->where('name', 'process')->where('success', 1)->first();
        if ($item) {
            return response()->json($item);
        } else {
            return response()->json('no data', 422);
        }
    });
    Route::get('/token', function() {
        return csrf_token();
    });

    Route::group(['prefix' => 'gmo'], function() {
        Route::any('/searchCard', function(Request $request) {

            $host = 'https://pt01.mul-pay.jp/payment/';
            $shop_id = 'tshop00017945';
            $shop_pass = 'pfehs4hf';
            $site_id = 'tsite00016814';
            $site_pass = 'h1yhgs4q';
            $member_id = 'memeber_t499';
            $member_name = 'Member Demo';
            $dateTime = date('YmdHis');
            $order_id = 202;
            $amount = 400;
            
            $site = new SiteApi($host, $site_id, $site_pass);
            $data = $site->searchCard($request->get('member_id'), 0);
            
            return $data;
        });
    });
});

