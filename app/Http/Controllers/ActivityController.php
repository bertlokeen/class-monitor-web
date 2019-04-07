<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityScore;
use App\Models\SectionClass;
use Illuminate\Http\Request;
use Validator;

class ActivityController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        $activities = $student->activities()->with('activity.sectionClass.subject')->paginate(20);

        return view('activities.index', compact('student', 'activities'));
    }

    public function show(Activity $activity)
    {
        $students = $activity->sectionClass->students()->with('user')->get();

        $activityScores = ActivityScore::where('activity_id', $activity->id)->get();

        return view('activities.show', compact('activity', 'students', 'activityScores'));
    }

    public function store(Request $request, $class_id)
    {
        $validator = Validator::make($request->all(), [
            'period' => 'required',
            'name' => 'required',
            'type' => 'required',
            'items' => 'required',
            'schedule.time.*' => 'required'
        ], [
            'schedule.time.hours.required' => 'The schedule time hour field is required.',
            'schedule.time.minutes.required' => 'The schedule time minute field is required.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        $class = SectionClass::find($class_id);

        $activity = Activity::create([
            'section_class_id' => $class->id,
            'period' => $request->get('period'),
            'name' => $request->get('name'),
            'type' => $request->get('type'),
            'items' => $request->get('items'),
            'time' => $request->get('schedule')['time']['hours'] . ':' . $request->get('schedule')['time']['minutes'] . ' ' . $request->get('schedule')['time']['daytime']
        ]);

        return redirect()->back()->with('status', 'Activity created successfully!');
    }

    public function storeScores(Request $request, $activity_id)
    {
        $activity = Activity::find($activity_id);

        foreach ($request->get('student') as $key => $score) {
            $activityScore = ActivityScore::where([
                ['activity_id', $activity->id],
                ['student_id', $key]
            ])->first();

            if($activityScore) {
                $activityScore->update(['score' => $score['score']]);
            } else {
                ActivityScore::create([
                    'activity_id' => $activity->id,
                    'student_id' => $key,
                    'score' => $score['score']
                ]);
            }
        }

        return redirect()->back()->with('status', 'Activity scores successfully updated!');
    }
}
