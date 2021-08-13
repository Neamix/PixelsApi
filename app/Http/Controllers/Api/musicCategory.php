<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Music;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

class musicCategory extends Controller
{
    public function index() {
        $musics = Music::all();
        return Voyager::view('category')->with([
            'musics' => $musics
        ]);
    }
}
