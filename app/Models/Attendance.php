<?php

namespace App\Models;

use App\Models\SectionClass;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = [];

    public function sectionClass()
    {
        return $this->belongsTo(SectionClass::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
