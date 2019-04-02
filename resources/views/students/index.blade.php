@extends('layouts.master')

@section('header', 'Students')

@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header card-header-warning">
      <span class="actions float-right">
        <a href="{{ route('students.create') }}" class="btn btn-primary">
          <i class="material-icons">add</i> Add Students
        </a>
      </span>
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
            <th>Program</th>
            <th>Year</th>
            <th>Section</th>
            <th style="width: 12%">Action</th>
          </tr>
        </thead>
          <tbody>
            @foreach($students as $key => $student)
            <tr>
              <td>{{ ++$key }}</td>
              <td>{{ $student->user->last_name }}, {{ $student->user->first_name }} {{ $student->user->middle_name }}</td>
              <td> - </td>
              <td> - </td>
              <td> - </td>
              <td>
                <i class="material-icons text-primary pr-2">visibility</i>
                <i class="material-icons text-warning pr-2">edit</i>
                <i class="material-icons text-danger pr-2">delete</i>
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
