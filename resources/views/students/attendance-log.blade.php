@extends('layouts.master') 
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      @if(auth()->user()->hasRole('admin'))
      <a href="{{ route('students.index') }}">Students</a> @endif
      <span class="text-primary">Students</span>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('students.show', $student->id) }}">{{ $student->user->fullname() }}</a></li>
    <li class="breadcrumb-item text-warning" aria-current="page">Attendance Log</li>
  </ol>
</nav>
@endsection
 
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header card-header-primary">
      <h4 class="card-title mt-0"> Attendance List</h4>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="text-primary">
            <tr>
              <th>Date</th>
              <th>Period</th>
              <th>Status</th>
              <th>Notes</th>
            </tr>
          </thead>
          <tbody>
            @if(count($attendanceLogs) == 0)
            <tr style="text-align: center">
              <td colspan="4">
                No Records Found
              </td>
            </tr>
            @endif @foreach($attendanceLogs as $key => $periods) @foreach($periods as $key2 => $period)
            <tr>
              <td>{{ $key2 }}</td>
              <td>{{ ucfirst($key) }}</td>
              <td>
                @if(empty(array_diff(array_column($period, 'status'), ['present'])))
                <b><span class="text-primary">Present</span></b> @elseif(empty(array_diff(array_column($period, 'status'),
                ['absent'])))
                <b><span class="text-danger">Absent</span></b> @elseif(empty(array_diff(array_column($period, 'status'),
                ['present', 'absent'])))
                <b><span class="text-warning">Partial</span></b> @endif
              </td>
              <td>
                @foreach ($period as $key2 => $l) 
                  @if(!empty($l['note'])) 
                    [ {{ $l['note'] }} ]
                  @endif
                @endforeach
              </td>
            </tr>

            @endforeach @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection