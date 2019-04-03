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
            <b>Faculty updated successfully!</b>
          </div>
        </div>
        @endif
      </div>
      <form method="POST" action="{{ route('faculty.update', $faculty->id) }}">
        @csrf {{ method_field('PUT') }}
        <div class="row">
          <div class="col-md-4">
            <div class="form-group bmd-form-group {{ $errors->has('first_name') ? ' has-danger' : '' }}">
              <label class="bmd-label-floating">Fist Name *</label>
              <input type="text" class="form-control" name="first_name" value="{{ $faculty->user->first_name }}" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating">Middle Name</label>
              <input type="text" class="form-control" name="middle_name" value="{{ $faculty->user->middle_name }}" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group bmd-form-group {{ $errors->has('last_name') ? ' has-danger' : '' }} ">
              <label class="bmd-label-floating">Last Name *</label>
              <input type="text" class="form-control" name="last_name" value="{{ $faculty->user->last_name }}" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating">Father's Name</label>
              <input type="text" class="form-control" name="father_name" value="{{ $faculty->user->father_name }}" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating">Mother's Name</label>
              <input type="text" class="form-control" name="mother_name" value="{{ $faculty->user->mother_name }}" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating"> Address</label>
              <textarea class="form-control" rows="3" name="address">{{ $faculty->user->address }}</textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group bmd-form-group is-filled">
              <label class="label-control bmd-label-static">Date of Birth</label>
              <input type="text" class="form-control" name="date_of_birth" value="{{ $faculty->user->date_of_birth }}" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating">Place of Birth</label>
              <input type="text" class="form-control" name="place_of_birth" value="{{ $faculty->user->place_of_birth }}" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group bmd-form-group">
              <label class="bmd-label-floating">Bio </label>
              <textarea class="form-control" rows="3" name="bio">{{ $faculty->bio }}</textarea>
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