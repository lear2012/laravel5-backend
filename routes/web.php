<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/**
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'middleware' => ['web', 'wechat.oauth']], function ()
{
    Route::any('/wechat', 'WechatController@serve');

    Route::get('/member_list', 'HomeController@memberList');
    Route::get('/member_register', 'HomeController@memberRegister');
    // about login and logout
    Route::auth();

    Route::get('logout', 'Auth\LoginController@logout');

    // business route
    Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('/', ['as' => 'welcome', 'uses' => 'WelcomeController@index']);
});

//wechat
Route::group(['namespace' => 'Wechat', "prefix" => 'wechat'], function () {

    Route::get('/auth/login',
        ['middleware' => 'wechat.auth', 'as' => 'wechat.to_sign_in', 'uses' => 'AuthController@getLogin']);
    Route::controller('auth', 'AuthController', [
        'postLogin' => 'wechat.sign_in',
        'postRegister' => 'wechat.sign_up',
        'getLogout' => 'wechat.logout',
        'getRegister' => 'wechat.to_sign_up',
        'getAgreement' => 'wechat.agreement',
        'postRegisterFirst' => 'wechat.sign_up_next',
        'getMobileCode' => 'wechat.smscode',
        'getLogout' => 'wechat.logout',
        'getForgetPassword' => 'wechat.to_retrieve_password',
        'postForgetPasswordNext' => 'wechat.to_retrieve_password_next',
        'postRetrievePassword' => 'wechat.retrieve_password',
        'getRetrievePasswordCode' => 'wechat.retrieve_password_code',
        'getAjaxMobileCode' => 'wechat.ajaxcode',
        'getAjaxRetrievePasswordCode' => 'wechat.ajax_retrive_password_code',
    ]);

    Route::get('/', ['as' => 'wechat.index', 'uses' => 'IndexController@getIndex']);
});

/**
 * Backend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Backend'], function () {

    // about login and logout
    Route::group(['prefix' => 'admin'], function ()
    {
        Route::get('login', 'Auth\LoginController@showLoginForm');
        Route::post('login', 'Auth\LoginController@login');
        Route::get('logout', 'Auth\LoginController@logout');
    });

    // need to auth controller
    Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => 'auth.admin'], function ()
    {
        //dashboard
        Route::get('/', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
        Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

        //user
        Route::resource('auth/user', 'UserController', ['as' => 'auth']);
        Route::get('auth/user/change-password/{id}', 'UserController@changePassword');
        Route::post('auth/user/update-password/{id}', ['as' => 'user.update-password', 'uses' => 'UserController@updatePassword']);
        Route::resource('auth/role', 'RoleController', ['as' => 'auth']);
        Route::resource('auth/permission', 'PermissionController', ['as' => 'auth']);

        // 老司机
        Route::get('expdriver/home', ['uses' => 'UserController@expdriverHome', 'as' => 'expdriver.decorate']);
        Route::put('expdriver/home', ['uses' => 'UserController@expdriverHomeStore', 'as' => 'expdriver.decorate.store']);
        //news
        Route::resource('news/category', 'NewsCategoryController', ['as' => 'news']);
        Route::resource('news', 'NewsController');

        //event
        Route::resource('event', 'EventController');

        //album
        Route::resource('album', 'AlbumController');
        Route::get('album/{id}/photos', ['as' => 'album.photos', 'uses' => 'AlbumController@photos']);
        Route::post('album/upload', ['as' => 'album.upload', 'uses' => 'AlbumController@storePhoto']);

        //forum
        //Route::resource('topic/category', 'TopicCategoryController', ['as' => 'topic']);
        Route::resource('topics', 'TopicController');

        //comment
        Route::resource('comment', 'CommentController');

        //page
        Route::resource('page', 'PagesController');

        //upload
        // After the line that reads
        Route::get('upload', 'UploadController@index');

        // Add the following routes
        Route::post('upload/file', ['as' => 'upload.file', 'uses' => 'UploadController@uploadFile']);
        Route::delete('upload/file', 'UploadController@deleteFile');
        Route::post('upload/folder', 'UploadController@createFolder');
        Route::delete('upload/folder', 'UploadController@deleteFolder');
        Route::match(['get', 'post'], 'upload/image', 'UploadController@uploadImage')->name('upload.image');
        Route::match(['get', 'post'], 'upload/avatar', 'UploadController@uploadAvatar')->name('upload.avatar');

        //material
        Route::resource('materials/single', 'MaterialsController');
    });
});
