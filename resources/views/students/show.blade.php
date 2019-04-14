@extends('layouts.master') 
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    @if(auth()->user()->hasRole(['admin', 'faculty']))
    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Students</a></li>
    @else
    <li class="breadcrumb-item text-primary">Students</li>
    @endif
    <li class="breadcrumb-item text-warning" aria-current="page">{{ $student->user->fullname() }}</li>
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
          <b>Student updated successfully!</b>
        </div>
      </div>
      @endif
      <div class="row">
        <div class="col-md-4">
          <div class="card card-profile">
            <div class="card-avatar">
              <a href="#">
                  <img class="img" src="{{ asset('assets/img/avatar.png') }}">
                </a>
            </div>
            <div class="card-body">
              <h6 class="card-category text-gray">{{ $student->course }} {{ $student->year }}-{{ $student->section }}</h6>
              <h6 class="card-category text-gray">{{ $student->user->roles[0]->name }}</h6>
              <h4 class="card-title">{{ $student->user->last_name }}, {{ $student->user->first_name }} {{ $student->user->middle_name }}</h4>
              <p class="card-description">
                {{ $student->bio }}
              </p>
              @if (count($student->skills()) > 1) @foreach ($student->skills() as $skill)
              <a href="#" class="btn btn-primary btn-sm btn-round">{{ $skill }}</a> @endforeach @endif
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-header-primary">
              @if(auth()->user()->hasRole('admin'))
              <span class="actions float-right pt-3">
                  <a href="{{ route('students.edit', $student->id) }}" class="text-white">
                    <i class="material-icons">edit</i>
                  </a>&nbsp;
                  <a href="{{ route('students.destroy', $student->id) }}" class="text-white" onclick="event.preventDefault(); confirm('Are you sure you want to delete?') ? document.getElementById('delete-form').submit() : '' ">
                    <i class="material-icons">delete</i>
                  </a>

                  <form id="delete-form" action="{{ route('students.destroy', $student->id) }}" method="POST"  style="display: none;">
                      @csrf
                      {{ method_field('DELETE') }}
                  </form>
                </span> @endif
              <h4 class="card-title">Profile</h4>
              <p class="card-category">Student Information</p>
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
                      <a class="nav-link" href="#attendance-rating" role="tab" data-toggle="tab">
                          <i class="material-icons">date_range</i> Attendance
                        </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#performance" role="tab" data-toggle="tab">
                          <i class="material-icons">bar_chart</i> Performance
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
                          <div class="col-md-6">
                            <p>Father's Name</p>
                            <b><p>{{ $student->user->father_name }}</p></b>
                          </div>
                          <div class="col-md-6">
                            <p>Mother's Name</p>
                            <b><p>{{ $student->user->mother_name }}</p></b>
                          </div>
                        </div>
                        <hr>
                        <div class="row pb-2">
                          <div class="col-md-12">
                            <p><b>Address</b></p>
                            <span>{{ $student->user->address }}</span>
                          </div>
                        </div>
                        <hr>
                        <div class="row pb-4">
                          <div class="col-md-6">
                            <p>Date of Birth</p>
                            <b><p>{{ $student->user->date_of_birth }}</p></b>
                          </div>
                          <div class="col-md-6">
                            <p>Place of Birth</p>
                            <b><p>{{ $student->user->place_of_birth }}</p></b>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="attendance-rating">
                    <div class="row">
                      @if(count($performanceData['attendance']))
                        @if(auth()->user()->hasRole(['admin', 'student']))
                          <div class="col-md-12">
                            <a href="{{ route('students.attendance-log', $student->id) }}" class="btn btn-warning" style="float: center">
                                <i class="material-icons">visibility</i> View Attendance Log
                            </a>
                          </div>
                        @endif
                        @foreach ($performanceData['attendance'] as $key => $term)
                          <div class="col-md-12 m-0 p-0">
                            <hr>
                          </div>
                          <div class="col-md-9 m-auto">
                            <h3>{{ ucfirst($key) }}</h3>
                            <canvas id="attendance-chart-{{ $key }}"></canvas>
                          </div>
                          <div class="col-md-3">
                            <h3>Data</h3>
                            @foreach ($term as $key => $t)
                            <p>{{ ucfirst($key ) }} : <b>{{ $t }}</b></p>
                            @endforeach
                          </div>
                        @endforeach
                      @else
                        <div class="col-md-12">
                          <h3>No data available.</h3>
                        </div>
                      @endif
                    </div>
                  </div>
                  <div class="tab-pane" id="performance">
                    <div class="row">
                      @if(count($performanceData['performance']))
                        <div class="col-md-12">
                          <canvas id="performance-chart"></canvas>
                        </div>
                        <div class="col-md-12">
                          <h3>Data</h3>
                          @foreach ($performanceData['performance'] as $key => $performance)
                          <b>{{ ucfirst($key) }}</b> @foreach ($performance as $key2 => $p)
                          <p><a href="{{ route('subjects.show-by-name', strtolower($key2)) }}"> {{ ucfirst($key2) }}</a> : <b>{{ round($p, 2) }}%</b></p>@endforeach @endforeach
                        </div>
                      @else
                        <div class="col-md-12">
                          <h3>No data available.</h3>
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
  </div>
</div>
@endsection
 
@section('js')
<script>
  $(document).ready(function() {
    const colors = ['#9c27b0', '#ff9e0f', '#f55145'];

    const data = {!! json_encode($performanceData) !!}

    let config = [];

    Object.keys(data['attendance']).map(key => {
      config[key] = {
        type: 'doughnut',
        data: {
          datasets: [{
            data: Object.values(data['attendance'][key]),
            backgroundColor: colors
          }],
          labels: Object.keys(data['attendance'][key])
        },
        options: {
          responsive: true,
          legend: {
            position: 'right'
          }
        }
      }

      const ctx = $('#attendance-chart-' + key)[0].getContext('2d')

      const doughnutChart = new Chart(ctx, config[key])
    })

    let subjects = Object.keys(data['performance']['prelim'])

    let datasets = [];

    Object.keys(data['performance']).map(key => {
      datasets[key] = {
        label: key,
        backgroundColor: colors[Object.keys(data['performance']).indexOf(key)],
        data: Object.values(data['performance'][key])
      }
    })

    let configPerformance = {
      type: 'bar',
      data: {
        datasets: Object.values(datasets),
        labels: subjects
      },
      options: {
        responsive: true,
        legend: {
          position: 'right'
        }
      }
    }
    const ctx = $('#performance-chart')[0].getContext('2d')

    const barChart = new Chart(ctx, configPerformance)
  })

</script>
@endsection