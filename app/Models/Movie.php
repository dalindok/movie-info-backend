<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Movie extends Model
{
use HasFactory;
protected $fillable = [
    'movie_title',
    'movie_description',
    'genre_id',
    'rate_id',
    'actor1',
    'actor2',
    'movie_poster',
    'movie_trailer',
    'released_date',
    'rating',
];

public function genre()
{
    return $this->belongsTo(Genre::class);
}


}
