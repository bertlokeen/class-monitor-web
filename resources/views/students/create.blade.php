@extends('layouts.master')

@section('header', 'Create Student')

@section('content')
<div class="col-md-8" style="margin: auto;">
  <div class="card">
    <div class="card-header card-header-warning">
        <h4 class="card-title">Profile</h4>
        <p class="card-category">Student Information</p>
      </div>
      <div class="card-body">
        <div class="container">
          @if($errors->any())
            <div class="alert alert-danger">
              <div class="container">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true"><i class="material-icons">clear</i></span>
                </button>
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </div>
            </div>
          @endif

          @if(session('status'))
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
                <input type="text" class="form-control datetimepicker" name="date_of_birth" value="{{ old('date_of_birth') }}" />
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
                  <input class="form-control" name="skills" value="{{ old('skills') }}"/>
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
</div>
@endsection
