<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Music;

class playlist extends Model
{
    use HasFactory;
    protected $fillable = ['name','status'];
    protected $hidden = ['updated_at'];

    public function musics() {
        return  $this->belongsToMany(Music::class, 'music_playlist');
    }
}
