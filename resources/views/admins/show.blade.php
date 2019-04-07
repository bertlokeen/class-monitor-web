@extends('layouts.master') 
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admins</a></li>
    <li class="breadcrumb-item text-warning" aria-current="page">{{ $admin->user->fullname() }}</li>
  </ol>
</nav>
@endsection
 
@section('content')
<div class="col-md-12 pt-3">
  <div class="row">
    <div class="container-fluid">
      @if($errors->any())
      <div class="alert alert-danger mb-2">
        <div class="container">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="material-icons">clear</i></span>
          </button> @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </div>
      </div>
      @endif @if(session('status'))
      <div class="alert alert-success text-default">
        <div class="container">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="material-icons">clear</i></span>
          </button>
          <b>{{ session()->get('status') }}!</b>
        </div>
      </div>
      @endif
      <div class="row">
        <div class="col-md-4">
          <div class="card card-profile">
            <div class="card-avatar">
              <a href="#">
                  <img class="img" src="../assets/img/faces/marc.jpg">
                </a>
            </div>
            <div class="card-body">
              <h6 class="card-category text-gray">Admin</h6>
              <h4 class="card-title">{{ $admin->user->last_name }}, {{ $admin->user->first_name }} {{ $admin->user->middle_name }}</h4>
              <p class="card-description">
                {{ $admin->bio }}
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-header-primary">
              <span class="actions float-right pt-3">
                  <a href="{{ route('admin.edit', $admin->id) }}" class="text-white">
                    <i class="material-icons">edit</i>
                  </a>&nbsp;
                  <a href="{{ route('admin.destroy', $admin->id) }}" class="text-white" onclick="event.preventDefault(); confirm('Are you sure you want to delete?') ? document.getElementById('delete-form').submit() : '' ">
                    <i class="material-icons">delete</i>
                  </a>

                  <form id="delete-form" action="{{ route('admin.destroy', $admin->id) }}" method="POST"  style="display: none;">
                      @csrf
                      {{ method_field('DELETE') }}
                  </form>
                </span>
              <h4 class="card-title">Profile</h4>
              <p class="card-category">Admin Information</p>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <hr>
                  <div class="row pb-2">
                    <div class="col-md-6">
                      <p>Father's Name</p>
                      <b><p>{{ $admin->user->father_name }}</p></b>
                    </div>
                    <div class="col-md-6">
                      <p>Mother's Name</p>
                      <b><p>{{ $admin->user->mother_name }}</p></b>
                    </div>
                  </div>
                  <hr>
                  <div class="row pb-2">
                    <div class="col-md-12">
                      <p>Address</p>
                      <span>{{ $admin->user->address }}</span>
                    </div>
                  </div>
                  <hr>
                  <div class="row pb-4">
                    <div class="col-md-6">
                      <p>Date of Birth</p>
                      <b><p>{{ $admin->user->date_of_birth }}</p></b>
                    </div>
                    <div class="col-md-6">
                      <p>Place of Birth</p>
                      <b><p>{{ $admin->user->place_of_birth }}</p></b>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection