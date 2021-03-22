<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('register', ['\App\Http\Controllers\Api\AuthController', 'register']);
Route::post('login', ['\App\Http\Controllers\Api\AuthController', 'login']);

Route::get('/categories', ['\App\Http\Controllers\Api\CategoryController', 'categoryList']);
Route::get('/posts', ['\App\Http\Controllers\Api\PostController', 'posts']);
Route::get('/post/show', ['\App\Http\Controllers\Api\PostController', 'postShow']);

Route::get('/country/list', ['\App\Http\Controllers\Api\LocationController', 'countryList']);
Route::get('/city/list', ['\App\Http\Controllers\Api\LocationController', 'cityList']);

Route::middleware('auth:api')->group(function () {
    Route::post('/comment/create', ['\App\Http\Controllers\Api\PostController', 'postCommentCreate']);
    Route::get('/comments', ['\App\Http\Controllers\Api\PostController', 'commentsList']);

    Route::post('/user/edit', ['\App\Http\Controllers\Api\UserController', 'userEdit']);
    Route::get('/user/country', ['\App\Http\Controllers\Api\UserController', 'getNativeCountry']);
    Route::post('/user/country', ['\App\Http\Controllers\Api\UserController', 'saveNativeCountry']);

    Route::get('/user/show', ['\App\Http\Controllers\Api\UserController', 'userShow']);
    Route::get('/country_users', ['\App\Http\Controllers\Api\UserController', 'countryUsers']);

    Route::post('/post/create', ['\App\Http\Controllers\Api\PostController', 'postCreate']);
    Route::post('/post/edit', ['\App\Http\Controllers\Api\PostController', 'postEdit']);
    Route::get('/posts/count', ['\App\Http\Controllers\Api\PostController', 'countPosts']);
    Route::get('/posts/wait', ['\App\Http\Controllers\Api\PostController', 'waitedPosts']);
    Route::get('/posts/not_active', ['\App\Http\Controllers\Api\PostController', 'notActivePosts']);
    Route::get('/posts/active', ['\App\Http\Controllers\Api\PostController', 'activePosts']);
    Route::post('/posts/activate', ['\App\Http\Controllers\Api\PostController', 'activatePost']);
    Route::post('/posts/deactivate', ['\App\Http\Controllers\Api\PostController', 'deactivatePost']);
});
