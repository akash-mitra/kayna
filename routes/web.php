<?php
use Illuminate\Support\Facades\Storage;
// --------------------------------------------------------------------------------------------------------------------------
// All Page related general and admin routes
// --------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/pages',              'PageController@index')->name('pages.index')->middleware('author');
Route::post('/admin/pages',             'PageController@store')->name('pages.store')->middleware('author');
Route::get('/pages/{page}/{slug?}',     'PageController@show')->name('pages.get')->middleware('web');
Route::get('/admin/pages/create',       'PageController@create')->name('pages.create')->middleware('author');
Route::patch('/admin/pages/{page}',     'PageController@update')->name('pages.update')->middleware('author');
Route::get('/admin/pages/{page}/edit',  'PageController@edit')->name('pages.edit')->middleware('author');
Route::delete('/admin/pages/{page}',    'PageController@destroy')->name('pages.destroy')->middleware('author');
Route::get('/api/pages',                'PageController@apiGetAll')->name('api.pages.index')->middleware('web');
Route::get('/api/pages/{page}',         'PageController@apiGet')->name('api.pages.get')->middleware('author');
Route::post('/api/pages/status',        'PageController@apiSetStatus')->name('api.pages.setStatus')->middleware('web');
// --------------------------------------------------------------------------------------------------------------------------



// --------------------------------------------------------------------------------------------------------------------------
// All Categories related general and admin routes
// --------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/categories',                 'CategoryController@index')->name('categories.index')->middleware('author');
Route::post('/admin/categories',                'CategoryController@store')->name('categories.store')->middleware('admin');
Route::get('/categories/{category}/{slug?}',    'CategoryController@show')->name('categories.get')->middleware('web');
Route::get('/admin/categories/create',          'CategoryController@create')->name('categories.create')->middleware('admin');
Route::patch('/admin/categories/{category}',    'CategoryController@update')->name('categories.update')->middleware('admin');
Route::get('/admin/categories/{category}/edit', 'CategoryController@edit')->name('categories.edit')->middleware('admin');
Route::delete('/admin/categories/{category}',   'CategoryController@destroy')->name('categories.destroy')->middleware('admin');
Route::get('/api/categories',                   'CategoryController@apiGetAll')->name('api.categories.index')->middleware('web');
Route::get('/api/categories/{category}',        'CategoryController@apiGet')->name('api.categories.get')->middleware('web');
// --------------------------------------------------------------------------------------------------------------------------

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
Route::post('/api/users/{slug}', 'UserController@updateAvatar')->name('profiles.updateAvatar');
// some special routes related to user
Route::get('/profile/{slug}', 'ProfileController@show')->name('profiles.show');
Route::post('/admin/users/{user}/password', 'ProfileController@changePassword')->name('profiles.password');

// all media related routes
// Route::group(['prefix' => 'admin'], function () {
//     Route::resource('media', 'MediaController')->middleware('admin');
// });
Route::get('/admin/media', 'MediaController@index')->middleware('auth');
Route::get('/api/media', 'MediaController@apiIndex')->middleware('auth');
Route::post('/admin/media', 'MediaController@store')->middleware('auth');
Route::delete('/admin/media/{media}', 'MediaController@destroy')->middleware('auth');

// --------------------------------------------------------------------------------------------------------------------------
// All Categories related general and admin routes
// --------------------------------------------------------------------------------------------------------------------------
Route::get('/admin/templates', 'TemplateController@index')->name('templates.index')->middleware('admin');
Route::get('/admin/templates/create', 'TemplateController@create')->name('templates.create')->middleware('admin');
Route::get('/admin/templates/{template}/files/{type}', 'TemplateFileController@form')->name('templates.file')->middleware('admin');
Route::get('/admin/templates/{template}', 'TemplateController@edit')->name('templates.edit')->middleware('admin');
Route::post('/admin/templates',    'TemplateController@store')->name('templates.store')->middleware('admin');
Route::post('/admin/templates/{template}/files/{type}', 'TemplateFileController@save')->name('templates.file.save')->middleware('admin');
// Route::get('/admin/templates/public', 'TemplateController@templates')->name('templates.templates')->middleware('admin');
// Route::post('/admin/templates/install', 'TemplateController@install')->name('templates.install')->middleware('admin');
// Route::post('/admin/templates/apply', 'TemplateController@apply')->name('templates.apply')->middleware('admin');
// Route::get('/admin/templates/{template}', 'TemplateController@form')->name('templates.form')->middleware('admin');
// Route::patch('/admin/templates/{template}', 'TemplateController@update')->name('templates.update')->middleware('admin');
// Route::delete('/admin/templates/{template}', 'TemplateController@destroy')->name('templates.destroy')->middleware('admin');
// --------------------------------------------------------------------------------------------------------------------------


Route::get('/admin/accesses', 'RestrictionController@index')->name('accesses.index')->middleware('admin');
Route::post('/admin/accesses/store', 'RestrictionController@createOrUpdate')->name('accesses.createOrUpdate')->middleware('admin');

Route::get('/admin/settings', 'SettingController@index')->middleware('admin');
Route::patch('/admin/settings', 'SettingController@update')->middleware('admin');

/**
 * Authentication related routes
 */
Auth::routes();
Route::get('/social/login/{provider}', 'SocialLoginController@provider')->name('social.login');
Route::get('/social/login/{provider}/callback', 'SocialLoginController@callback');

Route::get('/admin', 'HomeController@dashboard')->name('dashboard')->middleware('admin');
Route::get('/admin/login', 'HomeController@adminLogin')->name('admin.login')->middleware('guest');

Route::post('/api/search', 'SearchController@search')->name('search');

Route::get('/', 'HomeController@index')->name('home');

Route::get('/admin/installation/{step}', 'HomeController@install')->name('installation')->middleware('admin');
Route::post('/admin/installation/{step}', 'HomeController@installProcess')->name('installation-process')->middleware('admin');

Route::post('/admin/cache/app/clear', 'SettingController@clearAppCache')->name('app.cache.clear')->middleware('admin');
