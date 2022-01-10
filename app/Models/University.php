<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Symfony\Component\Translation\t;


class University extends Model
{
    use HasFactory;

    protected $fillable = ["name","address"];

    public $timestamps = false;

    public function chairs()
    {
        return $this->belongsToMany(Chair::class);
    }

    public function streams()
    {
        return $this->hasMany(Stream::class);
    }

    public function lecturers()
    {
        return $this->hasMany(Lecturer::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
}
