<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    use HasFactory;
    //Str::plural(music) возвращает music ед.ч.
    protected $table = 'musics';

    protected $fillable = [
        'title',
        'author',
        'album',
        'image',
        'url',
    ];

}
