<html>
    <head>
        <style>
          body {
            background-color: white;
          }
        </style>
    </head>
    <body>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-10" style="margin: auto; text-align: center">
            <div class="row">
              <div class="col-md-12">
                <h2>Student Grades</h2>
                <h3>{{ $class->course }} {{ $class->year }}-{{ $class->section }} {{ $class->subject->name }}</h3>
                <span>{{ $class->faculty->user->fullname() }} - </span>
                <span>{{ now()->format('m/d/Y') }}</span>
                
              </div>
              <br>
              <div class="col-md-12" style="width: 90%; margin: auto">
                <table class="table table-hover" style="width: 100%; text-align: center">
                  <thead class="text-primary">
                    <tr>
                      <th width="25%">#</th>
                      <th width="25%">Student</th>
                      <th width="25%">Final Grade</th>
                      <th width="25%">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($class->students as $key => $student)
                      <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $student->user->fullname() }}</td>
                        <td>{{ round($student->grade($class->subject->id), 2) }}%</td>
                        <td>{{ $student->grade($class->subject->id) < 75 ? 'Failed' : 'Passed'}}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </body>
</html>