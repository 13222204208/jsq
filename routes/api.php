<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('minapp')->group(function (){

    Route::group(['namespace' => 'Minapp\User'], function () {

        Route::post('register', 'RegisterController@register');//用户注册
        Route::post('login', 'LoginController@login');//用户登陆
        
        Route::group(['middleware' => 'auth:api'], function () {   
            Route::post('update/user', 'UpdateUserController@update');//编辑资料
            
        });
    });

    Route::group(['namespace' => 'Minapp\Contact'], function () {
        Route::post('store/contact', 'ContactUsController@store');//保存联系我们信息
    });

    Route::group(['namespace' => 'Minapp\Consult'], function () {
        Route::get('consult', 'ConsultController@consult');//参考列表
    });

    Route::group(['namespace' => 'Minapp\Pay'], function () {
        
        Route::group(['middleware' => 'auth:api'], function () {   
            Route::post('pay/member', 'PayController@payMember');//
            
        });
    });

});


Route::prefix('admin')->group(function (){

    Route::post('upload/img', 'UploadImgController@uploadImg');//图片上传

    Route::group(['namespace' => 'Admin\Login'], function () {

        Route::post('login','LoginController@login');//登录

        Route::post('logout','LoginController@logout');//登出

        Route::group(['middleware' => 'auth:admin'], function () {
            Route::get('info','LoginController@info');//获取后台登陆信息      
        });
    });

    Route::group(['namespace' => 'Admin\Contact'], function () {

        Route::group(['middleware' => 'auth:admin'], function () {   
            
            Route::resource('contact-us', 'ContactUsController');//联系我们
            
            
        });
    });

    Route::group(['namespace' => 'Admin\UserAgreement'], function () {

        Route::group(['middleware' => 'auth:admin'], function () {   
            
            Route::resource('agreement', 'UserAgreementController');//用户协议
                   
        });
    });

    Route::group(['namespace' => 'Admin\Consult'], function () {

        Route::group(['middleware' => 'auth:admin'], function () {   
            
            Route::resource('consult-type', 'ConsultTypeController');//参考类型

            Route::resource('consult', 'ConsultController');//参考内容      
        });
    });

});



