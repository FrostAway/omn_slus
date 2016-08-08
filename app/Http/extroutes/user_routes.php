<?php

Route::group(['prefix' => 'uw', 'as' => 'uw.', 'namespace' => 'Uw'], function() {
    Route::group(['middleware' => 'throwauth:customer'], function() {
        // Home
        Route::get('/', ['as' => 'home', 'uses' => 'UwController@index']);
        // register, 
        Route::get('/new-registration', ['as' => 'get_reg_mail', 'uses' => 'AuthController@getRegMail']);
        Route::post('/new-registration', ['as' => 'post_reg_mail', 'uses' => 'AuthController@postRegMail']);
        Route::get('/new-register-finish', ['as' => 'fn_reg_mail', 'uses' => 'AuthController@finishRegMail']);
        Route::get('/register', ['as' => 'get_register', 'uses' => 'AuthController@getRegister']);
        Route::post('/register', ['as' => 'post_register', 'uses' => 'AuthController@postRegister']);
        Route::get('/register-finish', ['as' => 'fn_register', 'uses' => 'AuthController@fnRegister']);

        // Reset pass
        Route::get('/forget-password', ['as' => 'get_forget_pass_mail', 'uses' => 'AuthController@getForgetPassMail']);
        Route::post('/forget-password', ['as' => 'post_forget_pass_mail', 'uses' => 'AuthController@postForgetPassMail']);
        Route::get('/forget-password-finish', ['as' => 'fn_forget_pass_mail', 'uses' => 'AuthController@fnForgetPassMail']);
        Route::get('/reset-password', ['as' => 'get_reset_pass', 'uses' => 'AuthController@getResetPass']);
        Route::post('/reset-password', ['as' => 'post_reset_pass', 'uses' => 'AuthController@postResetPass']);
        Route::get('/reset-password-finish', ['as' => 'fn_reset_pass', 'uses' => 'AuthController@fnResetPass']);

        // Login
        Route::get('/login', ['as' => 'get_login', 'uses' => 'AuthController@getLogin']);
        Route::post('/login', ['as' => 'post_login', 'uses' => 'AuthController@postLogin']);
    });

    // Logout
    Route::get('/logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);

    Route::group(['middleware' => 'auth:customer'], function() {
        // Profile
        Route::any('/profile', ['as' => 'profile', 'uses' => 'ProfileController@profile']);
        // Edit mail
        Route::get('/change-email', ['as' => 'edit_email', 'uses' => 'ProfileController@editEmail']);
        Route::post('/update-email', ['as' => 'update_email', 'uses' => 'ProfileController@updateEmail']);
        Route::get('/confirm-change-email', ['as' => 'confirm_edit_email', 'uses' => 'ProfileController@confirmChangeMail']);
        Route::get('/change-email-status', ['as' => 'send_edit_email', 'uses' => 'ProfileController@sendChangeMail']);

        // Edit password
        Route::get('/edit-password', ['as' => 'edit_pass', 'uses' => 'ProfileController@editPassword']);
        Route::post('/update-password', ['as' => 'update_pass', 'uses' => 'ProfileController@updatePassword']);

        // Edit creditcard
        Route::get('/get-creditcard/{user_id}', ['as' => 'get_creditcard', 'uses' => 'ProfileController@getCard'])->where('user_id', '[0-9]+');
        Route::get('/edit-creditcard', ['as' => 'edit_creditcard', 'uses' => 'ProfileController@editCreditCard']);
        Route::post('/update-creditcard', ['as' => 'update_creditcard', 'uses' => 'ProfileController@updateCreditCard']);

        // Edit profile
        Route::get('/edit-profile', ['as' => 'edit_profile', 'uses' => 'ProfileController@editProfile']);
        Route::post('/update-profile', ['as' => 'update_profile', 'uses' => 'ProfileController@updateProfile']);

        // Customer
        Route::get('/mytop', ['as' => 'mytop', 'uses' => 'CustomerController@myTop']);
        Route::post('/passport/purchase', ['as' => 'purchase_passport', 'uses' => 'CustomerController@purchasePassport']);
        Route::get('/passport/{id}', ['as' => 'view_passport', 'uses' => 'CustomerController@showPassport'])->where('id', '[0-9]+');
        
        Route::post('/passport-purchase-finish', ['as' => 'passport_purchase_fn', 'uses' => 'CustomerController@purchasePassportFinish']);
        Route::get('/purchase-history', ['as' => 'purchase_history', 'uses' => 'CustomerController@purchaseHistory']);
        
        Route::get('/change-plan', ['as' => 'change_plan', 'uses' => 'CustomerController@changePlan']);
        Route::post('/update-plan', ['as' => 'update_plan', 'uses' => 'CustomerController@updatePlan']);
        Route::post('/cancel-plan', ['as' => 'cancel_plan', 'uses' => 'CustomerController@cancelPlan']);
        Route::get('/update-plan-finish', ['as' => 'change_plan_fn', 'uses' => 'CustomerController@updatePlanFn']);
        
        Route::group(['prefix' => 'gmo', 'as' => 'gmo.'], function(){
            Route::match(['post', 'get'], '/save-member', ['as' => 'save_member', 'uses' => 'ProfileController@saveMember']);
        });
    });
    
    // Contact form
    Route::get('/contact', ['as' => 'get_contact', 'uses' => 'UwController@getContact']);
    Route::post('/contact', ['as' => 'post_contact', 'uses' => 'UwController@postContact']);
    // Error alert
    Route::get('/errors', ['as' => 'error_mess', 'uses' => 'UwController@errorMess']);
    
});
