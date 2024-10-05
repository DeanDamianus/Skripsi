<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMBAKO</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ url('/owner') }}" class="nav-link">Home</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-none d-sm-inline-block">
                    <div class="dropdown">
                        <button class="nav-link" type="button" data-toggle="dropdown" style="border: black;">
                            {{ $selectedYear }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            @foreach ($currentMusim as $season)
                                <div class="dropdown-divider"></div>
                                <a href="{{ url('/dashboardindividual?year=' . $season->tahun) }}"
                                    class="dropdown-item">
                                    <i class="fas fa-calendar"></i> {{ $season->tahun }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ url('/grade') }}" class="brand-link">
                <img src="dist/img/simbakologo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">SIMBAKO</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="dist/img/owner.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        @if (Auth::check())
                            <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                        @else
                            <a href="#" class="d-block">Guest</a>
                        @endif
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    <strong>DASHBOARD</strong>
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href='{{ url('/owner?tahun=' . $selectedYear) }}' class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Global</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a a href="#" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Individual</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item menu-close">
                            <a href="{{ url('/input?year=' . $selectedYear) }}" class="nav-link">
                                <i class="nav-icon fas fa-edit"></i>
                                <p><strong>INPUT NOTA</strong><i class="right fas fa-angle-left"></i></p>
                            </a>
                        </li>
                        <li class="nav-item menu-close">
                            <a href="{{ url('/hutang-admin?year=' . $selectedYear) }}" class="nav-link">
                                <i class="nav-icon fas fa-hand-holding-usd"></i>
                                <p><strong>HUTANG</strong><i class="right fas fa-angle-left"></i></p>
                            </a>
                        </li>
                        <li class="nav-item menu-closed">
                            <a href="{{ url('/distribusi?year=' . $selectedYear) }}" class="nav-link">
                                <i class="nav-icon fas fa-truck"></i>
                                <p><strong>DISTRIBUSI</strong><i class="right fas fa-angle-left"></i></p>
                            </a>
                        </li>
                        <li class="nav-item menu">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tractor"></i>
                                <p><strong>PETANI</strong><i class="fas fa-angle-left right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/datapetani?year=' . $selectedYear) }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Petani</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/register?year=' . $selectedYear) }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tambah Petani</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item menu-close">
                            <a href="{{ url('/parameter?tahun=' . $selectedYear) }}" class="nav-link">
                                <i class="nav-icon fas fa-cog"></i>
                                <p><strong>PARAMETER</strong><i class="right fas fa-angle-left"></i></p>
                            </a>
                        </li>
                        <li class="nav-item menu-close">
                            <a href="logout" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p><strong>LOGOUT</strong></p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <strong>
                                <h1>Pilih Petani</h1>
                            </strong>
                        </div>
                        <div class="col-sm-6 text-right">
                            <form action="{{ url('/datapetani/search') }}" method="GET">
                                <div class="input-group mb-3">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Cari Petani..." value="{{ request()->query('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <!-- Default box -->
                <div class="card card-solid">
                    <div class="card-body pb-0">
                        <div class="row">
                            @foreach ($data as $user)
                                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                    <a href="{{ url('/dashboardpetani?id=' . $user->id . '&tahun=' . $selectedYear) }}">
                                    <div class="card bg-light d-flex flex-fill">
                                        <div class="card-header text-muted border-bottom-0">
                                            {{ $user->id }}
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="lead"><strong>{{ $user->name }}</strong></h2>
                                                    <p class="text-muted text-sm"><b>Sejak: </b>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/y') }}</p>
                                                    <!-- Added about field -->
                                                </div>
                                                <div class="col-5 text-center">
                                                    <img src="{{ $user->image ? asset('uploads/' . $user->image) : asset('dist/img/blank.png') }}"
                                                        alt="user-avatar" class="img-circle img-fluid"
                                                        style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                                                </div>

                                            </div>
                                        </div>
                                        {{-- <div class="card-footer">
                                            <div class="text-right">
                                                <a href="{{ url('/dashboardpetani?id=' . $user->id . '&tahun=' . $selectedYear) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="nav-icon fas fa-tachometer-alt"></i> Dashboard
                                                </a>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </section>


        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a>SIMBAKO</a>.</strong> All rights reserved.
        </footer>

        <aside class="control-sidebar control-sidebar-dark">
            <!-- Add Content Here -->
        </aside>
    </div>

    <!-- REQUIRED SCRIPTS -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.js"></script>
    <script src="dist/js/pages/dashboard.js"></script>
</body>

</html>
