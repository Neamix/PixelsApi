<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Music;
use Illuminate\Support\Facades\DB;
class searchController extends Controller
{
    // function search(Request $request){
        
    //     if(isset($_GET['query'])&& strlen($_GET['query']) > 1){
    //         $search_text=$_GET['query'] ;
    //         $musics =DB::table('musics') ->where('Name','LIKE','%'.$search_text.'%');
    //              $musics->appends($request->all());
    //     }
    // }
    //    else{
    //  return view ('search') ;
    // };
     public function index(){
        // $musics= Music:: all ( );
        $search =request()->query('searchQuery');
      if($search){
          $searchs=Music::where('name' ,'LIKE','%{$searchQuery}%')->simplePaginate(3);
          return $searchs;
      }   
      else{
          $searchs =Music::all();
          return $searchs;
      }
    // echo 'ghafa' ;
    // return $musics;
     }

     public function show($name) {
    //   $searchs  =DB::select("select * from musics where name or band LIKE '%$id%' ");
     $searchs=Music::where('name' ,$name)->get();
         return response()->json($searchs);
     }
    
}

