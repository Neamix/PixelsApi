<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Music;
use Illuminate\Support\Facades\DB;
class searchController extends Controller
{
    
public function index(){
    $search = request()->query('searchQuery');
    if($search){
        $searchs=Music::where('name' ,'LIKE','%{$searchQuery}%')->simplePaginate(3);
        dd($search);
        return $searchs;
    }   

    else {
        $searchs =Music::all();
        return $searchs;
    }

}

public function show($name) {
    $searchs= DB::select("select * from musics where name like '%$name%' limit 5");
        return response()->json($searchs);
    }
}