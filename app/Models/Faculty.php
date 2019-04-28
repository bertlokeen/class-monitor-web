<?php

namespace App\Models;

use App\User;
use App\Models\SectionClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\SectionClassStudent;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function classes()
    {
        return $this->hasMany(SectionClass::class);
    }

    public function students()
    {
        $ids = SectionClassStudent::whereIn('section_class_id', $this->classes->pluck('id'))->get()->pluck('student_id');

        return Student::whereIn('id', $ids);
    }

    public function subjectNames()
    {
        return $this->subjects->pluck('name')->toArray();
    }
}
