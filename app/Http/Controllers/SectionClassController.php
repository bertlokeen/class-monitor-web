<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\SectionClass;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Validator;

class SectionClassController extends Controller
{
    public function index()
    {
        if (request()->user()->hasRole('admin')) {
            $classes = SectionClass::query()->paginate(20);
        } 
        
        if (request()->user()->hasRole('faculty')) {
            $classes = request()->user()->faculty->classes()->paginate(20);
        }
        
        if (request()->user()->hasRole('student')) {
            $classes = request()->user()->student->classes()->paginate(20);
        }

        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        $faculties = Faculty::query()->with('subjects')->get();
        $subjects = Subject::where('faculty_id', request()->get('id'))->get();
        $courses = ['BSIT', 'BSCS', 'BSCE'];

        return view('classes.create', compact('subjects', 'faculties', 'courses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'instructor' => 'required',
            'subject' => 'required',
            'course' => 'required',
            'year' => 'required',
            'section' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        $class = SectionClass::create([
            'faculty_id' => $request->get('instructor'),
            'subject_id' => $request->get('subject'),
            'course' => $request->get('course'),
            'year' => $request->get('year'),
            'section' => $request->get('section'),
        ]);

        return redirect()->route('classes.show', $class->id)->with('status', 'Class created successfully!');
    }

    public function show(SectionClass $class)
    {
        $students = Student::all();

        $activityTypes = ['Quiz', 'Recitation', 'Practical', 'Major Exam'];

        $attendances = [];

        if($class->hasConductedAttendance()) {
            $attendances = $class->attendances()->whereDate('conducted_at', now()->format('Y-m-d'))->with('student')->get();
        }

        $activities = $class->activities;

        return view('classes.show', compact('class', 'students', 'activityTypes', 'attendances'));
    }

    public function edit(Request $request, SectionClass $class)
    {
        $faculties = Faculty::query()->with('subjects')->get();

        if ($request->filled('id')) {
            $subjects = Subject::where('faculty_id', request()->get('id'))->get();
        } else {
            $subjects = Subject::where('faculty_id', $class->faculty->id)->get();
        }
        
        $courses = ['BSIT', 'BSCS', 'BSCE'];

        return view('classes.edit', compact('class', 'faculties', 'subjects', 'courses'));
    }

    public function update(Request $request, SectionClass $class)
    {
        $validator = Validator::make($request->all(), [
            'instructor' => 'required',
            'subject' => 'required',
            'course' => 'required',
            'year' => 'required',
            'section' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        $class->update([
            'faculty_id' => $request->get('instructor'),
            'subject_id' => $request->get('subject'),
            'course' => $request->get('course'),
            'year' => $request->get('year'),
            'section' => $request->get('section'),
        ]);

        return redirect()->route('classes.show', $class->id)->with('status', 'Class updated successfully!');
    }

    public function destroy(SectionClass $class)
    {
        $class->delete();

        return redirect()->route('classes.index');
    }

    public function assignStudent(Request $request, $class_id)
    {
        $class = SectionClass::find($class_id);
        
        $validator = Validator::make($request->all(), [
            'student' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        $class->students()->attach($request->get('student'));

        return redirect()->back()->with('status', 'Student assigned successfully!');
    }

    public function unAssignStudent($class_id, $student_id)
    {
        $class = SectionClass::find($class_id);

        $student = Student::find($student_id);

        $class->students()->detach($student->id);

        return redirect()->back()->with('status', 'Student unassigned successfully!');
    }

    public function addActivity(Request $request, $class_id)
    {
        return $request->all();
    }
}
