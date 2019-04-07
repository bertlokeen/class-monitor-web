@extends('layouts.master') 
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item text-primary" aria-current="page">Classes</li>
  </ol>
</nav>
@endsection
 
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header card-header-primary">
      @if(auth()->user()->hasRole('admin'))
      <span class="actions float-right">
        <a href="{{ route('classes.create') }}" class="btn btn-warning">
          <i class="material-icons">add</i> Add Class
        </a>
      </span> @endif
      <h4 class="card-title mt-0"> Class List</h4>
      <p class="card-category"> Showing {{ $classes->count() }} out of {{ $classes->total() }}</p>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="text-primary">
            <tr>
              <th>#</th>
              <th>Course</th>
              <th>Year</th>
              <th>Section</th>
              <th>Subject</th>
              <th>Instructor</th>
              @if(auth()->user()->hasRole(['admin', 'faculty']))
              <th>Student Count</th>
              @endif
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if($classes->count() == 0)
            <tr style="text-align: center">
              <td colspan="{{ auth()->user()->hasRole(['admin', 'faculty']) ? '8' : '7' }}">
                No Records Found
              </td>
            </tr>
            @endif @foreach($classes as $key => $class)
            <tr>
              <td>{{ ++$key }}</td>
              <td>{{ $class->course }}</td>
              <td>{{ $class->year }}</td>
              <td>{{ $class->section }}</td>
              <td>{{ $class->subject->name }}</td>
              <td>{{ $class->faculty->user->fullname() }}</td>
              @if(auth()->user()->hasRole(['admin', 'faculty']))
              <td>{{ $class->students->count() }}</td>
              @endif
              <td>
                <a href="{{ route('classes.show', $class->id) }}"><i class="material-icons text-primary pr-2" onMouseOver='this.classList.remove("text-primary"); this.classList.add("text-warning");' onMouseOut='this.classList.add("text-primary");'>visibility</i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="row" style="float: right">
        {{ $classes->links() }}
      </div>
    </div>
  </div>
</div>
@endsection