<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentScore extends Model
{
    protected $fillable = ['month', 'year', 'score', 'student_id'];
    public $timestamps = false;

    public function student()
    {
        return $this->belongsTo('App\Student', 'id');
    }
}
