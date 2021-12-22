<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class);
    }

}
