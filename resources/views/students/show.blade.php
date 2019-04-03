@extends('layouts.master') 
@section('header', 'Student Profile') 
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
          <b>Student updated successfully!</b>
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
              <h6 class="card-category text-gray">BSIT 4-1</h6>
              <h4 class="card-title">{{ $student->user->last_name }}, {{ $student->user->first_name }} {{ $student->user->middle_name }}</h4>
              <p class="card-description">
                {{ $student->bio }}
              </p>
              @foreach ($student->skills() as $skill)
              <a href="#" class="btn btn-primary btn-sm btn-round">{{ $skill }}</a> @endforeach
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-header-primary">
              <span class="actions float-right pt-3">
                  <a href="{{ route('students.edit', $student->id) }}" class="text-white">
                    <i class="material-icons">edit</i>
                  </a>&nbsp;
                  <a href="{{ route('students.destroy', $student->id) }}" class="text-white" onclick="event.preventDefault(); confirm('Are you sure you want to delete?') ? document.getElementById('delete-form').submit() : '' ">
                    <i class="material-icons">delete</i>
                  </a>

                  <form id="delete-form" action="{{ route('students.destroy', $student->id) }}" method="POST"  style="display: none;">
                      @csrf
                      {{ method_field('DELETE') }}
                  </form>
                </span>
              <h4 class="card-title">Profile</h4>
              <p class="card-category">Student Information</p>
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
                          <i class="material-icons">date_range</i> Attendance
                        </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#performance" role="tab" data-toggle="tab">
                          <i class="material-icons">bar_chart</i> Performance
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
                            <b><p>{{ $student->user->father_name }}</p></b>
                          </div>
                          <div class="col-md-6">
                            <p>Mother's Name</p>
                            <b><p>{{ $student->user->mother_name }}</p></b>
                          </div>
                        </div>
                        <hr>
                        <div class="row pb-2">
                          <div class="col-md-12">
                            <p><b>Address</b></p>
                            <span>{{ $student->user->address }}</span>
                          </div>
                        </div>
                        <hr>
                        <div class="row pb-4">
                          <div class="col-md-6">
                            <p>Date of Birth</p>
                            <b><p>{{ $student->user->date_of_birth }}</p></b>
                          </div>
                          <div class="col-md-6">
                            <p>Place of Birth</p>
                            <b><p>{{ $student->user->place_of_birth }}</p></b>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="attendance">
                    <div class="row">
                      <div class="col-md-12">
                        <hr>
                        <div class="card card-chart">
                          <div class="card-header card-header-warning">
                            <div class="ct-chart" id="websiteViewsChart"><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar"
                                style="width: 100%; height: 100%;"><g class="ct-grids"><line y1="120" y2="120" x1="40" x2="182.984375" class="ct-grid ct-vertical"></line><line y1="96" y2="96" x1="40" x2="182.984375" class="ct-grid ct-vertical"></line><line y1="72" y2="72" x1="40" x2="182.984375" class="ct-grid ct-vertical"></line><line y1="48" y2="48" x1="40" x2="182.984375" class="ct-grid ct-vertical"></line><line y1="24" y2="24" x1="40" x2="182.984375" class="ct-grid ct-vertical"></line><line y1="0" y2="0" x1="40" x2="182.984375" class="ct-grid ct-vertical"></line></g><g><g class="ct-series ct-series-a"><line x1="45.957682291666664" x2="45.957682291666664" y1="120" y2="54.959999999999994" class="ct-bar" ct:value="542" opacity="1"></line><line x1="57.873046875" x2="57.873046875" y1="120" y2="66.84" class="ct-bar" ct:value="443" opacity="1"></line><line x1="69.78841145833334" x2="69.78841145833334" y1="120" y2="81.6" class="ct-bar" ct:value="320" opacity="1"></line><line x1="81.70377604166667" x2="81.70377604166667" y1="120" y2="26.400000000000006" class="ct-bar" ct:value="780" opacity="1"></line><line x1="93.61914062500001" x2="93.61914062500001" y1="120" y2="53.64" class="ct-bar" ct:value="553" opacity="1"></line><line x1="105.53450520833334" x2="105.53450520833334" y1="120" y2="65.64" class="ct-bar" ct:value="453" opacity="1"></line><line x1="117.44986979166667" x2="117.44986979166667" y1="120" y2="80.88" class="ct-bar" ct:value="326" opacity="1"></line><line x1="129.365234375" x2="129.365234375" y1="120" y2="67.92" class="ct-bar" ct:value="434" opacity="1"></line><line x1="141.28059895833334" x2="141.28059895833334" y1="120" y2="51.84" class="ct-bar" ct:value="568" opacity="1"></line><line x1="153.19596354166666" x2="153.19596354166666" y1="120" y2="46.8" class="ct-bar" ct:value="610" opacity="1"></line><line x1="165.111328125" x2="165.111328125" y1="120" y2="29.28" class="ct-bar" ct:value="756" opacity="1"></line><line x1="177.02669270833334" x2="177.02669270833334" y1="120" y2="12.599999999999994" class="ct-bar" ct:value="895" opacity="1"></line></g></g><g class="ct-labels"><foreignObject style="overflow: visible;" x="40" y="125" width="11.915364583333334" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">J</span></foreignObject>
                          <foreignObject
                            style="overflow: visible;" x="51.915364583333336" y="125" width="11.915364583333334" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">F</span></foreignObject>
                            <foreignObject
                              style="overflow: visible;" x="63.83072916666667" y="125" width="11.915364583333332" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">M</span></foreignObject>
                              <foreignObject
                                style="overflow: visible;" x="75.74609375" y="125" width="11.915364583333336" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">A</span></foreignObject>
                                <foreignObject
                                  style="overflow: visible;" x="87.66145833333334" y="125" width="11.915364583333336" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">M</span></foreignObject>
                                  <foreignObject
                                    style="overflow: visible;" x="99.57682291666667" y="125" width="11.915364583333329" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">J</span></foreignObject>
                                    <foreignObject
                                      style="overflow: visible;" x="111.4921875" y="125" width="11.915364583333343" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">J</span></foreignObject>
                                      <foreignObject
                                        style="overflow: visible;" x="123.40755208333334" y="125" width="11.915364583333329" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">A</span></foreignObject>
                                        <foreignObject
                                          style="overflow: visible;" x="135.32291666666669" y="125" width="11.915364583333329" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">S</span></foreignObject>
                                          <foreignObject
                                            style="overflow: visible;" x="147.23828125" y="125" width="11.915364583333343" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">O</span></foreignObject>
                                            <foreignObject
                                              style="overflow: visible;" x="159.15364583333334" y="125" width="11.915364583333343" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">N</span></foreignObject>
                                              <foreignObject
                                                style="overflow: visible;" x="171.06901041666669" y="125" width="30" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 30px; height: 20px;">D</span></foreignObject>
                                                <foreignObject
                                                  style="overflow: visible;" y="96" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">0</span></foreignObject>
                                                  <foreignObject
                                                    style="overflow: visible;" y="72" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/"
                                                      style="height: 24px; width: 30px;">200</span></foreignObject>
                                                    <foreignObject style="overflow: visible;"
                                                      y="48" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="height: 24px; width: 30px;">400</span></foreignObject>
                                                    <foreignObject style="overflow: visible;"
                                                      y="24" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="height: 24px; width: 30px;">600</span></foreignObject>
                                                    <foreignObject style="overflow: visible;"
                                                      y="0" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="height: 24px; width: 30px;">800</span></foreignObject>
                                                    <foreignObject style="overflow: visible;"
                                                      y="-30" x="0" height="30" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="height: 30px; width: 30px;">1000</span></foreignObject>
                                                    </g>
                                                    </svg>
                            </div>
                          </div>
                          <div class="card-body">
                            <p class="text-primary">Performance Chart as of 10/10/2019</p>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="tab-pane" id="performance">
                    <div class="row">
                      <div class="col-md-12">
                        <hr>
                        <div class="card card-chart">
                          <div class="card-header card-header-warning">
                            <div class="ct-chart" id="websiteViewsChart"><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar"
                                style="width: 100%; height: 100%;"><g class="ct-grids"><line y1="120" y2="120" x1="40" x2="182.984375" class="ct-grid ct-vertical"></line><line y1="96" y2="96" x1="40" x2="182.984375" class="ct-grid ct-vertical"></line><line y1="72" y2="72" x1="40" x2="182.984375" class="ct-grid ct-vertical"></line><line y1="48" y2="48" x1="40" x2="182.984375" class="ct-grid ct-vertical"></line><line y1="24" y2="24" x1="40" x2="182.984375" class="ct-grid ct-vertical"></line><line y1="0" y2="0" x1="40" x2="182.984375" class="ct-grid ct-vertical"></line></g><g><g class="ct-series ct-series-a"><line x1="45.957682291666664" x2="45.957682291666664" y1="120" y2="54.959999999999994" class="ct-bar" ct:value="542" opacity="1"></line><line x1="57.873046875" x2="57.873046875" y1="120" y2="66.84" class="ct-bar" ct:value="443" opacity="1"></line><line x1="69.78841145833334" x2="69.78841145833334" y1="120" y2="81.6" class="ct-bar" ct:value="320" opacity="1"></line><line x1="81.70377604166667" x2="81.70377604166667" y1="120" y2="26.400000000000006" class="ct-bar" ct:value="780" opacity="1"></line><line x1="93.61914062500001" x2="93.61914062500001" y1="120" y2="53.64" class="ct-bar" ct:value="553" opacity="1"></line><line x1="105.53450520833334" x2="105.53450520833334" y1="120" y2="65.64" class="ct-bar" ct:value="453" opacity="1"></line><line x1="117.44986979166667" x2="117.44986979166667" y1="120" y2="80.88" class="ct-bar" ct:value="326" opacity="1"></line><line x1="129.365234375" x2="129.365234375" y1="120" y2="67.92" class="ct-bar" ct:value="434" opacity="1"></line><line x1="141.28059895833334" x2="141.28059895833334" y1="120" y2="51.84" class="ct-bar" ct:value="568" opacity="1"></line><line x1="153.19596354166666" x2="153.19596354166666" y1="120" y2="46.8" class="ct-bar" ct:value="610" opacity="1"></line><line x1="165.111328125" x2="165.111328125" y1="120" y2="29.28" class="ct-bar" ct:value="756" opacity="1"></line><line x1="177.02669270833334" x2="177.02669270833334" y1="120" y2="12.599999999999994" class="ct-bar" ct:value="895" opacity="1"></line></g></g><g class="ct-labels"><foreignObject style="overflow: visible;" x="40" y="125" width="11.915364583333334" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">J</span></foreignObject>
                              <foreignObject
                                style="overflow: visible;" x="51.915364583333336" y="125" width="11.915364583333334" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">F</span></foreignObject>
                                <foreignObject
                                  style="overflow: visible;" x="63.83072916666667" y="125" width="11.915364583333332" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">M</span></foreignObject>
                                  <foreignObject
                                    style="overflow: visible;" x="75.74609375" y="125" width="11.915364583333336" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">A</span></foreignObject>
                                    <foreignObject
                                      style="overflow: visible;" x="87.66145833333334" y="125" width="11.915364583333336" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">M</span></foreignObject>
                                      <foreignObject
                                        style="overflow: visible;" x="99.57682291666667" y="125" width="11.915364583333329" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">J</span></foreignObject>
                                        <foreignObject
                                          style="overflow: visible;" x="111.4921875" y="125" width="11.915364583333343" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">J</span></foreignObject>
                                          <foreignObject
                                            style="overflow: visible;" x="123.40755208333334" y="125" width="11.915364583333329" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">A</span></foreignObject>
                                            <foreignObject
                                              style="overflow: visible;" x="135.32291666666669" y="125" width="11.915364583333329" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">S</span></foreignObject>
                                              <foreignObject
                                                style="overflow: visible;" x="147.23828125" y="125" width="11.915364583333343" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">O</span></foreignObject>
                                                <foreignObject
                                                  style="overflow: visible;" x="159.15364583333334" y="125" width="11.915364583333343" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 12px; height: 20px;">N</span></foreignObject>
                                                  <foreignObject
                                                    style="overflow: visible;" x="171.06901041666669" y="125" width="30" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 30px; height: 20px;">D</span></foreignObject>
                                                    <foreignObject
                                                      style="overflow: visible;" y="96" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">0</span></foreignObject>
                                                      <foreignObject
                                                        style="overflow: visible;" y="72" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/"
                                                          style="height: 24px; width: 30px;">200</span></foreignObject>
                                                        <foreignObject style="overflow: visible;"
                                                          y="48" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/"
                                                            style="height: 24px; width: 30px;">400</span></foreignObject>
                                                        <foreignObject style="overflow: visible;"
                                                          y="24" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/"
                                                            style="height: 24px; width: 30px;">600</span></foreignObject>
                                                        <foreignObject style="overflow: visible;"
                                                          y="0" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/"
                                                            style="height: 24px; width: 30px;">800</span></foreignObject>
                                                        <foreignObject style="overflow: visible;"
                                                          y="-30" x="0" height="30" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/"
                                                            style="height: 30px; width: 30px;">1000</span></foreignObject>
                                                        </g>
                                                        </svg>
                            </div>
                          </div>
                          <div class="card-body">
                            <p class="text-primary">Performance Chart as of 10/10/2019</p>
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
</div>
@endsection