<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
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
        return view('subjects.show', compact('subject'));
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

    public function destroy()
    {
        
    }
}
