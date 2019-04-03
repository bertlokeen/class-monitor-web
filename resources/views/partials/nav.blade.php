<nav class="navbar navbar-expand-lg bg-primary" style="border-radius: 0;">
    <div class="container">
        <div class="navbar-translate">
            <a class="navbar-brand" href="#0">CLASS MONITOR</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
        </button>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="/dashboard" class="nav-link">
                        <i class="material-icons">dashboard</i> Dashboard
                    </a>
                </li>
                <li class="nav-item {{ Request::is('announcements') ? 'active' : '' }}">
                    <a href="{{ route('announcements') }}" class="nav-link">
                        <i class="material-icons">announcement</i> Announcements
                    </a>
                </li>
                <li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons">apps</i> Menu
                        <div class="ripple-container"></div>
                    </a>
                    <div class="dropdown-menu dropdown-with-icons">
                        <a href="{{ route('admin.index') }}" class="dropdown-item">
                            <i class="material-icons">verified_user</i> Admins
                        </a>
                        <div class="ripple-container"></div>
                        <a href="{{ route('faculty.index') }}" class="dropdown-item">
                            <i class="material-icons">account_circle</i> Faculty
                        </a>
                        <div class="ripple-container"></div>
                        <a href="{{ route('students.index') }}" class="dropdown-item">
                            <i class="material-icons">assignment_ind</i> Students
                        </a>
                        <div class="ripple-container"></div>
                        <a href="" class="dropdown-item">
                            <i class="material-icons">meeting_room</i> Classes
                        </a>
                        <div class="ripple-container"></div>
                        <a href="{{ route('subjects.index') }}" class="dropdown-item">
                            <i class="material-icons">library_books</i> Subjects
                        </a>
                        <div class="ripple-container"></div>
                    </div>
                </li>

                <li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false">
                          <i class="material-icons">account_circle</i> {{ request()->user()->name }}
                        <div class="ripple-container"></div></a>
                    <div class="dropdown-menu dropdown-with-icons">
                        <a href="./index.html" class="dropdown-item">
                            <i class="material-icons">settings</i> Profile
                        </a>
                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="material-icons">exit_to_app</i> Logout
                            <div class="ripple-container"></div>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf</form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>