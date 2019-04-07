@extends('layouts.master') 
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Students</a></li>
    <li class="breadcrumb-item text-warning" aria-current="page">Add</li>
  </ol>
</nav>
@endsection
 
@section('content')
<div class="col-md-8" style="margin: auto;">
  <div class="card">
    <div class="card-header card-header-primary">
      <h4 class="card-title">Create Profile</h4>
      <p class="card-category">Student Information</p>
    </div>
    <div class="card-body">
      <div class="container">
        @if($errors->any())
        <div class="alert alert-danger">
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
            <b>Student created successfully!</b>
          </div>
        </div>
        @endif
      </div>
      <form method="POST" action="{{ route('students.store') }}">
        @csrf
        <h3>Account Credentials</h3>
        <hr>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group bmd-form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
              <label class="bmd-label-floating">Email *</label>
              <input type="email" class="form-control" name="email" value="{{ old('email') }}" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group bmd-form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
              <label class="bmd-label-floating">Password *</label>
              <input type="password" class="form-control" name="password" value="{{ old('password') }}" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group bmd-form-group {{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
              <label class="bmd-label-floating">Confirm Password *</label>
              <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" />
            </div>
          </div>
        </div>
        <h3>Course Year & Section</h3>
        <hr>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <select class="form-control" name="course">
                    <option value=""> -- </option>
                    @foreach($courses as $course)
                      <option value="{{ $course }}">{{ $course }}</option>
                    @endforeach
                  </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <select class="form-control" name="year">
                    <option value=""> -- </option>
                    @for($i = 1; $i <= 4; $i++)
                      <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                  </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <select class="form-control" name="section">
                    <option value=""> -- </option>
                    @for($i = 1; $i <= 4; $i++)
                      <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                  </select>
            </div>
          </div>
        </div>
        <h3>Basic Information</h3>
        <hr>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group bmd-form-group {{ $errors->has('first_name') ? ' has-danger' : '' }}">
              <label class="bmd-label-floating">Fist Name *</label>
              <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating">Middle Name</label>
              <input type="text" class="form-control" name="middle_name" value="{{ old('middle_name') }}" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group bmd-form-group {{ $errors->has('last_name') ? ' has-danger' : '' }} ">
              <label class="bmd-label-floating">Last Name *</label>
              <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating">Father's Name</label>
              <input type="text" class="form-control" name="father_name" value="{{ old('father_name') }}" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating">Mother's Name</label>
              <input type="text" class="form-control" name="mother_name" value="{{ old('mother_name') }}" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating"> Address</label>
              <textarea class="form-control" rows="3" name="address" value="{{ old('address') }}"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group bmd-form-group is-filled">
              <label class="label-control bmd-label-static">Date of Birth</label>
              <input type="text" class="form-control" name="date_of_birth" value="{{ old('date_of_birth') }}" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating">Place of Birth</label>
              <input type="text" class="form-control" name="place_of_birth" value="{{ old('place_of_birth') }}" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating">Bio </label>
              <textarea class="form-control" rows="3" name="bio" value="{{ old('bio') }}"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating">Skills </label>
              <input class="form-control" name="skills" value="{{ old('skills') }}" />
              <span class="text-info">Separated by comma *</span>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-warning pull-right">Submit</button>
        <div class="clearfix"></div>
      </form>
    </div>
  </div>
</div>
@endsection