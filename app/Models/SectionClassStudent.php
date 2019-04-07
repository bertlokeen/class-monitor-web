<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class SectionClassStudent extends Model
{
    protected $table = 'section_class_student';

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
