<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jira()
    {
        return $this->belongsTo(Jira::class);
    }

    public function boards()
    {
        return $this->hasMany(Board::class);
    }
}
