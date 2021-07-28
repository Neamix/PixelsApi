<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\music;
use App\Models\musicPlaylist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MusicController extends Controller
{  
    public function insert(Request $request) 
    {

      $validation = Validator::make($request->all(),[
        'name' => 'required|min:3',
        'band' => 'required|min:3',
        'src'  => 'required',
        'popularity' => 'numeric',
        'release_date' => 'date'
      ]);

      if($validation->fails()) {
        return response()->json([
            'message' => 'fail',
            'validFailsMessage'=>$validation->messages()
        ]);
      }

      music::create([
        'name' => $request->name,
        'band' => $request->band,
        'src'  => $request->src,
        'img'  => $request->img,
        'popularity' => 0,
        'release_date' => $request->release_date ?? null
      ]);

      return response()->json([
          'message' => 'success'
      ]);
   }
   public function bundle($category = 'popularity',$limit = 100) {
       $musics = DB::select("select * from musics order by $category limit $limit");
       return $musics;
   }

   public function show(music $music)
    {
       return response()->json([
           'message' => 'success',
           'music' => $music
       ]);
   }

   public function update(music $music,Request $request) 
   {
      $music->fill($request->all())->save();
      return response()->json([
        'message' => 'success'
      ]);
   }

   public function delete(music $music) {
       musicPlaylist::where(['music_id' => $music->id])->delete();
       $music->delete();
       return response()->json([
        'message' => 'success'
      ]);
   }


}
