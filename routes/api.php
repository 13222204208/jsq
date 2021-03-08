<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;


Route::prefix('minapp')->group(function (){

    Route::group(['namespace' => 'Minapp\User'], function () {


        Route::post('register', 'RegisterController@register');//用户注册
        Route::post('login', 'LoginController@login');//用户登陆
        Route::post('forgot-password', 'RegisterController@forgotPassword');//忘记密码
        Route::post('upload-img', 'UpdateUserController@uploadImg');//头像上传

        Route::group(['middleware' => 'auth:api'], function () {   
            Route::post('edit/user', 'UpdateUserController@edit');//编辑资料
            
        });
    });

    Route::group(['namespace' => 'Minapp\UserAgreement'], function () {

         Route::get('agreement', 'UserAgreementController@agreement');//用户协议
            
    });

    Route::group(['namespace' => 'Minapp\Contact'], function () {
        Route::post('store/contact', 'ContactUsController@store');//保存联系我们信息
    });

    Route::group(['namespace' => 'Minapp\Consult'], function () {
        Route::get('consult', 'ConsultController@consult');//参考列表
    });

    Route::group(['namespace' => 'Minapp\Pay'], function () {
        
        Route::group(['middleware' => 'auth:api'], function () {   
            Route::post('pay/member', 'PayController@payMember');//开通会员
            
        });
    });


    Route::group(['namespace' => 'Minapp\Team'], function () {

        Route::group(['middleware' => 'auth:api'], function () {   
            Route::get('team', 'TeamController@team');//团队列表
            Route::post('join-team', 'TeamController@joinTeam');//申请加入团队
            Route::get('my-team', 'TeamController@myTeam');//我的团队列表
            Route::post('team-kick', 'TeamController@teamKick');//踢出成员

            Route::get('team-privacy', 'TeamPrivacyController@teamPrivacy');//团队隐私

        });
    });

    Route::group(['namespace' => 'Minapp\Notice'], function () {
        
        Route::group(['middleware' => 'auth:api'], function () {   
            Route::get('msg-notice', 'NoticeController@msgNotice');//获取消息通知
            Route::get('notice-count', 'NoticeController@noticeCount');//获取消息通知数量
        });
    });


    Route::group(['namespace' => 'Minapp\Invite'], function () {
        
        Route::group(['middleware' => 'auth:api'], function () {   
            Route::get('member-list', 'InviteMemberController@memberList');//获取邀请新成员列表
            Route::post('invite-member', 'InviteMemberController@inviteMember');//邀请新成员
            Route::post('consent', 'InviteMemberController@consent');//是否同意申请

        });
    });

    Route::group(['namespace' => 'Minapp\Notepad'], function () {
        
        Route::group(['middleware' => 'auth:api'], function () {   
            Route::get('notepad-list', 'NotepadController@notepadList');//获取邀请新成员列表
            Route::post('store-notepad', 'NotepadController@storeNotepad');//添加记事本

        });
    });

    Route::group(['namespace' => 'Minapp\Triage'], function () {
        
        Route::group(['middleware' => 'auth:api'], function () {   
            
            Route::post('store-triage', 'TriageController@storeTriage');//添加检伤分类

        });
    });

    
    Route::group(['namespace' => 'Minapp\UserGuide'], function () {
        
        Route::get('user-guide', 'UserGuideController@userGuide');//用户指南
 
    });

    Route::group(['namespace' => 'Minapp\Position'], function () {
        
        Route::group(['middleware' => 'auth:api'], function () {   
            
            Route::post('store-position', 'PositionController@storePosition');//设置位置
            Route::post('position', 'PositionController@position');//更新或删除标记
            Route::get('position-list', 'PositionController@positionList');//标记列表
            Route::get('filter-position', 'PositionController@filterPosition');//筛选标记
        });
 
    });

    Route::group(['namespace' => 'Minapp\Tab'], function () {
        Route::get('tab-color', 'TabController@tabColor');//用户标记图片
        Route::group(['middleware' => 'auth:api'], function () {   
            
            Route::get('tab-type', 'TabController@tabType');//标记分类
        
        });
 
    });

});


Route::prefix('admin')->group(function (){

    Route::post('upload/img', 'UploadImgController@uploadImg');//图片上传
    Route::post('upload/content/img', 'UploadImgController@uploadContentImg');//图片上传

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

    Route::group(['namespace' => 'Admin\TabColor'], function () {

        Route::group(['middleware' => 'auth:admin'], function () {   
            
            Route::resource('tab-color', 'TabColorController');//用户标记
                   
        });
    });

    Route::group(['namespace' => 'Admin\Consult'], function () {

        Route::group(['middleware' => 'auth:admin'], function () {   
            
            Route::resource('consult-type', 'ConsultTypeController');//参考类型

            Route::resource('consult', 'ConsultController');//参考内容      
        });
    });

    Route::group(['namespace' => 'Admin\Team'], function () {

        Route::group(['middleware' => 'auth:admin'], function () {   
            Route::resource('team', 'TeamController');//组织团队 
            
            Route::resource('team-privacy', 'TeamPrivacyController');//开通会员页面团队隐私
            
        });
    });

    Route::group(['namespace' => 'Admin\Notepad'], function () {

        Route::group(['middleware' => 'auth:admin'], function () {   
            Route::resource('notepad', 'NotepadController');//记事本
        });
    });

    Route::group(['namespace' => 'Admin\Triage'], function () {

        Route::group(['middleware' => 'auth:admin'], function () {   
            Route::resource('triage', 'TriageController');//检伤分类
        });
    });

    Route::group(['namespace' => 'Admin\UserGuide'], function () {

        Route::group(['middleware' => 'auth:admin'], function () {   
            Route::resource('user-guide', 'UserGuideController');//用户指南
        });
    });

    Route::group(['namespace' => 'Admin\Tab'], function () {

        Route::group(['middleware' => 'auth:admin'], function () {   
            Route::resource('tab', 'TabController');//标记
        });
    });

    Route::group(['namespace' => 'Admin\Position'], function () {

        Route::group(['middleware' => 'auth:admin'], function () {   
            Route::resource('position', 'PositionController');//设置位置列表
        });
    });

    Route::group(['namespace' => 'Admin\Admin'], function () {

        Route::group(['middleware' => 'auth:admin'], function () {   
            Route::resource('admin', 'AdminController');//后台帐号
        });
    });

    Route::group(['namespace' => 'Admin\User'], function () {

        Route::group(['middleware' => 'auth:admin'], function () {   
            Route::resource('user', 'UserController');//app用户帐号
        });
    });

});



