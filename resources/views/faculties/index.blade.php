@extends('layouts.master')

@section('header', 'Faculties')

@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header card-header-warning">
      <span class="actions float-right">
        <a href="{{ route('students.create') }}" class="btn btn-primary">
          <i class="material-icons">add</i> Add Faculties
        </a>
      </span>
      <h4 class="card-title mt-0">Faculty List </h4>
      <p class="card-category"> Showing {{ $faculties->count() }} out of {{ $faculties->total() }}</p>
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
            @foreach($faculties as $key => $faculty)
            <tr>
              <td>{{ ++$key }}</td>
              <td>{{ $faculty->user->last_name }}, {{ $faculty->user->last_name }} {{ $faculty->user->middle_name }}</td>
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
    </div>
    {{ $faculties->links() }}
  </div>
</div>
@endsection
