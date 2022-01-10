<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'number',];

    public $timestamps = false;

    public function streams()
    {
        return $this->hasMany(Stream::class);
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
