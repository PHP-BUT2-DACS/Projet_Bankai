<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Sport extends Model
{
    use HasFactory, Searchable;

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
    public function fans()
    {
        return $this->belongsToMany(User::class, 'favorite_sport_selection');
    }
}
