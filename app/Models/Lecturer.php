<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;

    protected $fillable = ['firstName','name','secondName','position','university_id'];

    public $timestamps = false;

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}
