<?php

use Illuminate\Http\Request;

Route::get('/files/dialog', function() {
    return view('files.dialog');
});
Route::group(['prefix' => 'test'], function() {
    Route::get('/editor', function() {
        return view('test.editor');
    });

    Route::post('/upload', function(Request $request) {
        $results = [];
        if ($request->hasFile('files')) { 
            $files = $request->file('files');
            foreach ($files as $file) {
                $results[] = $file->getClientOriginalName();
            }
        }
        return response()->json($results);
    });

    Route::get('/gift/{shopid}', function($shopid) {

//        $start = microtime(true);
//        for ($i = 0; $i < 100; $i++) {
////            $result = App\Models\Customer::all();
//            $result = DB::table('customers')->get();
////            $result = DB::select(DB::raw("
////        SELECT g.*, i.url as gifts_images_url
////        FROM gifts_shops gs
////          JOIN gifts g ON g.id = gs.gift_id AND g.delflag = 0
////          LEFT JOIN images i ON g.image_id = i.id AND i.delflag = 0
////        WHERE gs.shop_id = :shop_id AND g.issuer_type != 10 AND  (g.validterm_method = 0 OR (g.validterm_method = 1 AND g.valid_to >= CURRENT_DATE))
////        AND gs.delflag = 0
////                "), ['shop_id' => $shopid]);
//        }
//        $finish = microtime(true);
//        echo $finish - $start;
//        dd($result);
    });

    Route::get('/menus', function() {
        return view('test.menu');
    });
    
    Route::get('/messages/', function(){
       return view('test.message'); 
    });
    Route::get('/messages/event', function(Request $request){
        $mess = $request->get('mess');
        $ip = $request->ip();
        event(new \App\Events\MessageCreated($ip.': '.$mess)); 
        return '0k';
    });
    
    Route::get('/purchased-passport', function(){
       echo '0k';
       event(new \App\Events\PurchasedPassPort(1));
    });
});
