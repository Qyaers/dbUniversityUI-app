<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chair extends Model
{
    use HasFactory;

    protected $fillable = ['name','faculty_id'];

    public $timestamps = false;

    public function universities()
    {
        return $this->belongsToMany(University::class);
    }

    public function streams()
    {
        return $this->hasMany(Stream::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

}
