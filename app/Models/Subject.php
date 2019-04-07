<?php

namespace App\Models;

use App\Models\Faculty;
use App\Models\Student;
use App\Models\SectionClass;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $guarded = [];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function schedules()
    {
        return $this->schedulesArr()->join(', ');
    }

    public function classes()
    {
        return $this->hasMany(SectionClass::class);
    }

    public function schedulesArr()
    {
        $schedules = collect(json_decode($this->schedules));

        return $schedules->keys()->map(function ($val) {
            return strtoupper($val);
        });
    }

    public function hasSchedule($day)
    {
        return in_array(strtoupper($day), $this->schedulesArr()->toArray());
    }
}
