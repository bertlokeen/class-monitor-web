<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\ActivityScore;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Validator;

class StudentController extends Controller
{
    public function index()
    {
        if (request()->user()->hasRole('admin')) {
            $students = Student::orderBy('created_at', 'desc')->with('user')->paginate(20);
        } 
        
        if (request()->user()->hasRole('faculty')) {
            $students = request()->user()->faculty->students()->paginate(20);
        }

        return view('students.index', compact('students'));
    }

    public function create()
    {
        $courses = ['BSIT', 'BSCS', 'BSCE'];

        return view('students.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course' => 'required',
            'year' => 'required',
            'section' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'first_name' => 'required|min:2|max:255',
            'middle_name' => 'max:255',
            'last_name' => 'required|min:2|max:255'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        $user = User::create([
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
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
            'course' => $request->get('course'),
            'year' => $request->get('year'),
            'section' => $request->get('section'),
            'bio' => $request->get('bio'),
            'skills' => $request->get('skills')
        ]);

        $user->assignRole('student');
        
        return redirect()->back()->with('status', 'success');
    }

    public function show(Student $student)
    {
        $activityTypes = [
            'Quiz' => 0.1,
            'Recitation' => 0.2,
            'Practical' => 0.2,
            'Major Exam' => 0.5
        ];

        $activityScores = ActivityScore::where('student_id', $student->id)
            ->join('activities', 'activity_scores.activity_id', '=', 'activities.id')
            ->join('section_classes', 'activities.section_class_id', '=', 'section_classes.id')
            ->join('subjects', 'section_classes.subject_id', '=', 'subjects.id')
            ->get()->groupBy(['period', 'name', 'type']);
 
        $performanceRating = $activityScores->map(function ($val) use ($activityTypes) {
            return $val->map(function ($val2) use ($activityTypes) {
                return $val2->map(function ($val3, $i) use ($activityTypes) {
                    if(isset($activityTypes[$i])) {
                        $percent = $val3->map(function ($val4) {
                            return $val4['score'] /  $val4['items'];
                        })->avg() * $activityTypes[$i];

                        return $percent * 100;
                    }
                })->sum();
            });
        });

        // return $performanceRating;

        $attendanceData =  $student->attendances->groupBy(['period', 'conducted_at', 'status'])->map(function($val) {
            return $val->map(function ($val2) {
                return $val2->map(function ($i, $val3) {
                    return $i->count();
                });
            });
        });

        $present = 0;
        $absent = 0;
        $attendanceRating = [];

        foreach($attendanceData as $key => $periods) {
            foreach($periods as $key2 => $status) {
                $keys = array_keys($status->toArray());
                
                if(empty(array_diff($keys, ['present']))) {
                    $present++;
                } elseif(empty(array_diff($keys, ['absent']))) {
                    $absent++;
                } elseif(empty(array_diff($keys, ['present', 'absent']))) {
                    $present++;
                }
            }

            $attendanceRating = [
                $key => [
                    'present' => $present,
                    'absent' => $absent
                ]
            ];
        }

        $performanceData = [
            'attendance' => $attendanceRating,
            'performance' => $performanceRating
        ];

        return view('students.show', compact('student', 'performanceData'));
    }

    public function edit(Student $student)
    {
        $courses = ['BSIT', 'BSCS', 'BSCE'];

        return view('students.edit', compact('student', 'courses'));
    }

    public function update(Request $request, Student $student)
    {
        $validator = Validator::make($request->all(), [
            'course' => 'required',
            'year' => 'required',
            'section' => 'required',
            'email' => 'required|string|email|max:255|', Rule::unique('users')->ignore($student->user->id),
            'password' => $request->filled('password') ? 'string|min:6|confirmed' : '',
            'first_name' => 'required|min:2|max:255',
            'middle_name' => 'max:255',
            'last_name' => 'required|min:2|max:255'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        $student->user->update([
            'email' => $request->get('email'),
            'first_name' => $request->get('first_name'),
            'middle_name' => $request->get('middle_name'),
            'last_name' => $request->get('last_name'),
            'address' => $request->get('address'),
            'father_name' => $request->get('father_name'),
            'mother_name' => $request->get('mother_name'),
            'date_of_birth' => Carbon::parse($request->get('date_of_birth')),
            'place_of_birth' => $request->get('place_of_birth')
        ]);

        if($request->filled('password')) {
            $student->user->update(['password' => Hash::make($request->get('password'))]);
        }

        $student->update([
            'bio' => $request->get('bio'),
            'course' => $request->get('course'),
            'year' => $request->get('year'),
            'section' => $request->get('section'),
            'skills' => $request->get('skills')
        ]);

        return redirect()->route('students.show', $student->id)->with('status', 'success');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('status', 'success');
    }

    public function attendanceLog(Student $student)
    {
        $attendanceLogs = $student->attendances->groupBy(['period', 'conducted_at'])->map(function($val) {
            return $val->map(function($val2) {
                return $val2->map(function($val3) {
                    return [
                        'status' => $val3->status,
                        'note' => $val3->note,
                        'period' => $val3->period
                    ];
                });
            });
        })->toArray();

        return view('students.attendance-log', compact('student', 'attendanceLogs'));
    }
}
