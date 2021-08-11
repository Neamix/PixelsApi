<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlaylistController;


Route::group(['middleware' => ['auth:sanctum'],'prefix'=>'playlist'],function(){
    Route::post('/create',[PlaylistController::class,'create']);
    Route::post('/show',[PlaylistController::class,'show']);
    Route::put('/update/{playlist}',[PlaylistController::class,'update'])->whereNumber('playlist');
    Route::delete('/delete/{playlist}',[PlaylistController::class,'delete'])->whereNumber('playlist');
    Route::post('/add',[PlaylistController::class,'add'])->whereNumber('playlistid','musicid');
    Route::post('/getplaylist',[PlaylistController::class,'getPlaylist']);
});