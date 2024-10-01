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
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="" class="nav-link">Home</a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <li class="nav-item d-none d-sm-inline-block">
                    <div class="dropdown">
                        <button class="nav-link" type="button" data-toggle="dropdown" style="border: black;">
                            {{ $selectedYear }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            @foreach ($musim as $season)
                                <div class="dropdown-divider"></div>
                                <a href="{{ url('/owner?tahun=' . $season->tahun) }}" class="dropdown-item">
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
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="dist/img/simbakologo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">SIMBAKO</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
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


                <!-- Sidebar Menu -->
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
                                    <a href='{{ url('/owner?tahun=' . $selectedYear) }}' class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Global</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Individual</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item menu-close">
                            <a href="{{ url('/input?year=' . $selectedYear) }}" class="nav-link">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    <strong>INPUT NOTA</strong>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item menu-close">
                            <a href="{{ url('/hutang-admin?year=' . $selectedYear) }}" class="nav-link">
                                <i class="nav-icon fas fa-hand-holding-usd"></i>
                                <p>
                                    <strong>HUTANG</strong>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item menu-close">
                            <a href="{{ url('/distribusi?year=' . $selectedYear) }}" class="nav-link">
                                <i class="nav-icon fas fa-truck"></i>
                                <p>
                                    <strong>DISTRIBUSI</strong>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tractor"></i>
                                <p>
                                    <strong>PETANI</strong>
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/datapetani?year=' . $selectedYear) }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Petani</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a a href="{{ url('/register?year=' . $selectedYear) }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tambah Petani</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item menu-close">
                            <a href="{{ url('/parameter?tahun=' . $selectedYear) }}" class="nav-link">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    <strong>PARAMETER</strong>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item menu-close">
                            <a href="logout" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    <strong>LOGOUT</strong>
                                </p>
                            </a>
                        </li>

            </div>

            <!-- /.sidebar -->
        </aside>


        <div class="content-wrapper">

            <div class="content">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Rekap Pengumpulan {{ $selectedYear }}</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalNetto }} Kg</sup></h3>
                                <p>Total Netto Keranjang</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-weight-hanging"></i>
                            </div>
                            <a href="{{ url('/input?year=' . $selectedYear) }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>

                    </div>
                    <!--NETO-->
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><sup
                                        style="font-size: 20px">Rp.</sup>{{ number_format($totalHarga, 0, ',', '.') }}
                                </h3>
                                <p>Total Harga Keranjang</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-coins"></i> <!-- Ikon koin -->
                            </div>
                            <a href="{{ url('/input?year=' . $selectedYear) }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Jumlah Kotor-->
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>{{ $jualLuar }}<sup style="font-size: 20px"> Keranjang</sup></h3>
                                <p>Total Jual Luar</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-exchange-alt"></i> <!-- Ikon pertukaran -->
                            </div>
                            <a href="{{ url('/input') }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Jumlah Bersih -->
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $jumlahPetani }}</h3>
                                <p>Jumlah Petani</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user"></i> <!-- Ikon orang -->
                            </div>
                            <a href="{{ url('/datapetani?year=' . $selectedYear) }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Jumlah Petani -->
                    <!-- Jumlah Jual Lua -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="card card-info">
                                <div class="card-header">
                                  <h3 class="card-title">Distribusi Nota A</h3>
                                  <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                      <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                      <i class="fas fa-times"></i>
                                    </button>
                                  </div>
                                </div>
                                <div class="card-body">
                                  <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!--nota A -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Nota B -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Distribusi Nota B</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="donutChart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.2.0
        </div>
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">SIMBAKO</strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Add Content Here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="dist/js/adminlte.js"></script>
    <!-- FLOT CHARTS -->
    <script src="plugins/flot/jquery.flot.js"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="plugins/flot/plugins/jquery.flot.resize.js"></script>
    <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
    <script src="plugins/flot/plugins/jquery.flot.pie.js"></script>
    <!-- OPTIONAL SCRIPTS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/pages/dashboard3.js"></script>
    <script src="dist/js/pages/dashboard2.js"></script>

    <script>
        $(document).ready(function() {
            // Create the first donut chart
            var ctxDonutA = $('#donutChart').get(0).getContext('2d');
            
            // Use Blade to pass the PHP variable to JavaScript
            var diterima = {{ $diterima }};
            var diproses = {{ $diproses }};
            var ditolak = {{ $ditolak }};
            var belumproses = {{ $belumproses }};
    
            // Prepare the data for the chart
            var donutDataA = {
                labels: ['Diterima', 'Diproses', 'Ditolak', 'Belum Diproses'],
                datasets: [{
                    data: [diterima, diproses, ditolak, belumproses],
                    backgroundColor: ['#00a65a', '#f39c12', '#f56954', '#00c0ef'],
                }]
            };
    
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            };
    
            // Create the first doughnut chart
            new Chart(ctxDonutA, {
                type: 'doughnut',
                data: donutDataA,
                options: donutOptions
            });
    
            // Create the second donut chart
            var ctxDonutB = $('#donutChart2').get(0).getContext('2d');
            
            // Use Blade to pass the PHP variable to JavaScript
            var diterimaB = {{ $diterima_B }};
            var diprosesB = {{ $diproses_B }};
            var ditolakB = {{ $ditolak_B }};
            var belumprosesB = {{ $belumproses_B }};
    
            // Prepare the data for the second chart
            var donutDataB = {
                labels: ['Diterima', 'Diproses', 'Ditolak', 'Belum Diproses'],
                datasets: [{
                    data: [diterimaB, diprosesB, ditolakB, belumprosesB],
                    backgroundColor: ['#00a65a', '#f39c12', '#f56954', '#00c0ef'],
                }]
            };
    
            // Create the second doughnut chart
            new Chart(ctxDonutB, {
                type: 'doughnut',
                data: donutDataB,
                options: donutOptions
            });
        });
    </script>
    

</body>

</html>

</body>

</html>
