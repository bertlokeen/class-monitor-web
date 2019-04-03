@extends('layouts.master') 
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Subjects</a></li>
    <li class="breadcrumb-item text-warning" aria-current="page"><a href="{{ route('subjects.show', $subject->id) }}">{{ $subject->name }}</a></li>
    <li class="breadcrumb-item text-warning" aria-current="page">Edit</li>
  </ol>
</nav>
@endsection
 
@section('content')
<div class="col-md-8" style="margin: auto;">
  <div class="card">
    <div class="card-header card-header-primary">
      <h4 class="card-title">Subject</h4>
      <p class="card-category">Information</p>
    </div>
    <div class="card-body">
      <div class="container">
        @if($errors->any())
        <div class="alert alert-danger">
          <div class="container">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true"><i class="material-icons">clear</i></span>
                </button> @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </div>
        </div>
        @endif @if(session('status'))
        <div class="alert alert-success text-default">
          <div class="container">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="material-icons">clear</i></span>
              </button>
            <b>Faculty created successfully!</b>
          </div>
        </div>
        @endif
      </div>
      <form method="POST" action="{{ route('subjects.update', $subject->id) }}">
        @csrf {{ method_field('PUT') }}
        <div class="row">
          <div class="col-md-10 m-auto">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group bmd-form-group">
                  <label class="bmd-label-floating">Subject Name</label>
                  <input type="text" class="form-control" name="name" value="{{ $subject->name }}" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="label">Instructor</label>
                  <select class="form-control" name="instructor">
                    <option value="">Select</option>
                    @foreach ($faculties as $faculty)
                      <option value="{{ $faculty->id }}" {{ $subject->faculty->id ==  $faculty->id ? 'selected' : ''}}>{{ $faculty->user->fullname() }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group bmd-form-group">
                  <label class="bmd-label-floating">Units</label>
                  <input type="number" class="form-control" name="units" value="{{ $subject->units }}" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label class="label">Schedule</label>
              </div>
              <div class="col-md-12" style="text-align: center">
                <div class="form-check">
                  @php $days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat']; 
@endphp @foreach ($days as $day)
                  <label class="form-check-label ml-3 mb-2">
                  <input class="form-check-input" type="checkbox" name="schedule[day][{{ $day }}]" {{ $subject->hasSchedule($day) ? 'checked' : '' }}> {{ ucfirst($day) }}
                      <span class="form-check-sign">
                        <span class="check"></span>
                      </span>
                    </label> @endforeach
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label class="label">Time</label>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <select class="form-control" name="schedule[time][hours]">
                    <option value="">HH</option>
                    @for($i = 1; $i <= 12; $i++)
                      <option value="{{ $i }}" {{ explode(':', $subject->time)[0] == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <select class="form-control" name="schedule[time][minutes]">
                    <option value="">MM</option>
                    @for($i = 0; $i <= 59; $i++)
                      <option value="{{ $i < 10 ? '0' . $i : $i }}" {{ explode(' ', explode(':', $subject->time)[1])[0] == ($i < 10 ? '0' . $i : $i) ? 'selected' : ''}}>{{ $i < 10 ? '0' . $i : $i}}</option>
                    @endfor
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <select class="form-control" name="schedule[time][daytime]">
                    <option value="AM" {{ explode(' ', explode(':', $subject->time)[1])[1] == 'AM' ? 'selected' : '' }}>AM</option>
                    <option value="PM" {{ explode(' ', explode(':', $subject->time)[1])[1] == 'PM' ? 'selected' : '' }}>PM</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-warning pull-right">Submit</button>
        <div class="clearfix"></div>
      </form>
    </div>
  </div>
</div>
</div>
@endsection