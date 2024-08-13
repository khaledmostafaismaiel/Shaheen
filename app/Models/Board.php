<?php

namespace App\Models;

use App\Observers\BoardObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::observe(BoardObserver::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
