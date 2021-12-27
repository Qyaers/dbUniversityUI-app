<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;

    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class);
    }

    public function universities()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}
