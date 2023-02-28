<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link @if (!request()->is('myself')) collapsed @endif" href="{{ route('user.home') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link @if (strpos(request()->url(), 'todolist') == false) collapsed @endif" href="{{ route('todolist.index') }}">
                <i class="bi bi-check2-circle"></i>
                <span>To-do Lists</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @if (strpos(request()->url(), 'note') == false) collapsed @endif" href="{{ route('note.index') }}">
                <i class="bi bi-sticky"></i>
                <span>Notes</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @if (strpos(request()->url(), 'journal') == false) collapsed @endif" href="{{ route('journal.index') }}">
                <i class="bi bi-journal-bookmark-fill"></i>
                <span>Journals</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @if (strpos(request()->url(), 'event') == false) collapsed @endif" href="{{ route('event.index') }}">
                <i class="bi bi-calendar2-week"></i>
                <span>Calendar Events</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @if (strpos(request()->url(), 'library') == false) collapsed @endif" href="{{ route('library.index') }}">
                <i class="bi bi-bookmark"></i>
                <span>Library</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @if (strpos(request()->url(), 'project') == false) collapsed @endif" href="{{ route('project.index') }}">
                <i class="bi bi-folder"></i>
                <span>Project</span>
            </a>
        </li>

        <li class="nav-heading">Setting</li>

        <li class="nav-item">
            <a class="nav-link @if (!request()->is('profile')) collapsed @endif" href="{{ route('user.profile') }}">
                <i class="bi bi-person-circle"></i>
                <span>Profile</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @if (!request()->is('contact')) collapsed @endif" href="{{ route('user.contact') }}">
                <i class="bi bi-envelope"></i>
                <span>Contact</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="javascript:void(0);" class="nav-link @if (strpos(request()->url(), 'setting') == false) collapsed @endif"
                data-bs-target="#personal-nav" data-bs-toggle="collapse">
                <i class='bi bi-gear'></i></i><span>Setting</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="personal-nav" class="nav-content @if (strpos(request()->url(), 'setting') == false) collapse @endif"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('user.change_password') }}"
                        @if (request()->is('setting/change_password')) class="active" @endif>
                        <i class="bi bi-circle"></i><span>Change Password</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed logout-btn" href="javascript:void(0);">
                <i class="bi bi-box-arrow-left"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>

</aside>
