<?php


/*
|--------------------------------------------------------------------------
| Web Page Routes
|--------------------------------------------------------------------------
|
*/

// All Page related general and admin routes
Route::get('/pages/{page}/{slug?}', 'PageController@show');
Route::group(['prefix' => 'admin'], function () {
    Route::resource('pages', 'PageController')->except(['show'])->middleware('admin');
});
Route::get('/api/pages', 'PageController@apiGetAll')->name('api.pages.index');
Route::get('/api/pages/{page}', 'PageController@apiGet')->name('api.pages.get');
Route::post('/api/pages/status', 'PageController@apiSetStatus')->name('api.pages.setStatus');

// All Categories related general and admin routes
Route::get('/categories/{category}/{slug?}', 'CategoryController@show');
Route::get('/api/categories', 'CategoryController@apiIndex')->name('api.categories.index');
Route::get('/api/categories/{category}', 'CategoryController@apiGet')->name('api.categories.get');
Route::group(['prefix' => 'admin'], function () {
    Route::resource('categories', 'CategoryController')->except(['show'])->middleware('admin');
});

// All Tags related general and admin routes
Route::get('/tags/{tag}/{slug?}', 'TagController@show');
Route::get('/api/tags', 'TagController@apiIndex')->name('api.tags.index');
Route::group(['prefix' => 'admin'], function () {
    Route::resource('tags', 'TagController')->except(['show'])->middleware('admin');
});

// all modules related routes
Route::group(['prefix' => 'admin'], function () {
    Route::resource('modules', 'ModuleController')->middleware('admin');
});

// All routes (general and admin) related to Users
Route::group(['prefix' => 'admin'], function () {
    Route::resource('users', 'UserController')->middleware('admin');
});

// some special routes related to user
Route::get('/profile/{slug}', 'ProfileController@show')->name('profiles.show');
Route::post('/admin/users/{user}/password', 'ProfileController@changePassword')->name('profiles.password');

// all media related routes
Route::resource('media', 'MediaController')->except(['destroy']);
Route::post('/media/destroy', 'MediaController@destroy')->middleware('auth');

Route::get('/admin/templates', 'TemplateController@index')->name('templates.index')->middleware('admin');
Route::get('/admin/templates/public', 'TemplateController@templates')->name('templates.templates')->middleware('admin');
Route::post('/admin/templates/install', 'TemplateController@install')->name('templates.install')->middleware('admin');
Route::post('/admin/templates/apply', 'TemplateController@apply')->name('templates.apply')->middleware('admin');
Route::get('/admin/templates/{template}', 'TemplateController@form')->name('templates.form')->middleware('admin');
// Route::get('/admin/templates/create/{type}', 'TemplateController@create')->name('templates.create')->middleware('admin');
// Route::get('/admin/templates/{template}', 'TemplateController@show')->name('templates.show')->middleware('admin');
// Route::post('/admin/templates', 'TemplateController@store')->name('templates.store')->middleware('admin');
Route::patch('/admin/templates/{template}', 'TemplateController@update')->name('templates.update')->middleware('admin');

Route::get('/admin/accesses', 'RestrictionController@index')->name('accesses.index')->middleware('admin');
Route::post('/admin/accesses/store', 'RestrictionController@createOrUpdate')->name('accesses.createOrUpdate')->middleware('admin');
// Route::resource('/admin/accesses', 'RestrictionController')->only(['index', 'store'])->middleware('admin');

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

Route::get('/admin', 'HomeController@dashboard')->name('dashboard')->middleware('auth');

Route::post('/api/search', 'SearchController@search')->name('search');

Route::get('/', 'HomeController@index')->name('home');