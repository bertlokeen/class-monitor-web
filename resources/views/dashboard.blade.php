@extends('layouts.master') 
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item" aria-current="page">Dashboard</li>
  </ol>
</nav>
@endsection
 
@section('content')
<div class="col-md-12">
  <div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
      <a href="{{ route('announcements.index') }}">
        <div class="card card-stats">
          <div class="reset-card-header card-header card-header-primary card-header-icon ">
            <div class="card-icon">
              <i class="material-icons">announcement</i>
            </div>
            <p class="card-category">Announcements</p>
            <h3 class="card-title">{{ $count['announcements'] }}</h3>
          </div>
          <div class="card-footer reset-card-footer">
            <div class="stats">
              <i class="material-icons">announcement</i> Total # of announcements
            </div>
          </div>
        </div>
      </a>
    </div>

    @if(auth()->user()->hasRole('admin'))
    <div class="col-lg-3 col-md-6 col-sm-6">
      <a href="{{ route('admin.index') }}">
        <div class="card card-stats">
          <div class="reset-card-header card-header card-header-warning card-header-icon ">
            <div class="card-icon">
              <i class="material-icons">verified_user</i>
            </div>
            <p class="card-category">Admins</p>
            <h3 class="card-title">{{ $count['admins'] }}</h3>
          </div>
          <div class="card-footer reset-card-footer">
            <div class="stats">
              <i class="material-icons">verified_user</i> Total # of admins
            </div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
      <a href="{{ route('faculty.index') }}">
        <div class="card card-stats">
          <div class="reset-card-header card-header card-header-success card-header-icon ">
            <div class="card-icon">
              <i class="material-icons">account_circle</i>
            </div>
            <p class="card-category">Faculties</p>
            <h3 class="card-title">{{ $count['faculties'] }}</h3>
          </div>
          <div class="card-footer reset-card-footer">
            <div class="stats">
              <i class="material-icons">account_circle</i> Total # of faculty
            </div>
          </div>
        </div>
      </a>
    </div>

    @endif @if(auth()->user()->hasRole(['admin', 'faculty']))
    <div class="col-lg-3 col-md-6 col-sm-6">
      <a href="{{ route('students.index') }}">
        <div class="card card-stats">
          <div class="reset-card-header card-header card-header-info card-header-icon ">
            <div class="card-icon">
              <i class="material-icons">assignment_ind</i>
            </div>
            <p class="card-category">Students</p>
            <h3 class="card-title">{{ $count['students'] }}</h3>
          </div>
          <div class="card-footer reset-card-footer">
            <div class="stats">
              <i class="material-icons">assignment_ind</i> Total # of students
            </div>
          </div>
        </div>
      </a>
    </div>
    @endif

    <div class="col-lg-3 col-md-6 col-sm-6">
      <a href="{{ route('classes.index') }}">
        <div class="card card-stats">
          <div class="reset-card-header card-header card-header-danger card-header-icon ">
            <div class="card-icon">
              <i class="material-icons">meeting_room</i>
            </div>
            <p class="card-category">Classes</p>
            <h3 class="card-title">{{ $count['classes'] }}</h3>
          </div>
          <div class="card-footer reset-card-footer">
            <div class="stats">
              <i class="material-icons">meeting_room</i> Total # of classes
            </div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
      <a href="{{ route('subjects.index') }}">
        <div class="card card-stats">
          <div class="reset-card-header card-header card-header-default card-header-icon ">
            <div class="card-icon">
              <i class="material-icons">library_books</i>
            </div>
            <p class="card-category">Subjects</p>
            <h3 class="card-title">{{ $count['subjects'] }}</h3>
          </div>
          <div class="card-footer reset-card-footer">
            <div class="stats">
              <i class="material-icons">library_books</i> Total # of subjects
            </div>
          </div>
        </div>
      </a>
    </div>

    @if(auth()->user()->hasRole('student'))
    <div class="col-lg-3 col-md-6 col-sm-6">
      <a href="{{ route('students.attendance-log', auth()->user()->student->id) }}">
        <div class="card card-stats">
          <div class="reset-card-header card-header card-header-success card-header-icon ">
            <div class="card-icon">
              <i class="material-icons">calendar_today</i>
            </div>
            <p class="card-category">Attendance</p>
            <h3 class="card-title">{{ $count['attendance'] }}</h3>
          </div>
          <div class="card-footer reset-card-footer">
            <div class="stats">
              <i class="material-icons">calendar_today</i> Total # of attendance
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <a href="{{ route('activity.index') }}">
        <div class="card card-stats">
          <div class="reset-card-header card-header card-header-warning card-header-icon ">
            <div class="card-icon">
              <i class="material-icons">grade</i>
            </div>
            <p class="card-category">Activities</p>
            <h3 class="card-title">{{ $count['activities'] }}</h3>
          </div>
          <div class="card-footer reset-card-footer">
            <div class="stats">
              <i class="material-icons">grade</i> Total # of activities
            </div>
          </div>
        </div>
      </a>
    </div>
    @endif
  </div>
</div>
@endsection