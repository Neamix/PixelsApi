<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\playlist;
use App\Models\cateogry;


class Music extends Model
{
    use HasFactory;
    protected $fillable = ['name','band','img','popularity','src','release_date','src'];
    protected $hidden = ['created_at','updated_at'];
    protected $table = 'musics';

    public function playlists() {
        return  $this->belongsToMany(playlist::class, 'music_playlist');
    }

    public function users() {
        return $this->belongsToMany(User::class,'likes');
    }

    public function category() {
        return $this->belongsToMany(category::class,'categories_musics');
    }
}
