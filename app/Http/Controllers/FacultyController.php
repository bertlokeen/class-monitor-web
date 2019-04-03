<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Validator;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = Faculty::orderBy('created_at', 'desc')->with('user')->paginate(20);

        return view('faculties.index', compact('faculties'));
    }

    public function create()
    {
        return view('faculties.create');
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

        $faculty = Faculty::create([
            'user_id' => $user->id,
            'bio' => $request->get('bio')
        ]);

        $user->assignRole('faculty');

        return redirect()->back()->with('status', 'success');
    }

    public function show(Faculty $faculty)
    {
        return view('faculties.show', compact('faculty'));
    }

    public function edit(Faculty $faculty)
    {
        return view('faculties.edit', compact('faculty'));
    }

    public function update(Request $request, Faculty $faculty)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:2|max:255',
            'middle_name' => 'max:255',
            'last_name' => 'required|min:2|max:255'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        $faculty->user->update([
            'first_name' => $request->get('first_name'),
            'middle_name' => $request->get('middle_name'),
            'last_name' => $request->get('last_name'),
            'address' => $request->get('address'),
            'father_name' => $request->get('father_name'),
            'mother_name' => $request->get('mother_name'),
            'date_of_birth' => $request->get('date_of_birth'),
            'place_of_birth' => $request->get('place_of_birth')
        ]);

        $faculty->update([
            'bio' => $request->get('bio')
        ]);

        return redirect()->route('faculty.show', $faculty->id)->with('status', 'success');
    }

    public function destroy(Faculty $faculty)
    {
        $faculty->delete();

        return redirect()->route('faculty.index')->with('status', 'success');
    }
}
