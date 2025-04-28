<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = ['title', 'start', 'end', 'team_id'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
