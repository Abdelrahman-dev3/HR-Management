<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Toastr CSS -->
  <link rel="icon" href="{{ asset('logo.jpg') }}" type="image/png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>
<body style="min-height: 100vh; background: linear-gradient(to right, #f8f9fa, #e3f2fd);">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="{{ asset('HR_System_Logo.png') }}" alt="Logo" width="30" height="30" class="me-2">
        HR System
      </a>
      <div class="ms-auto">
        <a href="{{ route('profile') }}" class="btn btn-outline-light btn-sm rounded-pill">My Profile</a>
      </div>
    </div>
  </nav>
  <div class="d-flex">
    <!-- Sidebar -->
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-white shadow" style="width: 250px; min-height: 100vh;">
      </a>
      <hr>
      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link text-white rounded-pill {{ request()->routeIs('dashboard') ? 'active text-white bg-primary' : 'text-white' }}" aria-current="page">
            Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('position.index') }}" class="nav-link text-white rounded-pill {{ request()->routeIs('position.index') ? 'active text-white bg-primary' : 'text-white' }}" aria-current="page">
            Positions
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('department.index') }}" class="nav-link text-white rounded-pill {{ request()->routeIs('department.index') ? 'active text-white bg-primary' : 'text-white' }}" aria-current="page">
            Departments
          </a>
        </li>
        <li>
          <a href="{{ route('employee') }}" class="nav-link text-white rounded-pill {{ request()->routeIs('employee') ? 'active text-white bg-primary' : 'text-white' }}">
            Employees
          </a>
        </li>
        <li>
          <a href="{{ route('leaves') }}" class="nav-link text-white rounded-pill {{ request()->routeIs('leaves') ? 'active text-white bg-primary' : 'text-white' }}">
            Leaves
          </a>
        </li>
        <li>
          <a href="{{ route('leaves.balances') }}" class="nav-link text-white rounded-pill {{ request()->routeIs('leaves.balances*') ? 'active text-white bg-primary' : 'text-white' }}">
            Leave Balances
          </a>
        </li>
        <li>
          <a href="{{ route('attendance') }}" class="nav-link text-white rounded-pill {{ request()->routeIs('attendance*') ? 'active text-white bg-primary' : 'text-white' }}">
            Attendance
          </a>
        </li>
        <li>
          <a href="{{ route('criteria') }}" class="nav-link text-white rounded-pill {{ request()->routeIs('criteria*') ? 'active text-white bg-primary' : 'text-white' }}">
            Performance Criteria
          </a>
        </li>
        <li>
          <a href="{{ route('performance') }}" class="nav-link text-white rounded-pill {{ request()->routeIs('performance*') ? 'active text-white bg-primary' : 'text-white' }}">
            Performance
          </a>
        </li>
        <li>
          <a href="#" class="nav-link text-white rounded-pill">
            Settings
          </a>
        </li>
      </ul>
      <hr>
      <div>
        <a href="#" class="btn btn-outline-light btn-sm w-100 rounded-pill">Logout</a>
      </div>
    </div>

    <!-- Main content area -->
    <div class="flex-grow-1 p-4">
        @yield('content')
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery (أساسي لتشغيل Toastr) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@yield('script')

</body>
</html>
