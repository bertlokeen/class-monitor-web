<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('created_at', 'desc')->with('user')->paginate(20);

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:2|max:255',
            'middle_name' => 'max:255',
            'last_name' => 'required|min:2|max:255'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        $user = User::create([
            'first_name' => $request->get('first_name'),
            'middle_name' => $request->get('middle_name'),
            'last_name' => $request->get('last_name'),
            'address' => $request->get('address'),
            'father_name' => $request->get('father_name'),
            'mother_name' => $request->get('mother_name'),
            'date_of_birth' => Carbon::parse($request->get('date_of_birth')),
            'place_of_birth' => $request->get('place_of_birth')
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'bio' => $request->get('bio'),
            'skills' => $request->get('skills')
        ]);

        $user->assignRole('student');

        $user->userable()->create([
            'userable_type' => get_class($student),
            'userable_id' => $student->id
        ]);

        return redirect()->back()->with('status', 'success');
    }

    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:2|max:255',
            'middle_name' => 'max:255',
            'last_name' => 'required|min:2|max:255'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        $student->user->update([
            'first_name' => $request->get('first_name'),
            'middle_name' => $request->get('middle_name'),
            'last_name' => $request->get('last_name'),
            'address' => $request->get('address'),
            'father_name' => $request->get('father_name'),
            'mother_name' => $request->get('mother_name'),
            'date_of_birth' => Carbon::parse($request->get('date_of_birth')),
            'place_of_birth' => $request->get('place_of_birth')
        ]);

        $student->update([
            'bio' => $request->get('bio'),
            'skills' => $request->get('skills')
        ]);

        return redirect()->route('students.show', $student->id)->with('status', 'success');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('status', 'success');
    }
}
