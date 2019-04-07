<?php

namespace App\Models;

use App\User;
use App\Models\ActivityScore;
use App\Models\Attendance;
use App\Models\SectionClass;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skills()
    {
        return explode(',', $this->skills);
    }

    public function subjects()
    {
        $ids = $this->classes->pluck('subject_id');

        return Subject::whereIn('id', $ids);
    }
    
    public function classes()
    {
        return $this->belongsToMany(SectionClass::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function activities()
    {
        return $this->hasMany(ActivityScore::class);
    }
}
