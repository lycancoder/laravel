<?php
/**
 * 后台路由
 * User: Lycan
 * Date: 2018/10/30
 * Time: 22:24
 */

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('/captcha', 'PublicController@captcha')->name('admin.public.captcha');
    Route::get('/iconChar', 'PublicController@iconChar')->name('admin.public.iconChar');
    Route::get('/login', 'IndexController@login')->name('admin.index.login');
    Route::post('/checkLogin', 'IndexController@checkLogin')->name('admin.index.checkLogin');
    Route::get('/welcome', 'IndexController@welcome')->name('admin.index.welcome');

    Route::group(['middleware' => 'adminCheckLogin'], function () {
        Route::get('/', 'IndexController@index')->name('admin.index.index');
        Route::get('/logout', 'IndexController@logout')->name('admin.index.logout');
        Route::get('/leftNav', 'NavController@leftNav')->name('admin.nav.leftNav');
        Route::get('/leftNavTable', 'NavController@leftNavTable')->name('admin.nav.leftNavTable');
        Route::get('/leftNavTableData', 'NavController@leftNavTableData')->name('admin.nav.leftNavTableData');
        Route::get('/leftNavEdit', 'NavController@leftNavEdit')->name('admin.nav.leftNavEdit');
        Route::get('/groupPage', 'UserController@groupPage')->name('admin.user.groupPage');
        Route::get('/groupPageData', 'UserController@groupPageData')->name('admin.user.groupPageData');
        Route::get('/groupEdit', 'UserController@groupEdit')->name('admin.user.groupEdit');
        Route::get('/permission', 'NavController@permission')->name('admin.nav.permission');
        Route::get('/userPage', 'UserController@userPage')->name('admin.user.userPage');
        Route::get('/userPageData', 'UserController@userPageData')->name('admin.user.userPageData');
        Route::get('/userEdit', 'UserController@userEdit')->name('admin.user.userEdit');
        Route::get('/userLoginLogPage', 'UserController@userLoginLogPage')->name('admin.user.userLoginLogPage');
        Route::get('/userLoginLogPageData', 'UserController@userLoginLogPageData')->name('admin.user.userLoginLogPageData');
        Route::get('/userChangePassword', 'UserController@userChangePassword')->name('admin.user.userChangePassword');
        Route::post('/userChangePasswordSubmit', 'UserController@userChangePasswordSubmit')->name('admin.user.userChangePasswordSubmit');

        Route::group(['middleware' => 'adminUserPermission'], function () {
            Route::post('/leftNavEditSubmit', 'NavController@leftNavEditSubmit')->name('admin.nav.leftNavEditSubmit');
            Route::post('/updateTarget', 'NavController@updateTarget')->name('admin.nav.updateTarget');
            Route::post('/updateStatus', 'NavController@updateStatus')->name('admin.nav.updateStatus');
            Route::post('/updateSort', 'NavController@updateSort')->name('admin.nav.updateSort');
            Route::post('/delData', 'NavController@delData')->name('admin.nav.delData');

            Route::post('/updateGroupSort', 'UserController@updateGroupSort')->name('admin.user.updateGroupSort');
            Route::post('/delUserGroupData', 'UserController@delUserGroupData')->name('admin.user.delUserGroupData');
            Route::post('/groupEditSubmit', 'UserController@groupEditSubmit')->name('admin.user.groupEditSubmit');
            Route::post('/saveUserGroupPermission', 'NavController@saveUserGroupPermission')->name('admin.nav.saveUserGroupPermission');

            Route::post('/updateUserSort', 'UserController@updateUserSort')->name('admin.user.updateUserSort');
            Route::post('/updateUserStatus', 'UserController@updateUserStatus')->name('admin.user.updateUserStatus');
            Route::post('/delUserData', 'UserController@delUserData')->name('admin.user.delUserData');
            Route::post('/resetUserPassword', 'UserController@resetUserPassword')->name('admin.user.resetUserPassword');
            Route::post('/userEditSubmit', 'UserController@userEditSubmit')->name('admin.user.userEditSubmit');
        });
    });
});