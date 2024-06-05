<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/" class="brand-link">
    <!-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
    <span class="brand-text font-weight-light">INDEPEDENT CONTACTOR COMMUNITIES</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="mt-1 pb-1 mb-1 d-flex"></div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>
    <div class="mt-1 pb-1 mb-1 d-flex"></div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


        <li class="nav-item menu-open">
          <a href="home" class="nav-link active">
            <i class="fas fa-home nav-icon"></i>
            <p>
              Home
            </p>
          </a>
        </li>



        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-user nav-icon"></i>
            <p>
              Freelancer
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="addstudent" class="nav-link">
                <i class="fas fa-folder-plus nav-icon"></i>
                <p>Add Freelancer</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="managestudent" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i>
                <p>Manage freelancers</p>
              </a>
            </li>
          </ul>
        </li>




        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-upload nav-icon"></i>
            <p>
              Upload
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/uploadService" class="nav-link">
                <i class="fas fa-folder-plus nav-icon"></i>
                <p>Upload Service</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/manageService" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i>
                <p>Manage Service</p>
              </a>
            </li>
          </ul>
        </li>


        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-award nav-icon"></i>
            <p>
              Result
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="addresult" class="nav-link">
                <i class="fas fa-folder-plus nav-icon"></i>
                <p>Add Result</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="manageresult" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i>
                <p>Manage Result</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-user-check nav-icon"></i>
            <p>
              Attendence
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="addattendance" class="nav-link">
                <i class="fas fa-calendar-check nav-icon"></i>
                <p>Add Attendence</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="manageattendance" class="nav-link">
                <i class="fas fa-tasks nav-icon"></i>
                <p>Manage Attendence</p>
              </a>
            </li>
          </ul>
        </li>

        @can('isAdmin')
      <li class="nav-header">Admin Actions</li>
      <li class="nav-item">
        <a href="#" class="nav-link">
        <i class="fas fa-bell nav-icon"></i>
        <p>
          Notice
          <i class="fas fa-angle-left right"></i>
        </p>
        </a>
        <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="addnotice" class="nav-link">
          <i class="fas fa-plus-circle nav-icon"></i>
          <p>Add Notice</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="managenotice" class="nav-link">
          <i class="fas fa-tasks nav-icon"></i>
          <p>Manage Notice</p>
          </a>
        </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">
        <i class="nav-icon far fa-plus-square"></i>
        <p>
          Admin Control
          <i class="fas fa-angle-left right"></i>
        </p>
        </a>
        <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('register') }}" class="nav-link">
          <i class="fas fa-user-plus nav-icon"></i>
          <p>Register User</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
          <i class="fas fa-user-friends nav-icon"></i>
          <p>
            User Lists
            <i class="fas fa-angle-left right"></i>
          </p>
          </a>
          <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="lecturers" class="nav-link">
            <i class="fas fa-user-tie nav-icon"></i>
            <p>User</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="admins" class="nav-link">
            <i class="fas fa-user-cog nav-icon"></i>
            <p>Admin</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="freelancer" class="nav-link">
            <i class="fas fa-user-check nav-icon"></i>
            <p>Freelancer</p>
            </a>
          </li>
          </ul>
        </li>
        </ul>
      </li>
    @endcan

        <li class="nav-item">
          <a href="/manageprofile" class="nav-link">
            <i class="fas fa-user-secret nav-icon"></i>
            <p>
              Profile
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>

        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>