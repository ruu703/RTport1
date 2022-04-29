<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// ログイン必須のルーティンググループ
Route::group(['middleware' => 'auth'], function(){
    Route::get('/mypage', 'BaseController@mypage')->name('mypage');
    Route::get('/projectform/{any?}', 'ProjectFormController')->where('any', '.*')->name('projectform');
    Route::get('/profileform/{any?}', 'ProfileFormController')->where('any', '.*')->name('profileform');
    Route::get('/message/{id?}', 'BaseController@message')->where('id', '.*')->name('message');
    Route::get('/verification/{id}', 'BaseController@projectVerification')->name('verification');
    Route::post('/verification/', 'BaseController@postApplication')->name('application');
});

Route::get('/', 'BaseController@index')->name('index');
Route::get('/search' ,'BaseController@search')->name('search');
Route::get('/project/{id}', 'BaseController@project')->name('project');
Route::get('/profile/{id}', 'BaseController@profile')->name('profile');
Route::get('/term', 'BaseController@term')->name('term');
Route::get('/privacy', 'BaseController@privacy')->name('privacy');


