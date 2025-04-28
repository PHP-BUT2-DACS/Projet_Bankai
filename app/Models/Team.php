<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Team extends Model
{
    use Searchable;

    protected $table = 'team';
    protected $fillable = ['name', 'sport_id'];

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
        ];
    }

    public function homeMatches()
    {
        return $this->hasMany(Matche::class, 'home_team_id');
    }

    public function awayMatches()
    {
        return $this->hasMany(Matche::class, 'away_team_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'app_user_team', 'team_id', 'user_id');
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
}
