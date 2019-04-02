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
            <li class="active nav-item">
                <a href="#pablo" class="nav-link">
                    <i class="material-icons">dashboard</i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('announcements') }}" class="nav-link">
                    <i class="material-icons">announcement</i> Announcement
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('faculty') }}" class="nav-link">
                    <i class="material-icons">account_circle</i> Faculty
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('sections') }}" class="nav-link">
                    <i class="material-icons">meeting_room</i> Sections
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('students') }}" class="nav-link">
                    <i class="material-icons">assignment_ind</i> Students
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="material-icons">exit_to_app</i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf</form>
            </li>
        </ul>
        </div>
    </div>
</nav>