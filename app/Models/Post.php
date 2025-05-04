<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, Searchable;

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

    protected $fillable = [
        'user_id',
        'title',    // Ajout de title
        'content',
        'sport_id',
        'image',
    ];

    /**
     * L'utilisateur qui a créé ce post.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id')
            ->withTimestamps();
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

}
