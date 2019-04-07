@extends('layouts.master') 
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Classes</a></li>
    <li class="breadcrumb-item text-warning" aria-current="page">{{ $class->course }} {{ $class->year }}-{{ $class->section }} {{ $class->subject->name }}</li>
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
          <b>{{ session()->get('status') }}</b>
        </div>
      </div>
      @endif
      <div class="row">
        <div class="col-md-10 m-auto">
          <div class="card">
            <div class="card-header card-header-primary">
              @if(auth()->user()->hasRole('admin'))
              <span class="actions float-right pt-3">
                  <a href="{{ route('classes.edit', $class->id) }}" class="text-white">
                    <i class="material-icons">edit</i>
                  </a>&nbsp;
                  <a href="{{ route('classes.destroy', $class->id) }}" class="text-white" onclick="event.preventDefault(); confirm('Are you sure you want to delete?') ? document.getElementById('delete-form').submit() : '' ">
                    <i class="material-icons">delete</i>
                  </a>

                  <form id="delete-form" action="{{ route('classes.destroy', $class->id) }}" method="POST"  style="display: none;">
                      @csrf
                      {{ method_field('DELETE') }}
                  </form>
                </span> @endif
              <h4 class="card-title">Class</h4>
              <p class="card-category">Information</p>
            </div>
            <div class="card-body">
              <div class="col-md-12">
                <div class="row">
                  <ul class="nav nav-pills nav-pills-icons justify-content-left" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" href="#information" role="tab" data-toggle="tab">
                        <i class="material-icons">info</i> Information
                      </a>
                    </li>
                    @if(auth()->user()->hasRole(['admin', 'faculty']))
                    <li class="nav-item">
                      <a class="nav-link" href="#students" role="tab" data-toggle="tab">
                          <i class="material-icons">assignment_ind</i> Students
                        </a>
                    </li>
                    @endif @if(auth()->user()->hasRole('faculty'))
                    <li class="nav-item">
                      <a class="nav-link" href="#attendance" role="tab" data-toggle="tab">
                        <i class="material-icons">calendar_today</i> Attendance
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link" href="#activities" role="tab" data-toggle="tab">
                        <i class="material-icons">grade</i> Activities
                      </a>
                    </li>
                    @endif
                  </ul>
                </div>
                <div class="tab-content tab-space">
                  <div class="tab-pane active" id="information">
                    <div class="row">
                      <div class="col-md-12">
                        <hr>
                        <div class="row pb-2">
                          <div class="col-md-6">
                            <p>Class</p>
                            <b><p>{{ $class->course }} {{ $class->year }}-{{ $class->section }}</p></b>
                          </div>
                          <div class="col-md-6">
                            <p>Subject</p>
                            <b><p><a href="{{ route('subjects.show', $class->subject->id) }}">{{ $class->subject->name }}</a></p></b>
                          </div>
                        </div>
                        <hr>
                        <div class="row pb-2">
                          <div class="col-md-6">
                            <p>Time</p>
                            <b><p>{{ $class->subject->time }}</p></b>
                          </div>
                          <div class="col-md-6">
                            <p>Instructor</p>
                            <b><p><a href="{{ route('faculty.show', $class->faculty->id) }}">{{ $class->faculty->user->fullname() }}</a></p></b>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @if(auth()->user()->hasRole(['admin', 'faculty']))
                  <div class="tab-pane" id="students">
                    <div class="row">
                      <div class="col-md-12">
                        @if(auth()->user()->hasRole('admin'))
                        <button id="add-students" class="btn btn-warning" style="float: center">
                              <i class="material-icons">add</i> Assign Students
                            </button> @endif
                        <div class="clearfix"></div>
                        <hr>
                        <div class="table-responsive">
                          <table class="table table-hover">
                            <thead class="text-primary">
                              <tr>
                                <th>#</th>
                                <th>Student</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @if($class->students->count() == 0)
                              <tr>
                                <td colspan="3" style="text-align: center">No Records Found</td>
                              </tr>
                              @endif @foreach($class->students as $key => $student)
                              <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $student->user->fullname() }}</td>
                                <td>
                                  <a href="{{ route('students.show', $student->id) }}"><i class="material-icons text-primary pr-2" onMouseOver='this.classList.remove("text-primary"); this.classList.add("text-warning");' onMouseOut='this.classList.add("text-primary");'>visibility</i></a>                                  @if(auth()->user()->hasRole('admin'))
                                  <a href="{{ route('classes.un-assign-student', [$class->id, $student->id]) }}"><i class="material-icons text-primary pr-2" onMouseOver='this.classList.remove("text-primary"); this.classList.add("text-warning");' onMouseOut='this.classList.add("text-primary");'>clear</i></a>                                  @endif
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif @if(auth()->user()->hasRole('faculty'))
                  <div class="tab-pane" id="attendance">
                    <div class="row">
                      <div class="col-md-12">
                        <h3>{{ now()->format('l - F d, Y') }}</h3>
                        <hr>
                        <div class="table-responsive">
                          <table class="table table-hover">
                            <thead class="text-primary">
                              <tr>
                                <th>#</th>
                                <th>Student</th>
                                <th>Status</th>
                                <th>Note</th>
                              </tr>
                            </thead>
                            <tbody>
                              @if($class->students->count() == 0)
                              <tr>
                                <td colspan="4" style="text-align: center">No Records Found</td>
                              </tr>
                              @endif
                              <form method="POST" action="{{ route('attendance.store', $class->id) }}">
                                @csrf @if(!$class->hasConductedAttendance()) @foreach($class->students as $key => $student)
                                <tr>
                                  <td>{{ ++$key }}</td>
                                  <td>{{ $student->user->fullname() }}</td>
                                  <td>
                                    <div class="form-check-inline">
                                      <input type="radio" class="form-check-input" name="student[{{$student->id}}][status]" id="attendance_option_{{$student->id}}"
                                        value="present" required>
                                      <label for="attendance_option_{{$student->id}}" class="form-check-label" style="font-size: 1rem">Present</label>
                                    </div>
                                    <div class="form-check-inline">
                                      <input type="radio" class="form-check-input" name="student[{{$student->id}}][status]" id="attendance_option_{{$student->id}}"
                                        value="absent" required>
                                      <label for="attendance_option_{{$student->id}}" class="form-check-label" style="font-size: 1rem">Absent</label>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="form-group bmd-form-group" style="padding-top: 0; margin: 0">
                                      <input type="text" class="form-control" name="student[{{$student->id}}][note]" placeholder="Note" />
                                    </div>
                                  </td>
                                </tr>
                                @endforeach @else @foreach($attendances as $key => $attendance)
                                <tr>
                                  <td>{{ ++$key }}</td>
                                  <td>{{ $attendance->student->user->fullname() }}</td>
                                  <td>
                                    @if($attendance->status == 'absent')
                                    <span class="text-danger">{{ ucfirst($attendance->status) }}</span> @else {{ ucfirst($attendance->status)
                                    }} @endif
                                  </td>
                                  <td>{{ ucfirst($attendance->note) }}</td>
                                </tr>
                                @endforeach @endif @if(!$class->hasConductedAttendance())
                                <tr>
                                  <td colspan="4" style="text-align: center">
                                    <div class="col-md-6 m-auto">
                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <select id="instructor" class="form-control" name="period" style="font-size: 16px;" required>
                                                <option value="">Period</option>
                                                <option value="prelim">Prelim</option>
                                                <option value="midterm">Midterm</option>
                                                <option value="finals">Finals</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <button type="submit" class="btn btn-warning">Submit </button>
                                        </div>
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                                @endif
                              </form>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="activities">
                    <div class="row">
                      <div class="col-md-12">
                        <button id="add-activity" class="btn btn-warning" style="float: center">
                            <i class="material-icons">add</i> Add Activity
                          </button>
                        <hr>
                        <div class="table-responsive">
                          <table class="table table-hover">
                            <thead class="text-primary">
                              <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Period</th>
                                <th>Type</th>
                                <th>Number of Items</th>
                                <th>Time</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @if($class->activities->count() == 0)
                              <tr>
                                <td colspan="7" style="text-align: center">No Records Found</td>
                              </tr>
                              @endif @foreach($class->activities as $key => $activity)
                              <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $activity->name }}</td>
                                <td>{{ ucfirst($activity->period) }}</td>
                                <td>{{ $activity->type }}</td>
                                <td>{{ $activity->items }}</td>
                                <td>{{ $activity->time }}</td>
                                <td>
                                  <a href="{{ route('activity.show', $activity->id) }}"><i class="material-icons text-primary pr-2" onMouseOver='this.classList.remove("text-primary"); this.classList.add("text-warning");' onMouseOut='this.classList.add("text-primary");'>visibility</i></a>
                                </td>
                              </tr>
                              @endforeach
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

@if(auth()->user()->hasRole('admin'))
<div class="modal fade" id="add-students-form" tabindex="-1" role="dialog" style="padding-right: 17px; display: block; z-index: -999;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Assign Students</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i class="material-icons">clear</i>
            </button>
      </div>
      <form method="POST" action="{{ route('classes.assign-student', $class->id) }}">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="label">Student</label>
                <select id="instructor" class="form-control" name="student">
                    <option value=""> -- </option>
                    @foreach ($students as $student)
                      <option value="{{ $student->id }}">{{ $student->user->fullname() }}</option>
                    @endforeach
                  </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning m-1">Submit</button>
          <button type="button" class="btn btn-warning m-1" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endif @if(auth()->user()->hasRole('faculty'))
<div class="modal fade" id="add-activity-form" tabindex="-1" role="dialog" style="padding-right: 17px; display: block; z-index: -999;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Activity</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="material-icons">clear</i>
          </button>
      </div>
      <form method="POST" action="{{ route('activity.store', $class->id) }}">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="label">Period</label>
                <select id="instructor" class="form-control" name="period">
                  <option value=""> -- </option>
                    <option value="prelim">Prelim</option>
                    <option value="midterm">Midterm</option>
                    <option value="finals">Finals</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group bmd-form-group">
                <label class="bmd-label-floating">Activity Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required/>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="label">Activity Type</label>
                <select id="instructor" class="form-control" name="type">
                    <option value=""> -- </option>
                    @foreach ($activityTypes as $activityType)
                      <option value="{{ $activityType }}">{{ $activityType }}</option>
                    @endforeach
                  </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group bmd-form-group">
                <label class="bmd-label-floating">Number of Items</label>
                <input type="number" class="form-control" name="items" value="{{ old('items') }}" required/>
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
                    <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <select class="form-control" name="schedule[time][minutes]">
                  <option value="">MM</option>
                  @for($i = 0; $i <= 60; $i++)
                    <option value="{{ $i < 10 ? '0' . $i : $i }}">{{ $i < 10 ? '0' . $i : $i}}</option>
                  @endfor
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <select class="form-control" name="schedule[time][daytime]">
                  <option value="AM">AM</option>
                  <option value="PM">PM</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning m-1">Submit</button>
          <button type="button" class="btn btn-warning m-1" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endif
@endsection
 
@section('js')
<script>
  $(document).ready(function() {
    $('#add-students').click(function() {
      $('#add-students-form').modal({ show : true })
      $('.modal-backdrop').removeClass('modal-backdrop')
      $('#add-students-form').css('z-index', '99')
    })

    $('#add-activity').click(function() {
      $('#add-activity-form').modal({ show : true })
      $('.modal-backdrop').removeClass('modal-backdrop')
      $('#add-activity-form').css('z-index', '99')
    })
  })

</script>
@endsection