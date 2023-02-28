<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link @if (!request()->is('admin/panel')) collapsed @endif"
                href="{{ route('admin.admin_panel') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @if (!request()->is('admin/role')) collapsed @endif" href="{{ route('role.index') }}">
                <i class='bi bi-person-check-fill'></i>
                <span>Roles</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @if (request()->is('admin/permission')) '' @else collapsed @endif"
                href="{{ route('permission.index') }}">
                <i class='bi bi-shield-shaded'></i>
                <span>Permissions</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="javascript:void(0);" class="nav-link @if (strpos(request()->url(), 'profile') == false) collapsed @endif"
                data-bs-target="#personal-nav" data-bs-toggle="collapse">
                <i class="bi bi-journal-text"></i><span>Personal</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="personal-nav" class="nav-content @if (strpos(request()->url(), 'profile') == false) collapse @endif"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('admin.profile') }}" @if (request()->is('admin/profile')) class="active" @endif>
                        <i class="bi bi-circle"></i><span>Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.edit_profile') }}" @if (request()->is('admin/profile/edit_profile')) class="active" @endif>
                        <i class="bi bi-circle"></i><span>Update Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.change_password') }}"
                        @if (request()->is('admin/profile/change_password')) class="active" @endif>
                        <i class="bi bi-circle"></i><span>Change Password</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a href="javascript:void(0);" class="nav-link @if (strpos(request()->url(), 'user') == false) collapsed @endif"
                data-bs-target="#user-nav" data-bs-toggle="collapse">
                <i class="bi bi-people-fill"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="user-nav" class="nav-content @if (strpos(request()->url(), 'user') == false) collapse @endif"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('user.index') }}" @if (request()->is('admin/user')) class="active" @endif>
                        <i class="bi bi-circle"></i><span>User List</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user_list.trash') }}" @if (request()->is('admin/user/trash')) class="active" @endif>
                        <i class="bi bi-circle"></i><span>Recycle Bin</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link @if (strpos(request()->url(), 'admin/todolist_type') == false) collapsed @endif"
                href="{{ route('todolist_type.index') }}">
                <i class='bi bi-clipboard-check'></i>
                <span>Todolist Types</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @if (strpos(request()->url(), 'admin/library_type') == false) collapsed @endif"
                href="{{ route('library_type.index') }}">
                <i class='bi bi-folder-symlink-fill'></i>
                <span>Library Types</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed logout-btn" href="javascript:void(0);">
                <i class="bi bi-box-arrow-left"></i>
                <span>Logout</span>
            </a>
        </li>

    </ul>

</aside>
