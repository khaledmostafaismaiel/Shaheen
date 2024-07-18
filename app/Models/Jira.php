<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jira extends Model
{
    protected $guarded = [];

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
