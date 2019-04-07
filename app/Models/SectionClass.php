<?php

namespace App\Models;

use App\Models\Activity;
use App\Models\Attendance;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;

class SectionClass extends Model
{
    protected $guarded = [];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function hasConductedAttendance()
    {
        return $this->attendances()->whereDate('conducted_at', now()->format('Y-m-d'))->get()->count() > 0 ? true : false;
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
