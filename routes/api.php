<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\NewsFeedController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Cron\NewsController;
use App\Http\Controllers\News\NewsController as NewsNewsController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api'], function ($routes) {

    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    //New 
    Route::get('/newsfeed', [NewsNewsController::class, 'getNews']);
    Route::post('/search', [NewsNewsController::class, 'getFilteresNews']);

    Route::post('/logout', [LogoutController::class, 'logout']);
});
