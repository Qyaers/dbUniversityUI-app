<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'number', 'university_id', 'chair_id'];

    public $timestamps = false;

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function chair()
    {
        return $this->belongsTo(Chair::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}
