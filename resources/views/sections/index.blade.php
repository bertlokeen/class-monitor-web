@extends('layouts.master')

@section('header', 'Sections')

@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header card-header-warning">
      <span class="actions float-right">
        <button class="btn btn-primary">
          <i class="material-icons">add</i> Add Sections
        </button>
      </span>
      <h4 class="card-title mt-0"> Sections List</h4>
      <p class="card-category"> Showing 10 out of 120</p>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="">
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
            @for($i = 0; $i <=10; $i++)
            <tr>
              <td>{{ $i }}</td>
              <td>Student {{ $i }}</td>
              <td>Student {{ $i }}</td>
              <td>Student {{ $i }}</td>
              <td>Student {{ $i }}</td>
              <td>
                <i class="material-icons text-primary pr-2">visibility</i>
                <i class="material-icons text-warning pr-2">edit</i>
                <i class="material-icons text-danger pr-2">delete</i>
              </td>
            </tr>
            @endfor
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
