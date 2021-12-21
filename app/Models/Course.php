<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function directions()
    {
        return $this->hasOne(Direction::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function disciplines()
    {
        return $this->hasMany(Discipline::class);
    }
}
