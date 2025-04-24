<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory, Searchable;

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'desciption' => $this->description,
        ];
    }
    protected $fillable = ['title', 'description'];
}
