@extends('layouts.master') 
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Subjects</a></li>
    <li class="breadcrumb-item text-warning" aria-current="page">{{ $subject->name }}</li>
  </ol>
</nav>
@endsection
 
@section('content')
<div class="col-md-12 pt-3">
  <div class="row">
    <div class="container-fluid">
      @if($errors->any())
      <div class="alert alert-danger mb-2">
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
          <b>Subject {{ session()->get('status') }} successfully! </b>
        </div>
      </div>
      @endif
      <div class="row">
        <div class="col-md-10 m-auto">
          <div class="card">
            <div class="card-header card-header-primary">
              @if(auth()->user()->hasRole('admin'))
              <span class="actions float-right pt-3">
                  <a href="{{ route('subjects.edit', $subject->id) }}" class="text-white">
                    <i class="material-icons">edit</i>
                  </a>&nbsp;
                  <a href="{{ route('subjects.destroy', $subject->id) }}" class="text-white" onclick="event.preventDefault(); confirm('Are you sure you want to delete?') ? document.getElementById('delete-form').submit() : '' ">
                    <i class="material-icons">delete</i>
                  </a>

                  <form id="delete-form" action="{{ route('subjects.destroy', $subject->id) }}" method="POST"  style="display: none;">
                      @csrf
                      {{ method_field('DELETE') }}
                  </form>
                </span> @endif
              <h4 class="card-title">Subject</h4>
              <p class="card-category">Information</p>
            </div>
            <div class="card-body">
              <div class="col-md-12">
                <div class="row">
                  <ul class="nav nav-pills nav-pills-icons justify-content-left" role="tablist">
                    @if(auth()->user()->hasRole('student'))
                    <li class="nav-item">
                      <a class="nav-link active" href="#records" role="tab" data-toggle="tab">
                        <i class="material-icons">info</i> Records
                      </a>
                    </li>
                    @endif
                    <li class="nav-item">
                      <a class="nav-link {{ !auth()->user()->hasRole('student') ? 'active' : '' }}" href="#information" role="tab" data-toggle="tab">
                          <i class="material-icons">info</i> Information
                        </a>
                    </li>
                    @if(auth()->user()->hasRole(['admin', 'faculty']))
                    <li class="nav-item">
                      <a class="nav-link" href="#classes" role="tab" data-toggle="tab">
                          <i class="material-icons">date_range</i> Classes
                        </a>
                    </li>
                    @endif
                  </ul>
                </div>
                <div class="tab-content tab-space">
                  <div class="tab-pane active" id="records">
                    <div class="row">
                      <div class="col-md-12">
                        <hr>
                        <div class="row">
                          <div class="col-md-12">
                            <h3>{{ $subject->name }}</h3>
                            <p><a href="{{ route('faculty.show', $subject->faculty->id) }}">{{ $subject->faculty->user->fullname() }}</a></p>
                            <p>Units : {{ $subject->units }}</p>
                            @if($records)
                              <hr>
                                @foreach ($records as $key => $record)
                                <table class="table table-hover table-bordered">
                                  <thead class="text-primary">
                                    <tr>
                                    <th colspan="3">{{ ucfirst($key) }}</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($record as $lesson => $items)
                                      <tr>
                                        <td colspan="3">{{ $lesson }}</td>
                                      </tr>
                                      @foreach ($items as $activities)
                                        @foreach ($activities as $activity)
                                        <tr>
                                          <td></td>
                                          <td>{{ $activity['activity_name'] }}</td>
                                          <td>{{ $activity['score'] }} / {{ $activity['items'] }}</td>
                                        </tr>
                                        @endforeach
                                      @endforeach
                                    @endforeach
                                    
                                  <tfoot>
                                    <tr>
                                      <td colspan="2">{{ ucfirst($key) }} Grade</td>
                                      <td><span class="text-primary"><b>{{ round($performanceRating[$key], 2) }}%</b></span></td>
                                    </tr>
                                  </tfoot>
                                </table>
                                <hr>
                              @endforeach
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="information">
                    <div class="row">
                      <div class="col-md-12">
                        <hr>
                        <div class="row pb-2">
                          <div class="col-md-4">
                            <p>Subject Name</p>
                            <b><p>{{ $subject->name }}</p></b>
                          </div>
                          <div class="col-md-4">
                            <p>Units</p>
                            <b><p>{{ $subject->units }}</p></b>
                          </div>
                          <div class="col-md-4">
                            <p>Instructor</p>
                            <b><p><a href="{{ route('faculty.show', $subject->faculty->id) }}">{{ $subject->faculty->user->fullname() }}</a></p></b>
                          </div>
                        </div>
                        <hr>
                        <div class="row pb-2">
                          <div class="col-md-8">
                            <p>Schedule</p>
                            <div class="form-check">
                              @php $days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat']; 
@endphp @foreach ($days as $day)
                              <label class="form-check-label ml-3 mb-2">
                                <input class="form-check-input" type="checkbox" disabled {{ $subject->hasSchedule($day) ? 'checked' : '' }}> {{ ucfirst($day) }}
                                <span class="form-check-sign">
                                  <span class="check" style="opacity: 1; border-color: #9c27b0; "></span>
                                </span>
                              </label> @endforeach
                            </div>
                          </div>
                          <div class="col-md-4">
                            <p>Time</p>
                            <b><p>{{ $subject->time }}</p></b>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @if(auth()->user()->hasRole(['admin', 'faculty']))
                  <div class="tab-pane" id="classes">
                    <div class="row">
                      <div class="col-md-12">
                        <hr>
                        <div class="table-responsive">
                          <table class="table table-hover">
                            <thead class="text-primary">
                              <tr>
                                <th>#</th>
                                <th>Course</th>
                                <th>Year</th>
                                <th>Section</th>
                                <th>Student Count</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @if(!$subject->classes)
                              <tr>
                                <td colspan="6" style="text-align: center"> No records found.</td>
                              </tr>
                              @else
                              @foreach($subject->classes as $key => $class)
                              <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $class->course }}</td>
                                <td>{{ $class->year }}</td>
                                <td>{{ $class->section }}</td>
                                <td>{{ $class->students->count() }}</td>
                                <td>
                                  <a href="{{ route('classes.show', $class->id) }}"><i class="material-icons text-primary pr-2" onMouseOver='this.classList.remove("text-primary"); this.classList.add("text-warning");' onMouseOut='this.classList.add("text-primary");'>visibility</i></a>
                                </td>
                              </tr>
                              @endforeach
                              @endif
                              
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection