<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('userDashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-user-clock"></i>
        </div>
        <div class="sidebar-brand-text mx-3">User Panel</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->

    <li class="nav-item">
        <a class="nav-link" href="{{ route('attendances.create') }}">
            <i class="fa fa-plus"></i>
            <span>Create Attendance</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{  route('attendances.index')}}">
            <i class="fa fa-hourglass-half"></i>
            <span>Unverified Attendance</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{  route('unpaid')}}">
            <i class="fa fa-piggy-bank"></i>
            <span><Unpaid></Unpaid> Unpaid</span></a>
    </li>





    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
