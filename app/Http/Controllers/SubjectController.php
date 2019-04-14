<?php

namespace App\Http\Controllers;

use App\Models\ActivityScore;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Validator;

class SubjectController extends Controller
{
    public function index()
    {
        if (request()->user()->hasRole('admin')) {
            $subjects = Subject::query()->paginate(20);
        }

        if (request()->user()->hasRole('faculty')) {
            $subjects = request()->user()->faculty->subjects()->paginate(20);
        }

        if (request()->user()->hasRole('student')) {
            // return $subjects = request()->user()->student->subjects();
            $subjects = request()->user()->student->subjects()->paginate(20);
        }

        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        $faculties = Faculty::query()->with('user')->get();
        $days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];

        return view('subjects.create', compact('faculties', 'days'));
    }

    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255',
            'instructor' => 'required',
            'units' => 'required',
            'schedule.day' => 'required|array',
            'schedule.time.*' => 'required'
        ], [
            'name.required' => 'The subject name field is required.',
            'schedule.day' => 'The schedule day field is required.',
            'schedule.time.hours.required' => 'The schedule time hour field is required.',
            'schedule.time.minutes.required' => 'The schedule time minute field is required.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        $subject = Subject::create([
            'faculty_id' => $request->get('instructor'),
            'name' => $request->get('name'),
            'units' => $request->get('units'),
            'schedules' => json_encode($request->get('schedule')['day']),
            'time' => $request->get('schedule')['time']['hours'] . ':' . $request->get('schedule')['time']['minutes'] . ' ' . $request->get('schedule')['time']['daytime']
        ]);

        return redirect()->route('subjects.show', $subject->id)->with('status', 'created');
    }

    public function show(Subject $subject)
    {
        $records = null;

        if (request()->user()->hasRole('student')) {
            $student = Student::find(request()->user()->student->id);
            $sectionClass = $student->classes->where('subject_id', $subject->id)->first();

            $records = ActivityScore::where('student_id', $student->id)
                ->join('activities', 'activity_scores.activity_id', '=', 'activities.id')
                ->join('section_classes', 'activities.section_class_id', '=', 'section_classes.id')
                ->join('subjects', function ($queryJoin) use ($subject) {
                    $queryJoin->on('section_classes.subject_id', '=', 'subjects.id');
                    $queryJoin->where('subjects.id', '=', $subject->id);
                })->get()->groupBy(['period', 'lesson', 'type']);

            // return $records;
        }

        return view('subjects.show', compact('subject', 'records'));
    }

    public function showByName($name)
    {
        $records = null;

        if (request()->user()->hasRole('student')) {
            $subject = Subject::where('name', $name)->first();

            if (!$subject) {
                return abort(404);
            }
            
            $activityTypes = [
                'Quiz' => 0.1,
                'Recitation' => 0.2,
                'Practical' => 0.2,
                'Major Exam' => 0.5
            ];

            $student = Student::find(request()->user()->student->id);
            $sectionClass = $student->classes->where('subject_id', $subject->id)->first();

            $sheet = ActivityScore::where('student_id', $student->id)
                ->join('activities', 'activity_scores.activity_id', '=', 'activities.id')
                ->join('section_classes', 'activities.section_class_id', '=', 'section_classes.id')
                ->join('subjects', function ($queryJoin) use ($subject) {
                    $queryJoin->on('section_classes.subject_id', '=', 'subjects.id');
                    $queryJoin->where('subjects.id', '=', $subject->id);
                })->get();

            $records = $sheet->groupBy(['period', 'lesson', 'type']);

            $ratings = $sheet->groupBy(['period', 'type']);

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
        }

        return view('subjects.show', compact('subject', 'records', 'performanceRating'));
    }

    public function edit(Subject $subject)
    {
        $faculties = Faculty::all();
        $days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];

        return view('subjects.edit', compact('subject', 'faculties', 'days'));
    }

    public function update(Request $request, Subject $subject)
    {
        $subject->update([
            'faculty_id' => $request->get('instructor'),
            'name' => $request->get('name'),
            'units' => $request->get('units'),
            'schedules' => json_encode($request->get('schedule')['day']),
            'time' => $request->get('schedule')['time']['hours'] . ':' . $request->get('schedule')['time']['minutes'] . ' ' . $request->get('schedule')['time']['daytime']
        ]);

        return redirect()->route('subjects.show', $subject->id)->with('status', 'updated');
    }

    public function destroy($id)
    {
        $subject = Subject::find($id);

        $subject->classes()->delete();

        $subject->delete();

        return redirect()->route('subjects.index')->with('success', 'Successfully deleted subject');
    }
}
