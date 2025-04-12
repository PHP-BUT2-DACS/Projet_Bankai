<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name'];

    public function homeMatches()
    {
        return $this->hasMany(Matche::class, 'home_team_id');
    }

    public function awayMatches()
    {
        return $this->hasMany(Matche::class, 'away_team_id');
    }
}
