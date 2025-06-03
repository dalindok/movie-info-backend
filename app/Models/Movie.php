<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'average_rating',
        'poster',
        'trailer',
        'release_date',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }
    public function scopePopular($query)
    {
        return $query->where('average_rating', '>', 5)->orderByDesc('average_rating');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('release_date', '>', now())->orderBy('release_date');
    }

    public function scopeMostRated($query)
    {
        return $query->withCount('ratings')->orderByDesc('ratings_count');
    }
}
