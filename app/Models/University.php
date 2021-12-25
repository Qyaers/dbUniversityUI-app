<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class University extends Model
{
    use HasFactory;

    protected $fillable = ["name","address"];

    public $timestamps = false;

    public function chairs()
    {
        return $this->belongsToMany(Chair::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
