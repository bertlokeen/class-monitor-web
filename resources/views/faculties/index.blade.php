@extends('layouts.master') 
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item" aria-current="page">Faculties</li>
  </ol>
</nav>
@endsection
 
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header card-header-primary">
      <span class="actions float-right">
        <a href="{{ route('faculty.create') }}" class="btn btn-warning">
          <i class="material-icons">add</i> Add Faculty
        </a>
      </span>
      <h4 class="card-title mt-0"> Faculty List</h4>
      <p class="card-category"> Showing {{ $faculties->count() }} out of {{ $faculties->total() }}</p>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="text-primary">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if($faculties->count() == 0)
            <tr style="text-align: center">
              <td colspan="4">
                No Records Found
              </td>
            </tr>
            @endif @foreach($faculties as $key => $faculty)
            <tr>
              <td>{{ ++$key }}</td>
              <td>{{ $faculty->user->last_name }}, {{ $faculty->user->first_name }} {{ $faculty->user->middle_name }}</td>
              <td>{{ $faculty->user->email }}</td>
              <td>
                <a href="{{ route('faculty.show', $faculty->id) }}"><i class="material-icons text-primary pr-2" onMouseOver='this.classList.remove("text-primary"); this.classList.add("text-warning");' onMouseOut='this.classList.add("text-primary");'>visibility</i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="row" style="float: right">
        {{ $faculties->links() }}
      </div>
    </div>
  </div>
</div>
@endsection