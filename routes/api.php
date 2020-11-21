<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Admin\AuthController;

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

Route::group(['middleware' => ['api','checkPassword','changeLanguage'],'namespace' => 'Api'],function () {
    Route::post('get-main-categories', [CategoryController::class,'index']);
    Route::post('get-category-by-id', [CategoryController::class,'getCategoryById']);
    Route::post('change-category-status', [CategoryController::class,'changeStatus']);
   
    Route::group(['prefix' => 'admin','namespace' => 'Admin'],function () {
    Route::post('login', [AuthController::class,'login']);
    });

});

Route::group(['middleware' => ['api','checkPassword','changeLanguage','CheckAdminToken:admin-api'],'namespace' => 'Api'],function () {
    Route::get('offers', 'CategoryController@index');
  });

//   Route::post('get-main-categories', 'app\Http\Controllers\Api\CategoryController@index');

// Route::middleware('checkPassword')->post('/a',function(){
// return 'hi';
// });