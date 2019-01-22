<?php


/*
|--------------------------------------------------------------------------
| Web Page Routes
|--------------------------------------------------------------------------
|
*/

// Authentication Routes

// All Page related general and admin routes
Route::get('/pages/{page}/{slug?}', 'PageController@show');
Route::group(['prefix' => 'admin'], function () {
    Route::resource('pages', 'PageController')->except(['show']);
});

// All Categories related general and admin routes
Route::get('/categories/{category}/{slug?}', 'CategoryController@show');
Route::get('/api/categories', 'CategoryController@apiIndex')->name('api.categories.index');
Route::group(['prefix' => 'admin'], function () {
    Route::resource('categories', 'CategoryController')->except(['show']);
});

// All Tags related general and admin routes
Route::get('/tags/{tag}/{slug?}', 'TagController@show');
Route::get('/api/tags', 'TagController@apiIndex')->name('api.tags.index');
Route::group(['prefix' => 'admin'], function () {
    Route::resource('tags', 'TagController')->except(['show']);
});

// all modules related routes
Route::group(['prefix' => 'admin'], function () {
    Route::resource('modules', 'ModuleController');
});

// All Tags related general and admin routes
Route::group(['prefix' => 'admin'], function () {
    Route::resource('users', 'UserController');
});

// Route::get('/page/{id}/{slug}', function () {
//     $page = [
//         'id' => 1,
//         'title' => 'Life is a series of baby steps',
//         'summary' => "Don't give it five minutes if you're not going to give it five years.",
//         'body' => "To succeed in life, you need three things: a wishbone, a backbone, and a funny bone. I've failed over and over and over again in my life and that is why I succeed."
//     ];
//     return compiledView('page', $page);
// });

Route::get('/profile/{id}/{slug}', function () {
    return null;
});

Route::get('/admin', function () {return view('admin.home');});

Route::resource('media', 'MediaController');

Route::get('/admin/templates', 'TemplateController@index')->name('templates.index')->middleware('admin');
Route::get('/admin/templates/create', 'TemplateController@create')->name('templates.create')->middleware('admin');
Route::get('/admin/templates/{template}', 'TemplateController@show')->name('templates.show')->middleware('admin');
Route::post('/admin/templates', 'TemplateController@store')->name('templates.store')->middleware('admin');
Route::patch('/admin/templates/{template}', 'TemplateController@update')->name('templates.update')->middleware('admin');

Route::get('/admin/content-types', 'ContentTypeController@index')->name('content-types.index')->middleware('admin');
Route::post('/admin/content-types/{contentTypeTemplate}', 'ContentTypeController@update')->name('content-types.update')->middleware('admin');
Route::get('/admin/settings', 'SettingController@index')->middleware('admin');
Route::patch('/admin/settings', 'SettingController@update')->middleware('admin');


/**
 * Authentication related routes
 */
Auth::routes();
Route::get('/social/login/{provider}', 'SocialLoginController@provider')->name('social.login');
Route::get('/social/login/{provider}/callback', 'SocialLoginController@callback');


Route::get('/home', 'HomeController@index')->name('home');
