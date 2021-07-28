<?php

namespace App\Http\Controllers\Api;

use App\Models\playlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\musicPlaylist;
use Illuminate\Support\Facades\Validator;

class PlaylistController extends Controller
{
   public function create(Request $request)
   {
       $validation = Validator::make($request->all(),[
          'name' => 'required|min:3'
       ]);

       if($validation->fails()) {
            return response()->json([
                'message' => 'fail',
                'validFailsMessage'=>$validation->messages()
            ]);
       }

       playlist::create([
           'name' => $request->name
       ]);

       return response()->json([
           'message' => 'success'
       ]);

   }

   public function update(playlist $playlist,Request $request) {
    $playlist->fill($request->all())->save();
      return response()->json([
        'message' => 'success'
      ]);

   }

   public function delete(playlist $playlist) {
       musicPlaylist::where(['playlist_id'=> $playlist->id])->delete();
       $playlist->delete();
       return response()->json([
        'message' => 'success'
       ]);
   }
   public function show() {
    $playlist = playlist::with('musics')->Get();	
    return $playlist;
   }

   public function add($playlistid,$musicid) {
      musicPlaylist::create([
         'music_id' => $musicid,
         'playlist_id' => $playlistid
      ]);
    }

}
