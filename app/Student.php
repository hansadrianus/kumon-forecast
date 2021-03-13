<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['id', 'name', 'grade'];
    public $timestamps = false;

    public function score()
    {
        return $this->hasMany('App\StudentScore', 'student_id');
    }
}
