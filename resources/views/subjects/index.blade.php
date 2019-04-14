@extends('layouts.master') 
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item text-primary" aria-current="page">Subjects</li>
  </ol>
</nav>
@endsection
 
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header card-header-primary">
      @if(auth()->user()->hasRole('admin'))
      <span class="actions float-right">
        <a href="{{ route('subjects.create') }}" class="btn btn-warning">
          <i class="material-icons">add</i> Add Subject
        </a>
      </span> @endif
      <h4 class="card-title mt-0"> Subject List</h4>
      <p class="card-category"> Showing {{ $subjects->count() }} out of {{ $subjects->total() }}</p>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="text-primary">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Instructor</th>
              <th>Units</th>
              <th>Schedule</th>
              <th>Time</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if($subjects->count() == 0)
            <tr style="text-align: center">
              <td colspan="7">
                No Records Found
              </td>
            </tr>
            @endif @foreach($subjects as $key => $subject)
            <tr>
              <td>{{ ++$key }}</td>
              <td>{{ $subject->name}}</td>
              <td>{{ $subject->faculty->user->fullname() }}</td>
              <td>{{ $subject->units }}</td>
              <td>{{ $subject->schedules() }}</td>
              <td>{{ $subject->time }}</td>
              <td>
                <a href="{{ route('subjects.show', $subject->id) }}"><i class="material-icons text-primary pr-2" onMouseOver='this.classList.remove("text-primary"); this.classList.add("text-warning");' onMouseOut='this.classList.add("text-primary");'>visibility</i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="row" style="float: right">
        {{ $subjects->links() }}
      </div>
    </div>
  </div>
</div>
@endsection