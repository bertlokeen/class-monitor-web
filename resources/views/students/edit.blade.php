@extends('layouts.master') 
@section('header', 'Update Student Profile') 
@section('content')
<div class="col-md-8" style="margin: auto;">
  <div class="card">
    <div class="card-header card-header-primary">
      <h4 class="card-title">Edit Profile</h4>
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
            <b>Student updated successfully!</b>
          </div>
        </div>
        @endif
      </div>
      <form method="POST" action="{{ route('students.update', $student->id) }}">
        @csrf {{ method_field('PUT') }}
        <h3>Account Credentials</h3>
        <hr>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group bmd-form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
              <label class="bmd-label-floating">Email *</label>
              <input type="email" class="form-control" name="email" value="{{ $student->user->email }}" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group bmd-form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
              <label class="bmd-label-floating">Password *</label>
              <input type="password" class="form-control" name="password" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group bmd-form-group {{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
              <label class="bmd-label-floating">Confirm Password *</label>
              <input type="password" class="form-control" name="password_confirmation" />
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
                  <option value="{{ $course }}" {{ $student->course == $course ? 'selected' : '' }}>{{ $course }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <select class="form-control" name="year">
                <option value=""> -- </option>
                @for($i = 1; $i <= 4; $i++)
                  <option value="{{ $i }}" {{ $student->year == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <select class="form-control" name="section">
                <option value=""> -- </option>
                @for($i = 1; $i <= 4; $i++)
                  <option value="{{ $i }}" {{ $student->section == $i ? 'selected' : '' }}>{{ $i }}</option>
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
              <input type="text" class="form-control" name="first_name" value="{{ $student->user->first_name }}" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating">Middle Name</label>
              <input type="text" class="form-control" name="middle_name" value="{{ $student->user->middle_name }}" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group bmd-form-group {{ $errors->has('last_name') ? ' has-danger' : '' }} ">
              <label class="bmd-label-floating">Last Name *</label>
              <input type="text" class="form-control" name="last_name" value="{{ $student->user->last_name }}" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating">Father's Name</label>
              <input type="text" class="form-control" name="father_name" value="{{ $student->user->father_name }}" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating">Mother's Name</label>
              <input type="text" class="form-control" name="mother_name" value="{{ $student->user->mother_name }}" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating"> Address</label>
              <textarea class="form-control" rows="3" name="address">{{ $student->user->address }}</textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group bmd-form-group is-filled">
              <label class="label-control bmd-label-static">Date of Birth</label>
              <input type="text" class="form-control" name="date_of_birth" value="{{ $student->user->date_of_birth }}" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating">Place of Birth</label>
              <input type="text" class="form-control" name="place_of_birth" value="{{ $student->user->place_of_birth }}" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating">Bio </label>
              <textarea class="form-control" rows="3" name="bio">{{ $student->bio }}</textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating">Skills </label>
              <input class="form-control" name="skills" value="{{ $student->skills }}" />
              <span class="text-info">Separated by comma *</span>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-warning pull-right">Update</button>
        <div class="clearfix"></div>
      </form>
    </div>
  </div>
</div>
@endsection