<?php 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Api\MusicController;


Route::group(['middleware' => ['auth:sanctum'],'prefix'=> 'music'],function(){
     Route::post('/insert',[MusicController::class,'insert']);
     Route::put('/update/{music}',[MusicController::class,'update'])->whereNumber('music');
     Route::delete('/delete/{music}',[MusicController::class,'delete'])->whereNumber('music');
});