<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Music;

class category extends Model
{
    use HasFactory;

    public function musics() {
       return  $this->belongsToMany(Music::class,'categories_musics');
    }
}
