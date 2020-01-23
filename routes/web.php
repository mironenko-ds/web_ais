<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
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

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/register', function () {
    return redirect()->route('login');
});

Route::post('/register', 'User\UserController@store');

Route::get('/new-user', 'User\UserController@newUser')->name('new.user');
// protected routes

Route::group(['middleware' => 'auth'], function () {
    Route::get('/uploads/{id}/feedback/{hash}/{filename}', function($id, $hash, $fileName){
        return $hash . ' ' . $fileName;
    });
});


Route::group(['middleware' => 'auth'], function () {
    // user pages
    Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
        Route::get('/index', 'UserController@index')->name('user.index');
        Route::get('/account', 'UserController@account')->name('user.account');
        Route::get('/my-work', 'UserController@myWorks')->name('user.works');
        Route::get('/add-work', 'UserController@addWork')->name('user.addWork');
        Route::get('/feedback', 'UserController@feedback')->name('user.feedback');
        Route::get('/work/{id}', 'UserController@work')->name('user.work');
        Route::post('/reset-email', 'UserController@resetEmail')->name('user.resetEmail');
        Route::post('/reset-password', 'UserController@resetPassword')->name('user.resetPass');
        Route::post('/send-message', 'UserController@sendMessage')->name('user.sendMessange');
        Route::post('/message', 'UserController@sendMessageUser')->name('user.sendMessageUser');
        Route::post('/create-work', 'UserController@CreateWork')->name('user.CreateWork');
    });

    // moder pages
    Route::group(['prefix' => 'moderator', 'middleware' => 'moderator'], function(){
        Route::get('/page', function(){
            return 'moderator page';
        });
    });

    // admin pages
    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function(){
        Route::get('/new-user', function(){
            return 'new user';
        });
    });
});
