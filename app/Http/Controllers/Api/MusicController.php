<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\music;
use App\Models\musicPlaylist;
use App\Models\User;
use App\Models\like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Constraint\Count;


class MusicController extends Controller
{   

    /**
     *              INSERT
     * ================================
     *  Insert new song 
     * ================================
     *  @param Request $request
     */

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

   /**
     *             BUNDLE
     * ================================
     *  Insert new song 
     * ================================
     *  @param $limit get specific number of songs 
     *  @param $category order the song by category
     */

   public function bundle($category = 'popularity',$limit = 100) {

       $musics = DB::select("select * from musics order by $category limit $limit");

       return $musics;
   }

   /**
     *             SHOW
     * ================================
     *  Display a certain song
     * ================================
     *  @param music $music
     *  
     */

   public function show(music $music)
    {
       return response()->json([
           'message' => 'success',
           'music' => $music
       ]);
   }

    /**
     *             UPDATE
     * ================================
     *  UPDATE Song
     * ================================
     *  @param music $music
     *  @param Request $request
     *  
     */
   public function update(music $music,Request $request) 
   {
      $music->fill($request->all())->save();
      return response()->json([
        'message' => 'success'
      ]);
   }


     /**
     *             DELETE
     * ================================
     *  Del Song
     * ================================
     *  @param music $music
     *  
     */
   public function delete(music $music) {
       musicPlaylist::where(['music_id' => $music->id])->delete();
       $music->delete();
       return response()->json([
        'message' => 'success'
      ]);
   }

     /**
     *             UPDATE
     * ================================
     *  Get all likes for a user 
     * ================================
     *  @param Request $request
     *  
     */
   public function likes(Request $request) {
     $musics = $request->user()->musics;
     return response()->json([
        'likes' =>  $musics
     ]);
   }
  

   public function like($musicid,Request $request) {
      $music = like::where(['user_id' => $request->user()->id,'music_id'=>$musicid])->get()->toArray();

      if(empty($music)) {
        like::create([
          'user_id' => $request->user()->id,
          'music_id' => $musicid
        ]);
        $res = true;
      } else {
        like::where(['user_id' => $request->user()->id,'music_id'=>$musicid])->delete();
        $res = false;
      }
      return response()->json([
        'isLike' =>  $res
     ]);
   }

   public function isLike($musicid,Request $request) {
    $music = like::where(['user_id' => $request->user()->id,'music_id'=>$musicid])->get()->toArray();

    if(empty($music)) {
      
      $res = false;
    } else {
      
      $res = true;
    }
    return response()->json([
      'isLike' =>  $res
   ]);
 }



}
