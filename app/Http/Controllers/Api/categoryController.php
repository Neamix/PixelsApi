<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\category;
use Illuminate\Support\Facades\DB;

class categoryController extends Controller
{
    public function store(Request $request) {
        $validation = Validator::make($request->all(),[
           'category' =>'required|unique:category'
        ]);
 
        if(!$validation->failed()) {
          
        }
     }
 
    public function getByOrder($order,$limit = 10) {
        $allowedOrder = [
            'popular',
            'release',
            'random'
        ];
    
        if(in_array($order,$allowedOrder)) {
             if ($order == 'popular') 
                $order = DB::select("SELECT * FROM musics order by popularity   desc limit $limit");
             else if ($order == 'release')
                $order = DB::select("SELECT * FROM musics order by release_date desc limit $limit ");
             else 
                $order = DB::select("SELECT * FROM musics ORDER BY RAND() limit $limit");
             ;
             return $order;
        } 
    }

    public function getByBand($band,$limit = 10) {
        $bands     = DB::table('musics')->select('*')->orderBy('band')->get()->groupBy('band')->toArray();
        return $bands;
    }

    public function getCategory(category $category) {

        $category = category::with('musics')->get();

        return response()->json(
            $category
        );
    }

    public function getAllCategory() {
        $category = category::all();
        return $category;
    }

}
