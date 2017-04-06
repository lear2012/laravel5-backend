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
Route::any('/wechat', '\App\Http\Controllers\Frontend\WechatController@serve');
Route::post('/wechat/notify', ['as' => 'wechat.notify', 'uses' => '\App\Http\Controllers\Frontend\WechatController@notify'])->middleware(['web']);
Route::get('/sya', '\App\Http\Controllers\Frontend\WechatController@vehicleInfoCrawler');
Route::get('/get_brands', ['as' => 'get_brands', 'uses' => '\App\Http\Controllers\Frontend\WechatController@getBrands']);
Route::get('/cap_brands', ['as' => 'cap_brands', 'uses' => '\App\Http\Controllers\Frontend\WechatController@capBrands']);
Route::get('/get_series/{code}', ['as' => 'get_series', 'uses' => '\App\Http\Controllers\Frontend\WechatController@getSeries']);
Route::get('/get_models/{code}', ['as' => 'get_models', 'uses' => '\App\Http\Controllers\Frontend\WechatController@getModels']);
Route::group(['namespace' => 'Frontend', 'middleware' => ['web', 'wechat.oauth:snsapi_userinfo']], function ()
{
    Route::group(['prefix' => 'wechat'], function ()
    {
        Route::get('login', 'Auth\LoginController@showLoginForm');
        Route::post('login', 'Auth\LoginController@login');

        Route::get('member_list', ['as' => 'wechat.member_list', 'uses' => 'WechatController@memberList']);
        Route::get('register', ['as' => 'wechat.member_register', 'uses' => 'WechatController@memberRegister']);
        Route::post('register', ['as' => 'wechat.post_register', 'uses' => 'WechatController@memberRegister']);
        Route::get('member_pay', ['as' => 'wechat.member_pay', 'uses' => 'WechatController@memberPay']);

        Route::get('checkImgCode', ['as' => 'wechat.check_imgcode', 'uses' => 'WechatController@checkImgCode']);
        Route::get('sendSms', ['as' => 'wechat.send_sms', 'uses' => 'WechatController@sendSms']);
        Route::post('verify_id', ['as' => 'wechat.verify_id', 'uses' => 'WechatController@verifyId']);

        Route::get('profile/{id}', ['as' => 'wechat.profile', 'uses' => 'WechatController@profile']);
        Route::get('edit_profile', ['as' => 'wechat.edit_profile', 'uses' => 'WechatController@editProfile']);
        Route::post('save_profile', ['as' => 'wechat.save_profile', 'uses' => 'WechatController@saveProfile']);
        Route::get('join_club', ['as' => 'wechat.join_club', 'uses' => 'WechatController@joinClub']);
        Route::post('get_invitation_payconfig', ['as' => 'wechat.get_invitation_payconfig', 'uses' => 'WechatController@getInvitationPayconfig']);
        Route::get('logout', 'Auth\LoginController@logout');

    });
    // business route
    Route::get('/', ['as' => 'welcome', 'uses' => 'HomeController@index']);
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
