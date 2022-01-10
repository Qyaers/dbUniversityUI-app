<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    use HasFactory;

    protected $fillable = ['course_id','chair_id','university_id'];

    public $timestamps = false;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function chair()
    {
        return $this->belongsTo(Chair::class);
    }
    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
