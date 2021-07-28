<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\playlist;


class Music extends Model
{
    use HasFactory;
    protected $fillable = ['name','band','img','popularity','src','release_date','src'];
    protected $hidden = ['created_at','updated_at'];
    protected $table = 'musics';
    public function playlists() {
        return  $this->belongsToMany(playlist::class, 'music_playlist');
    }
}
