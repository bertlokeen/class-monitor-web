@extends('layouts.master') 
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('faculty.index') }}">Faculties</a></li>
    <li class="breadcrumb-item text-warning" aria-current="page">{{ $faculty->user->fullname() }}</li>
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
          <b>Faculty updated successfully!</b>
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
              <h6 class="card-category text-gray">Faculty</h6>
              <h4 class="card-title">{{ $faculty->user->last_name }}, {{ $faculty->user->first_name }} {{ $faculty->user->middle_name }}</h4>
              <p class="card-description">
                {{ $faculty->bio }}
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-header-primary">
              <span class="actions float-right pt-3">
                  <a href="{{ route('faculty.edit', $faculty->id) }}" class="text-white">
                    <i class="material-icons">edit</i>
                  </a>&nbsp;
                  <a href="{{ route('faculty.destroy', $faculty->id) }}" class="text-white" onclick="event.preventDefault(); confirm('Are you sure you want to delete?') ? document.getElementById('delete-form').submit() : '' ">
                    <i class="material-icons">delete</i>
                  </a>

                  <form id="delete-form" action="{{ route('faculty.destroy', $faculty->id) }}" method="POST"  style="display: none;">
                      @csrf
                      {{ method_field('DELETE') }}
                  </form>
                </span>
              <h4 class="card-title">Profile</h4>
              <p class="card-category">Faculty Information</p>
            </div>
            <div class="card-body">
              <div class="col-md-12">
                <div class="row">
                  <ul class="nav nav-pills nav-pills-icons justify-content-left" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" href="#information" role="tab" data-toggle="tab">
                          <i class="material-icons">info</i> Information
                        </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#attendance" role="tab" data-toggle="tab">
                          <i class="material-icons">date_range</i> Classes
                        </a>
                    </li>
                  </ul>
                </div>
                <div class="tab-content tab-space">
                  <div class="tab-pane active" id="information">
                    <div class="row">
                      <div class="col-md-12">
                        <hr>
                        <div class="row pb-2">
                          <div class="col-md-6">
                            <p>Father's Name</p>
                            <b><p>{{ $faculty->user->father_name }}</p></b>
                          </div>
                          <div class="col-md-6">
                            <p>Mother's Name</p>
                            <b><p>{{ $faculty->user->mother_name }}</p></b>
                          </div>
                        </div>
                        <hr>
                        <div class="row pb-2">
                          <div class="col-md-12">
                            <p><b>Address</b></p>
                            <span>{{ $faculty->user->address }}</span>
                          </div>
                        </div>
                        <hr>
                        <div class="row pb-4">
                          <div class="col-md-6">
                            <p>Date of Birth</p>
                            <b><p>{{ $faculty->user->date_of_birth }}</p></b>
                          </div>
                          <div class="col-md-6">
                            <p>Place of Birth</p>
                            <b><p>{{ $faculty->user->place_of_birth }}</p></b>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="attendance">
                    <div class="row">
                      <div class="col-md-12">
                        <hr>
                        <div class="table-responsive">
                          <table class="table table-hover">
                            <thead class="text-primary">
                              <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>Schedule</th>
                                <th>Class</th>
                              </tr>
                            </thead>
                            <tbody>
                              @for($i = 0; $i
                              <=9; $i++) <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $faculty->user->last_name }}, {{ $faculty->user->last_name }} {{ $faculty->user->middle_name
                                  }}
                                </td>
                                <td> - </td>
                                <td> - </td>
                                </tr>
                                @endfor
                            </tbody>
                          </table>
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
</div>
@endsection