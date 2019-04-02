<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Student;
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
            'date_of_birth' => $request->get('date_of_birth'),
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

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
