<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'app_users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'username',
        'mail_address',
        'name',
        'lastname',
        'password',
        'favorite_sports',
        'bio',
        'location',
        'avatar',
        'banner',
        'verified',
        'active',
        'email', // Ajout de email pour correspondre à Breeze
    ];

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

    /**
     * Get the email attribute (mapped to mail_address).
     */
    public function getEmailAttribute()
    {
        return $this->attributes['mail_address'];
    }

    /**
     * Set the email attribute (mapped to mail_address).
     */
    public function setEmailAttribute($value): void
    {
        $this->attributes['mail_address'] = $value;
    }
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id')
            ->withTimestamps();
    }
}
