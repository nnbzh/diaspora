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

Route::post('/post/complain', function() {
    // set_time_limit(0);
    // $a =  \App\Models\ChatModel::get();
    // // return $a;
    // foreach ($a as $k => $v) {
    //     $v->chat_name = 'Kazakhstan - '.$v->chat_name;
    //     $v->save();
    // }
    // echo 1;
    \App\Models\RequestModel::where('id', $req->post_id)
	->update(['status' => 0]);
    return ['message' => true];
});

Route::post('register', ['\App\Http\Controllers\Api\AuthController', 'register']);
Route::post('login', ['\App\Http\Controllers\Api\AuthController', 'login']);
Route::post('/reset_password', ['\App\Http\Controllers\Api\AuthController', 'resetPassword']);
Route::post('/reset_password/check_code', ['\App\Http\Controllers\Api\AuthController', 'resetPasswordCheckCode']);

Route::get('/categories', ['\App\Http\Controllers\Api\CategoryController', 'categoryList']);
Route::get('/posts', ['\App\Http\Controllers\Api\PostController', 'posts']);
Route::get('/post/show', ['\App\Http\Controllers\Api\PostController', 'postShow']);
Route::post('/post/seen/incr', ['\App\Http\Controllers\Api\PostController', 'postSeenIncr']);

Route::get('/country/list', ['\App\Http\Controllers\Api\LocationController', 'countryList']);
Route::get('/city/list', ['\App\Http\Controllers\Api\LocationController', 'cityList']);

Route::get('/maritial_statues', ['\App\Http\Controllers\Api\UserController', 'maritial_statues']);

Route::middleware('auth:api')->group(function () {
    Route::post('/comment/create', ['\App\Http\Controllers\Api\PostController', 'postCommentCreate']);
    Route::get('/comments', ['\App\Http\Controllers\Api\PostController', 'commentsList']);

    Route::get('/my_profile', ['\App\Http\Controllers\Api\UserController', 'myProfile']);
    Route::post('/account/stop', ['\App\Http\Controllers\Api\UserController', 'accountStop']);

    Route::post('/user/edit', ['\App\Http\Controllers\Api\UserController', 'userEdit']);
    Route::get('/user/country', ['\App\Http\Controllers\Api\UserController', 'getNativeCountry']);
    Route::post('/user/country', ['\App\Http\Controllers\Api\UserController', 'saveNativeCountry']);
    Route::post('/device_token/create',  ['\App\Http\Controllers\Api\UserController', 'create_device_token']);
    Route::post('/user/block',  ['\App\Http\Controllers\Api\UserController', 'user_block']);
    Route::post('/user/unlock',  ['\App\Http\Controllers\Api\UserController', 'user_unlock']);
    Route::get('/blocked_users', ['\App\Http\Controllers\Api\UserController', 'blocked_users']);


    Route::get('/country/chat', ['\App\Http\Controllers\Api\ChatController', 'getCountryChat']);
    Route::get('/chats', ['\App\Http\Controllers\Api\ChatController', 'getChats']);
    Route::post('/chat/run', ['\App\Http\Controllers\Api\ChatController', 'chatRun']);
    Route::get('/chat/messages', ['\App\Http\Controllers\Api\ChatController', 'getChatMessages']);
    Route::post('/chat/send_message', ['\App\Http\Controllers\Api\ChatController', 'countryChatSendMessage']);
    Route::get('/chat/not_read_count', ['\App\Http\Controllers\Api\ChatController', 'notReadCount']);
    Route::post('/chat/is_read', ['\App\Http\Controllers\Api\ChatController', 'chatIsRead']);
    Route::post('/chat/save_image', ['\App\Http\Controllers\Api\ChatController', 'chatSaveImage']);
    Route::post('/chat/liked', ['\App\Http\Controllers\Api\ChatController', 'chatLiked']);
    Route::get('/chat/users', ['\App\Http\Controllers\Api\ChatController', 'chatUsers']);


    Route::get('/user/show', ['\App\Http\Controllers\Api\UserController', 'userShow']);
    Route::post('/user/avatar/change', ['\App\Http\Controllers\Api\UserController', 'userAvatarChange']);
    Route::delete('/user/avatar/delete', ['\App\Http\Controllers\Api\UserController', 'userAvatarDelete']);
    Route::get('/country_users', ['\App\Http\Controllers\Api\UserController', 'countryUsers']);

    Route::get('/posts/liked', ['\App\Http\Controllers\Api\PostController', 'likedPosts']);
    Route::post('/post/liked/add', ['\App\Http\Controllers\Api\PostController', 'likedPostCreate']);
    Route::delete('/post/liked/delete', ['\App\Http\Controllers\Api\PostController', 'likedPostDestroy']);

    Route::post('/post/create', ['\App\Http\Controllers\Api\PostController', 'postCreate']);
    Route::post('/post/edit', ['\App\Http\Controllers\Api\PostController', 'postEdit']);
    Route::delete('/post/delete', ['\App\Http\Controllers\Api\PostController', 'postDelete']);

    Route::post('/post/avatar/change', ['\App\Http\Controllers\Api\PostController', 'postAvatarChange']);
    Route::post('/post/image/add', ['\App\Http\Controllers\Api\PostController', 'postImageAdd']);
    Route::delete('/post/image/delete', ['\App\Http\Controllers\Api\PostController', 'postImageDelete']);

    Route::get('/posts/count', ['\App\Http\Controllers\Api\PostController', 'countPosts']);
    Route::get('/posts/wait', ['\App\Http\Controllers\Api\PostController', 'waitedPosts']);
    Route::get('/posts/not_active', ['\App\Http\Controllers\Api\PostController', 'notActivePosts']);
    Route::get('/posts/active', ['\App\Http\Controllers\Api\PostController', 'activePosts']);
    Route::post('/posts/activate', ['\App\Http\Controllers\Api\PostController', 'activatePost']);
    Route::post('/posts/deactivate', ['\App\Http\Controllers\Api\PostController', 'deactivatePost']);
});
