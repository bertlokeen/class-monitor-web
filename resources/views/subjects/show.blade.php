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
                </span>
              <h4 class="card-title">Subject</h4>
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
                    <li class="nav-item">
                      <a class="nav-link" href="#attendance" role="tab" data-toggle="tab">
                          <i class="material-icons">date_range</i> Classes
                        </a>
                    </li>
                  </ul>
                </div>
                <div class="tab-content tab-space">
                  <div class="tab-pane active" id="information">
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
                  <div class="tab-pane" id="attendance">
                    <div class="row">
                      <div class="col-md-12">
                        <hr>
                        <div class="table-responsive">
                          <table class="table table-hover">
                            <thead class="text-primary">
                              <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>Schedule</th>
                                <th>Class</th>
                              </tr>
                            </thead>
                            <tbody>
                              @for($i = 0; $i
                              <=9; $i++) <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $subject->name }}</td>
                                <td> - </td>
                                <td> - </td>
                                </tr>
                                @endfor
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
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