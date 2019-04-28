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

    public function getPerformanceRating($ratings)
    {
        $activityTypes = [
            'Quiz' => 0.1,
            'Recitation' => 0.2,
            'Practical' => 0.2,
            'Major Exam' => 0.5
        ];

        $performanceRating = $ratings->map(function ($val) use ($activityTypes) {
            return $val->map(function ($val2, $i) use ($activityTypes) {
                if(isset($activityTypes[$i])) {
                    $percent = $val2->map(function ($val3) {
                        return $val3['score'] /  $val3['items'];
                    })->avg() * $activityTypes[$i];

                    return $percent * 100;
                }
            })->sum();
        });

        return $performanceRating;
    }

    public function ratings($subjectId)
    {
        $records = null;

        $student = Student::find($this->id);
        $sectionClass = $student->classes->where('subject_id', $subjectId)->first();

        $sheet = ActivityScore::where('student_id', $student->id)
            ->join('activities', 'activity_scores.activity_id', '=', 'activities.id')
            ->join('section_classes', 'activities.section_class_id', '=', 'section_classes.id')
            ->join('subjects', function ($queryJoin) use ($subjectId) {
                $queryJoin->on('section_classes.subject_id', '=', 'subjects.id');
                $queryJoin->where('subjects.id', '=', $subjectId);
            })->get();

        $records = $sheet->groupBy(['period', 'lesson', 'type']);

        $ratings = $sheet->groupBy(['period', 'type']);

        $performanceRating = $this->getPerformanceRating($ratings);
        
        return $performanceRating;
    }

    public function grade($subjectId)
    {
        return collect($this->ratings($subjectId))->avg();
    }
}
