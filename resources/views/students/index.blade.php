@extends('layouts.master') 
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item text-primary" aria-current="page">Students</li>
  </ol>
</nav>
@endsection
 
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header card-header-primary">
      @if(auth()->user()->hasRole('admin'))
      <span class="actions float-right">
        <a href="{{ route('students.create') }}" class="btn btn-warning">
          <i class="material-icons">add</i> Add Students
        </a>
      </span> @endif
      <h4 class="card-title mt-0"> Student List</h4>
      <p class="card-category"> Showing {{ $students->count() }} out of {{ $students->total() }}</p>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="text-primary">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Program</th>
              <th>Year</th>
              <th>Section</th>
              <th>Summary Rating</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if($students->count() == 0)
            <tr style="text-align: center">
              <td colspan="8">
                No Records Found
              </td>
            </tr>
            @endif @foreach($students as $key => $student)
            <tr>
              <td>{{ ++$key }}</td>
              <td>{{ $student->user->last_name }}, {{ $student->user->first_name }} {{ $student->user->middle_name }}</td>
              <td>{{ $student->user->email }}</td>
              <td>{{ $student->course }}</td>
              <td>{{ $student->year }}</td>
              <td>{{ $student->section }}</td>
              <td>89%</td>
              <td>
                <a href="{{ route('students.show', $student->id) }}"><i class="material-icons text-primary pr-2" onMouseOver='this.classList.remove("text-primary"); this.classList.add("text-warning");' onMouseOut='this.classList.add("text-primary");'>visibility</i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="row" style="float: right">
        {{ $students->links() }}
      </div>
    </div>
  </div>
</div>
@endsection