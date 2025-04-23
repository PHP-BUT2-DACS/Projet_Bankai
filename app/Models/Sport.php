<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;

    public function fans()
    {
        return $this->belongsToMany(User::class, 'favorite_sport_selection', 'sport_id', 'user_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}
