<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Announcement;
use App\Models\SectionClass;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $count = [];

        $count['admins'] = Admin::all()->count();
        $count['announcements'] = Announcement::all()->count();
        $count['faculties'] = Faculty::all()->count();

        if(auth()->user()->hasRole('admin')) {
            $count['students'] = Student::all()->count();
            $count['subjects'] = Subject::all()->count();
            $count['classes'] = SectionClass::all()->count();
        }

        if(auth()->user()->hasRole('faculty')) {
            $count['students'] = auth()->user()->faculty->students()->count();
            $count['subjects'] = auth()->user()->faculty->subjects()->count();
            $count['classes'] = auth()->user()->faculty->classes()->count();
        }

        if(auth()->user()->hasRole('student')) {
            $count['subjects'] = auth()->user()->student->subjects()->count();
            $count['classes'] = auth()->user()->student->classes()->count();
            $count['attendance'] = auth()->user()->student->attendances->groupBy('conducted_at')->count();
            $count['activities'] = auth()->user()->student->activities->count();
        }
        

        return view('dashboard', compact('count'));
    }
}
