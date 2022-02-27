<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Mail\consultationMail;
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






Route::get('/polzovatelskoye-soglasheniye', function(){
    return view('agreement');
});
Route::get('/', fn() => view('Auth.news'));
Route::get('/admin/login', 'App\Http\Controllers\Auth\LoginController@index')->name('AdminLogin');
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@authenticate')->name('AdminAuth');

Route::get('/support', fn() => view('support'));
Route::post('/send', function(Request $request){
        $mailData = array(
            'login'     => $request['login'],
            'text'     => $request['text'],
           );
           Mail::to('aimasha1980n@gmail.com')->send(new consultationMail($mailData));
           return '<h1>Email Sent</h1>';
});
Route::middleware('\App\Http\Middleware\AdminMiddleware::class')->prefix('admin')->group(function (){
    Route::get('/', 'App\Http\Controllers\DashboardController@index')->name('dashboard');

    Route::get('/ads', 'App\Http\Controllers\Request\RequestController@postIndex')->name('ads');
    Route::post('/ads/updateStatus/{id}', 'App\Http\Controllers\Request\RequestController@updatePostStatus')->name('updatePostStatus');

    Route::get('/inquiries', 'App\Http\Controllers\Request\RequestController@index')->name('inquiries');
    Route::post('/inquiries/update/{id}', 'App\Http\Controllers\Request\RequestController@AcceptRejectPost')->name('AcceptOrRejectPost');

    Route::get('/users', 'App\Http\Controllers\User\UserController@index')->name('users');
    Route::post('/users/{id}', 'App\Http\Controllers\User\UserController@updateStatus')->name('updateStatus');

    Route::get('/countries', 'App\Http\Controllers\Country\CountryController@index')->name('countries');
    Route::post('/country/store', 'App\Http\Controllers\Country\CountryController@store')->name('storeCountry');
    Route::post('/country/edit/{id}', 'App\Http\Controllers\Country\CountryController@update')->name('updateCountry');
    Route::post('/country/destroy/{id}', 'App\Http\Controllers\Country\CountryController@destroy')->name('deleteCountry');

    Route::get('/cities', 'App\Http\Controllers\City\CityController@index')->name('cities');
    Route::post('/cities/store', 'App\Http\Controllers\City\CityController@store')->name('storeCityAndChat');
    Route::post('/cities/edit/{id}', 'App\Http\Controllers\City\CityController@update')->name('updateCity');
    Route::post('/cities/destroy/{id}', 'App\Http\Controllers\City\CityController@destroy')->name('deleteCity');

    Route::get('/chats', 'App\Http\Controllers\Chat\ChatController@index')->name('chats');
    Route::post('/chat/store', 'App\Http\Controllers\Chat\ChatController@store');
    Route::post('/chat/edit/{id}', 'App\Http\Controllers\Chat\ChatController@update');
    Route::post('/chat/destroy/{id}', 'App\Http\Controllers\Chat\ChatController@destroy');

    Route::get('/categories', 'App\Http\Controllers\Category\CategoryController@index')->name('categories');
    Route::post('/categories/store', 'App\Http\Controllers\Category\CategoryController@store')->name('storeCategory');
    Route::post('/categories/edit/{id}', 'App\Http\Controllers\Category\CategoryController@edit')->name('editCategory');
    Route::post('/categories/{id}', 'App\Http\Controllers\Category\CategoryController@updateStatusCategory')->name('updateStatusCategory');


    Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
});
