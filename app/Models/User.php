<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Searchable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'username',
        'name',
        'lastname',
        'password',
        'bio',
        'location',
        'avatar',
        'banner',
        'verified',
        'active',
        'email', // Ajout de email pour correspondre à Breeze
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function toSearchableArray()
    {
        return [
            'username' => $this->username,
        ];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function following()
    {
        return $this->belongsToMany(self::class, 'follows', 'follower_id', 'followed_id')
            ->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(self::class, 'follows', 'followed_id', 'follower_id')
            ->withTimestamps();
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id')
            ->withTimestamps();
    }

    public function favoriteSports()
    {
        return $this->belongsToMany(Sport::class, 'favorite_sport_selection', 'user_id', 'sport_id');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'app_user_team', 'user_id', 'team_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function conferences()
    {
        return $this->belongsToMany(Conference::class, 'user_conference', 'user_id', 'conference_id')
            ->withTimestamps();
    }
}
