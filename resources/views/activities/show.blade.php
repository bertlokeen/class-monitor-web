@extends('layouts.master') 
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item text-primary" aria-current="page"><a href="{{ route('classes.index') }}">Classes</a></li>
    <li class="breadcrumb-item text-primary" aria-current="page"><a href="{{ route('classes.show', $activity->sectionClass->id) }}">{{ $activity->sectionClass->course }} {{ $activity->sectionClass->year }}-{{ $activity->sectionClass->section }} {{ $activity->sectionClass->subject->name
      }} </a>
    </li>
    <li class="breadcrumb-item text-primary" aria-current="page"><a href="{{ route('classes.show', $activity->sectionClass->id) }}">Activities</a></li>
    <li class="breadcrumb-item text-warning" aria-current="page">{{ $activity->activity_name }}</li>
  </ol>
</nav>
@endsection
 
@section('content')
<div class="col-md-12">
  @if(session('status'))
  <div class="alert alert-success text-default">
    <div class="container">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true"><i class="material-icons">clear</i></span>
        </button>
      <b>{{ session()->get('status') }}</b>
    </div>
  </div>
  @endif

  <div class="card">
    <div class="card-header card-header-primary">
      <h4 class="card-title mt-0">Activity</h4>
      <p class="card-category">Student List</p>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="text-primary">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Score</th>
            </tr>
          </thead>
          <tbody>
            <form method="POST" action="{{ route('activity.store-scores', $activity->id) }}">
              @csrf @foreach($students as $key => $student)
              <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $student->user->fullname() }}</td>
                <td>
                  <div class="col-md-6">
                    <div class="form-group bmd-form-group" style="padding-top: 0; margin: 0">
                      <input type="number" class="form-control" name="student[{{$student->id}}][score]" placeholder="Score" value="{{ isset($activityScores[$key - 1]) ? $activityScores[$key - 1]['score'] : '0' }}"
                        max="{{ $activity->items }}" required />
                    </div>
                  </div>
                </td>
              </tr>
              @endforeach
              <tr>
                <td colspan="3" style="text-align: center">
                  <button type="submit" class="btn btn-warning">Update Scores </button>
                </td>
              </tr>
            </form>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection