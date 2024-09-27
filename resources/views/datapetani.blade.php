<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMBAKO</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ url('/owner') }}" class="nav-link">Home</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ url('/grade') }}" class="brand-link">
                <img src="dist/img/simbakologo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
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
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item menu-close">
                            <a href="{{ url('/owner?tahun=' . $selectedYear) }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p><strong>DASHBOARD</strong><i class="right fas fa-angle-left"></i></p>
                            </a>
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
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-tractor"></i>
                                <p><strong>PETANI</strong><i class="fas fa-angle-left right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/datapetani?year=' . $selectedYear) }}" class="nav-link active">
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
                            <strong><h1>Data Petani</h1></strong>
                        </div>
                        <div class="col-sm-6 text-right">
                            <form action="{{ url('/datapetani/search') }}" method="GET">
                                <div class="input-group mb-3">
                                    <input type="text" name="search" class="form-control" placeholder="Cari Petani..." value="{{ request()->query('search') }}">
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

            <div class="content">
                <div class="container-fluid">
                    <div class="row card-container">
                        @foreach($data as $users)
                        <div class="col-md-3">
                            <div class="card fixed-card">
                                <div style="position: relative; display: inline-block;">
                                    <a href="{{ url('/uploadfoto?id=' . $users->id) }}" style="text-decoration: none;">
                                        <img class="card-img-top" src="dist/img/speed.jpg" alt="Card image cap" 
                                            style="transition: transform 0.3s; width: 100%; height: auto;"
                                            onmouseenter="this.style.transform='scale(1.05)'; this.nextElementSibling.style.display='block';"
                                            onmouseleave="this.style.transform='scale(1)'; this.nextElementSibling.style.display='none';">
                                    <span style="
                                        position: absolute;
                                        top: 50%;
                                        left: 50%;
                                        transform: translate(-50%, -50%);
                                        color: #000; /* Change color as needed */
                                        display: none;
                                        font-size: 20px; /* Adjust size as needed */
                                    ">
                                        <i class="fas fa-edit"></i> <!-- Font Awesome edit icon -->
                                    </span>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">ID Petani: <strong>{{ $users->id }}</strong></h5>
                                    <p class="card-text">
                                        Nama Petani: <strong>{{ $users->name }}</strong><br>
                                        Dibuat Tanggal: <strong>{{ $users->formatted_created_at }}</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
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
    <script src="dist/js/demo.js"></script>
</body>

</html>
