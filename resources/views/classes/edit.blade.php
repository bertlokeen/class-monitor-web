@extends('layouts.master') 
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Classes</a></li>
    <li class="breadcrumb-item text-primary"><a href="{{ route('classes.show', $class->id) }}">{{ $class->course }} {{ $class->year }}-{{ $class->section }} {{ $class->subject->name }}</a></li>
    <li class="breadcrumb-item text-warning" aria-current="page">Edit</li>
  </ol>
</nav>
@endsection
 
@section('content')
<div class="col-md-8" style="margin: auto;">
  <div class="card">
    <div class="card-header card-header-primary">
      <h4 class="card-title">Class</h4>
      <p class="card-category">Information</p>
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
            <b>{{ session()->get('status') }}</b>
          </div>
        </div>
        @endif
      </div>
      <form method="POST" action="{{ route('classes.update', $class->id) }}">
        @csrf {{ method_field('PUT') }}
        <div class="row">
          <div class="col-md-10 m-auto">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="label">Instructor</label>
                  <select id="instructor" class="form-control" name="instructor">
                    <option value=""> -- </option>
                    @if(request()->filled('id'))
                      @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->id }}" {{ request()->query('id') == $faculty->id ? 'selected' : '' }}>{{ $faculty->user->fullname() }}</option>
                      @endforeach
                    @else
                      @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->id }}" {{ $class->faculty->id == $faculty->id ? 'selected' : '' }}>{{ $faculty->user->fullname() }}</option>
                      @endforeach 
                    @endif
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group ">
                  <label class="label">Subject Name </label>
                  <select class="form-control" name="subject">
                    <option value=""> -- </option>
                    @foreach ($subjects as $subject)
                      <option value="{{ $subject->id }}" {{ $class->subject->id == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label class="label">Course Year & Section</label>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <select class="form-control" name="course">
                    <option value=""> -- </option>
                    @foreach($courses as $course)
                      <option value="{{ $course }}" {{ $class->course == $course ? 'selected' :'' }}>{{ $course }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <select class="form-control" name="year">
                    <option value=""> -- </option>
                    @for($i = 1; $i <= 4; $i++)
                      <option value="{{ $i }}" {{ $class->year == $i ? 'selected' :'' }}>{{ $i }}</option>
                    @endfor
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <select class="form-control" name="section">
                    <option value=""> -- </option>
                    @for($i = 1; $i <= 4; $i++)
                      <option value="{{ $i }}" {{ $class->section == $i ? 'selected' :'' }}>{{ $i }}</option>
                    @endfor
                  </select>
                </div>
              </div>
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
 
@section('js')
<script>
  $(document).ready(function() {
    $('#instructor').change(function() {
      location = location.href.split('?')[0] + '?id=' + this.value
    })
  })

</script>
@endsection