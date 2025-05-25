<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    // You typically don't need to include the primary key in fillable
    protected $fillable = ['name'];

    // If your table's primary key is not 'id', specify it here
    // protected $primaryKey = 'genre_id';

    // Define the relationship with Movie
    public function movies()
    {
        return $this->hasMany(Movie::class);
    }
}
