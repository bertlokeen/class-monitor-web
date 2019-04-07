<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\SectionClass;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function store(Request $request, $class_id)
    {
        $class = SectionClass::find($class_id);

        foreach ($request->get('student') as $key => $student) {
            Attendance::create([
                'period' => $request->get('period'),
                'section_class_id' => $class->id,
                'student_id' => $key,
                'status' => $student['status'],
                'note' => $student['note'],
                'conducted_at' => now()->format('Y-m-d')
            ]);
        }

        return redirect()->back()->with('status', 'Attendance conducted successfully!');
    }
}
