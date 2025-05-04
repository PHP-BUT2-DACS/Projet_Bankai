<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    protected $fillable = ['title', 'start', 'end', 'team_id'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_conference');
    }
}
