<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $table = 'movies';
    protected $fillable = [
        'id',
        'title',
        'locations',
        'lat',
        'long',
        'updated_at',
        'created_at'
    ];
}
