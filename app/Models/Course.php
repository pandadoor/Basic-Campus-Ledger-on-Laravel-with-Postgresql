<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['code', 'name', 'description'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_courses')
                    ->withPivot('grade')
                    ->withTimestamps();
    }
}
