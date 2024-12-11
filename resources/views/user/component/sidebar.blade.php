<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">



</head>
<style>
.logo-text {
    font-family: 'Calibri';
    text-align: center;
}

.logo-main {
    font-size: 18px;
    color: #0c84ff;
    font-weight: bold;
    position: relative;
    display: inline-block;
    letter-spacing: 5px;
    line-height: 2px;
}

</style>
<body>


    <aside class="main-sidebar sidebar-dark-primary elevation-4">




        <div class="sidebar">

          <div class="user-panel mt-3 pb-3 mb-3 d-flex">

            <div class="info">
                <span class="logo-text">
                    <span class="logo-main">KeenRabbits</span><br>

                </span>
            </div>
          </div>


          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

              <li class="nav-item menu-open">
                  <a href="{{ route('user.dashboard', ['id' => Auth::user()->id]) }}" class="nav-link @if(request()->routeIs('user.dashboard')) active @endif">
                      <i class="nav-icon fas fa-tachometer-alt"></i>
                      <p>Dashboard</p>
                  </a>
              </li>

            <li class="nav-item">

                    {{-- <a href="{{ route('category') }}" class="nav-link @if(request()->routeIs('category') || request()->routeIs('summary.view')) active @endif"> --}}
{{--                <a href="{{ route('admin.category') }}" class="nav-link @if(request()->routeIs('admin.category'))active @endif">--}}
{{--                    <i class="nav-icon fas fa-list"></i>--}}
{{--                    <p>Category</p>--}}
{{--                </a>--}}
            </li>


             <li class="nav-item">

                <a href="{{ route('user.post') }}" class="nav-link @if(request()->routeIs('user.post'))active @endif">
                    <i class="nav-icon fas fa-book"></i>
                    <p>Post</p>
                </a>

            </li>

            <li class="nav-item">

                <a href="{{ route('user.detailes') }}" class="nav-link @if(request()->routeIs('user.detailes'))active @endif">
                    <i class="nav-icon fas fa-th"></i>
                    <p>Post Details</p>
                </a>

            </li>









            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link @if(request()->routeIs('logout'))active @endif "
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                 {{ __('Logout') }}
             </a>

             <form id="logout-form" action="{{ route('logout') }}" method="GET" class="d-none">
                 @csrf
             </form>
            </li>
            </nav>
            </div>
      </aside>
</body>
</html>
