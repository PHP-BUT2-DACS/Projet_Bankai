<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class Team extends Model
{
    use HasFactory, Notifiable, Searchable;

    protected $table = 'team';
    protected $fillable = ['name', 'sport_id'];

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
        ];
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'app_user_team', 'team_id', 'user_id');
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function trainings()
    {
        return $this->hasMany(Training::class);
    }
}
