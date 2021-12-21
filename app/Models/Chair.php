<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chair extends Model
{
    use HasFactory;

    public function universities()
    {
        return $this->belongsToMany(University::class);


    }

    public function directions()
    {
        return $this->hasMany(Direction::class);
    }
}
