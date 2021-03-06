<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Api\MusicController;
use App\Http\Controllers\Api\playlist;


use App\Http\Controllers\adminController;
use App\Http\Controllers\Api\PlaylistController;
use App\Http\Controllers\userManagment;
use App\Models\Music;

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

Route::post('/login',[userManagment::class,'index']);
Route::post('/register',[userManagment::class,'store']);
Route::get('/test',[userManagment::class,'test']);
Route::get('/bundle/{category?}/{limit?}',[MusicController::class,'bundle'])->whereAlpha('category')->whereNumber('limit');
Route::get('/show/{music}',[MusicController::class,'show'])->whereNumber('music');

Route::get('/musics' , [searchController::class ,'index' ]);
Route::get('/musics/{music}' ,[searchController::class ,'show']);


Route::group(['middleware' => ['auth:sanctum'],'prefix'=> 'music'],function(){
     Route::post('/insert',[MusicController::class,'insert']);
     Route::put('/update/{music}',[MusicController::class,'update'])->whereNumber('music');
     Route::delete('/delete/{music}',[MusicController::class,'delete'])->whereNumber('music');
});


Route::group(['middleware' => ['auth:sanctum'],'prefix'=>'playlist'],function(){
     Route::post('/create',[PlaylistController::class,'create']);
     Route::post('/show',[PlaylistController::class,'show']);
     Route::put('/update/{playlist}',[PlaylistController::class,'update'])->whereNumber('playlist');
     Route::delete('/delete/{playlist}',[PlaylistController::class,'delete'])->whereNumber('playlist');
     Route::post('/add',[PlaylistController::class,'add'])->whereNumber('playlistid','musicid');
     Route::post('/getplaylist',[PlaylistController::class,'getPlaylist']);
});

Route::group(['middleware'=>['auth:sanctum']],function(){
     Route::post('/admin/{userid}',[adminController::class,'admin']);
     Route::post('/logout',[userManagment::class,'logout']);
     Route::post('/snip',[userManagment::class,'snip']);
     Route::post('/user/{user}',[userManagment::class,'update']);
     Route::get('/user/likes',[MusicController::class,'likes']);
     Route::post('/user/like/{music}',[MusicController::class,'like']);
     Route::get('/user/isLike/{music}',[MusicController::class,'isLike']);
});

