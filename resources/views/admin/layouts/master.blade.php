<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{route('admin#dashboard')}}" class="brand-link m-2 text-center @if (url()->current() == route('admin#dashboard')) bg-primary rounded @endif">
                <span class="brand-text font-weight-light"> Welcome Admin </span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item mb-2 @if (url()->current() == route('admin#profile')) bg-primary rounded @endif">
                            <a href="{{ route('admin#profile') }}" class="nav-link">
                                <i class="fas fa-user-circle"></i>
                                <p>
                                    My Profile
                                </p>
                            </a>
                        </li>

                        <li class="nav-item mb-2 @if (url()->current() == route('admin#jobList')) bg-primary rounded @endif">
                            <a href="{{ route('admin#jobList') }}" class="nav-link">
                                <i class="fas fa-list"></i>
                                <p>
                                    Active Jobs
                                </p>
                            </a>
                        </li>

                        <li class="nav-item mb-2 @if (url()->current() == route('admin#oldJobList')) bg-primary rounded @endif">
                            <a href="{{ route('admin#oldJobList') }}" class="nav-link">
                                <i class="fas fa-list"></i>
                                <p>
                                    Older Jobs
                                </p>
                            </a>
                        </li>

                        <li class="nav-item mb-2 @if (url()->current() == route('admin#userList')) bg-primary rounded @endif">
                            <a href="{{ route('admin#userList') }}" class="nav-link">
                                <i class="fas fa-list"></i>
                                <p>
                                    List of Users
                                </p>
                            </a>
                        </li>

                        <li class="nav-item mb-2 @if (url()->current() == route('admin#employmentType')) bg-primary rounded @endif">
                            <a href="{{ route('admin#employmentType') }}" class="nav-link">
                                <i class="fas fa-list"></i>
                                <p>
                                    Types of Employment
                                </p>
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @if (session('message'))
                        <div class="d-flex justify-content-center">
                            <div class="alert alert-danger alert-dismissible fade show col-lg-8" role="alert">
                                {{ session('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    @endif
                    <div class="row pt-2">
                        @yield('content')
                    </div>
                </div>
            </section>
        </div>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('dist/js/demo.js') }}"></script>
</body>
@yield('script')

</html>
