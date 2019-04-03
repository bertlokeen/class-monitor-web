@extends('layouts.master') 
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item text-primary" aria-current="page">Admins</li>
  </ol>
</nav>
@endsection
 
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header card-header-primary">
      <span class="actions float-right">
        <a href="{{ route('admin.create') }}" class="btn btn-warning">
          <i class="material-icons">add</i> Add Admin
        </a>
      </span>
      <h4 class="card-title mt-0"> Faculty List</h4>
      <p class="card-category"> Showing {{ $admins->count() }} out of {{ $admins->total() }}</p>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="text-primary">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($admins as $key => $admin)
            <tr>
              <td>{{ ++$key }}</td>
              <td>{{ $admin->user->last_name }}, {{ $admin->user->first_name }} {{ $admin->user->middle_name }}</td>
              <td>
                <a href="{{ route('admin.show', $admin->id) }}"><i class="material-icons text-primary pr-2" onMouseOver='this.classList.remove("text-primary"); this.classList.add("text-warning");' onMouseOut='this.classList.add("text-primary");'>visibility</i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="row" style="float: right">
        {{ $admins->links() }}
      </div>
    </div>
  </div>
</div>
@endsection