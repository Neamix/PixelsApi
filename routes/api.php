<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Api\MusicController;
use App\Http\Controllers\Api\playlist;


use App\Http\Controllers\adminController;
use App\Http\Controllers\Api\categoryController;
use App\Http\Controllers\Api\PlaylistController;
use App\Http\Controllers\searchController;
use App\Http\Controllers\userManagment;
use App\Models\category;

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

Route::post('/login',[userManagment::class,'login']);
Route::post('/register',[userManagment::class,'store']);
Route::get('/bundle/{category?}/{limit?}',[MusicController::class,'bundle'])->whereAlpha('category')->whereNumber('limit');
Route::get('/show/{music}',[MusicController::class,'show'])->whereNumber('music');


Route::post('/musics' , [searchController::class ,'index' ]);
Route::post('/musics/{music}' ,[searchController::class ,'show']);


Route::group(['middleware'=>['auth:sanctum']],function(){
     Route::post('/admin/{userid}',[adminController::class,'admin']);
     Route::post('/logout',[userManagment::class,'logout']);
     Route::post('/snip',[userManagment::class,'snip']);
     Route::post('/user',[userManagment::class,'update']);
     Route::post('/password/reset',[userManagment::class,'reset']);
     Route::get('/user/likes',[MusicController::class,'likes']);
     Route::post('/user/like/{music}',[MusicController::class,'like']);
     Route::get('/user/isLike/{music}',[MusicController::class,'isLike']);
});


Route::group(['prefix'=>'category'],function(){
     Route::post('/store',[categoryController::class,'store'])->middleware('auth:sanctum');
     Route::get('/getorder/{order}/{limit?}',[categoryController::class,'getByOrder']);
     Route::get('/getcategory',[categoryController::class,'getCategory']);
     Route::get('/getbyband',[categoryController::class,'getByBand']);
});

