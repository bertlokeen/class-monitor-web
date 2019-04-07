@extends('layouts.master') 
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item text-primary" aria-current="page">{{ $student->user->fullname() }}</li>
    <li class="breadcrumb-item text-warning" aria-current="page">Activities</li>
  </ol>
</nav>
@endsection
 
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header card-header-primary">
      <h4 class="card-title mt-0"> Activity List</h4>
      <p class="card-category"> Showing {{ $activities->count() }} out of {{ $activities->total() }}</p>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="text-primary">
            <tr>
              <th>#</th>
              <th>Subject</th>
              <th>Instructor</th>
              <th>Activity Name</th>
              <th>Score</th>
            </tr>
          </thead>
          <tbody>
            @foreach($activities as $key => $activity)
            <tr>
              <td>{{ ++$key }}</td>
              <td>{{ $activity->activity->sectionClass->subject->name }}</td>
              <td>{{ $activity->activity->sectionClass->faculty->user->fullname() }}</td>
              <td>{{ $activity->activity->name }}</td>
              <td>{{ $activity->score }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="row" style="float: right">
        {{ $activities->links() }}
      </div>
    </div>
  </div>
</div>
@endsection