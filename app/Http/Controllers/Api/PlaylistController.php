<?php

namespace App\Http\Controllers\Api;

use App\Models\playlist;
use App\Models\Music;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\musicPlaylist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PlaylistController extends Controller
{

   /*
           Create
    ======================
    1) validation: name
    2) create new list
    3) if there is song id send with data: add this song in relation with the created playlist
   */

   public function create(Request $request)
   {
       /*
           Validation
       */

       $validation = Validator::make($request->all(),[
        'name' => 'required|min:3|unique:playlists'
       ]);
 
       if($validation->fails()) {
        return response()->json([
            'message' => 'fail',
            'validFailsMessage'=>$validation->messages()
        ]);
       }

       /*
          Create new list
       */

       $playlist = playlist::create([
        'name'    => $request->name,
        'user_id' => $request->user()->id
       ]);

       /*
          If there is a song send with the created playlist request
       */

       if(isset($request->id)) {
        $userid     = $request->user()->id;
        $playlistid = playlist::select()->latest('created_at')->get()->first()->id;
        $musicid    = $request->id;
        $music      = musicPlaylist::create([
            'playlist_id' => $playlistid,
            'music_id'    => $musicid,
            'user_id'     => $userid
        ]);
       }

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
   public function show(Request $request) {
    $playlists = playlist::with('musics')->get()->where('user_id',$request->user()->id);
    $playlistArr = [];

    if(!empty($playlists->toArray())) :
        foreach($playlists as $playlist ) {
            $playlistsArr[$playlist['id']] = $playlist;
        }
        return response()->json([
            $playlistsArr
        ]);
    else: 
        return response()->json();
    endif;
   }
   public function getPlaylist(Request $request) {
       $playlist = playlist::where([
           'id'      => $request->id,
           'user_id' => $request->user()->id
       ])->with('musics')->select()->get();  
       return response()->json([
        (empty($playlist)) ? 'Unauthorized' : $playlist
       ]);
   }

   public function add(Request $request) {
    $userid     = $request->user()->id;
    $playlistid = $request->playlistID;
    $musicid    = $request->musicID;
    $valueExist = musicPlaylist::where([
        'user_id'     => $userid,
        'playlist_id' => $playlistid,
        'music_id'    => $musicid
    ])->get()->toArray();
    $exist = (empty($valueExist)) ? true : false;
    if($exist) : 
       musicPlaylist::create([
            'user_id'     => $userid,
            'playlist_id' => $playlistid,
            'music_id'    => $musicid
       ]);
       return response()->json(['message' => 'success']);
    else : 
        musicPlaylist::where([
            'user_id'     => $userid,
            'playlist_id' => $playlistid,
            'music_id'    => $musicid
       ])->delete(); 
    endif;

   }

   /*
         Deattached
    =====================
    1) remove the relation between playlist and song 
   */

//    public function deattached(Request $request) {
//        $playlistID = $request->playlist;
//        $musicID    = $request->music;
//        $userid     = $request->user()->id

//        musicPlaylist::where([

//        ]);
//    }
}
