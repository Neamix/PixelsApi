<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class musicPlaylist extends Model
{
    use HasFactory;
    protected $fillable = ['music_id','playlist_id'];
}
