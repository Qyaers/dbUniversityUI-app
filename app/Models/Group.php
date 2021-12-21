<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public function courses()
    {
        return $this->hasOne(Course::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
