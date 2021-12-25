<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'number'];

    public $timestamps = false;

    public function chair()
    {
        return $this->hasOne(Chair::class);
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
