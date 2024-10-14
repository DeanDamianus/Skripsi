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
<style>
    .periode-header {
        background-color: #0000004d; /* Darker color */
        color: #000000; /* White text for better contrast */
    }

</style>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../../index3.html" class="nav-link">Home</a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-none d-sm-inline-block">
                    <div class="dropdown">
                        <button class="nav-link" type="button" data-toggle="dropdown" style="border: black;">
                            {{ $selectedYear }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            @foreach ($musim as $season)
                            <div class="dropdown-divider"></div>
                            <a href="{{ url('/distribusi?year=' . $season->tahun) }}" class="dropdown-item">
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
                        <li class="nav-item menu-closed">
                            <a href="#" class="nav-link">
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
                                    <a a href='{{ url('/dashboardindividual?year=' . $selectedYear) }}'class="nav-link">
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
                        <li class="nav-item menu-open">
                            <a href="{{ url('/distribusi?year=' . $selectedYear) }}" class="nav-link active">
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
                                <h1 class="m-0">Distribusi {{ $selectedYear }}</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                {{-- <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Diterima</span>
                                <span class="info-box-number">{{ $diterima }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-yellow"><i class="fas fa-truck""></i></span>
          
                        <div class=" info-box-content">
                                    <span class="info-box-text">Diproses</span>
                                    <span class="info-box-number">{{ $diproses }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-times"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Ditolak</span>
                            <span class="info-box-number">{{ $ditolak }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-hourglass-half"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Belum Dikirim</span>
                            <span class="info-box-number">0</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div> --}}
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $diterima }}</h3>
                            <p>Diterima</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i> <!-- Ikon timbangan menggantung -->
                        </div>
                    </div>

                </div>
                <!--NETO-->
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $diproses }}</sup></h3>
                            <p>Diproses</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck"></i> </i> <!-- Ikon koin -->
                        </div>
                    </div>
                </div>
                <!-- Jumlah Kotor-->
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $ditolak }}</sup></h3>
                            <p>Ditolak</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times"></i> <!-- Ikon pertukaran -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $belumproses }}</sup></h3>
                            <p>Belum Diproses</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-hourglass-half"></i> <!-- Ikon pertukaran -->
                        </div>
                    </div>
                </div>
                <!-- Jumlah Jual Lua -->
            </div>
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>ID Keranjang</th>
                                    <th>ID Lama</th>
                                    <th>
                                        Periode
                                        <a href="{{ url()->current() }}?sort=rekap_2024.periode&direction={{ request('direction') == 'asc' ? 'desc' : 'asc' }}&year={{ $selectedYear }}">
                                            <i class="fas fa-sort"></i>
                                        </a>
                                    </th>
                                    <th>
                                        Status 
                                        <a href="{{ url()->current() }}?sort=distribusi_2024.status&direction={{ request('direction') == 'asc' ? 'desc' : 'asc' }}&year={{ $selectedYear }}">
                                            <i class="fas fa-sort"></i>
                                        </a>
                                    </th>
                                    <th>Diterima</th>
                                    <th>Diproses</th>
                                    <th>Ditolak</th>
                                    <th>Pengeluaran</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->groupBy('periode') as $periode => $records)
                                    <tr class="periode-header" data-target="periode-{{ $loop->index }}" style="cursor: pointer;">
                                        <td colspan="7">
                                            <strong>{{ $periode }}</strong>
                                        </td>
                                        <td></td>
                                        <td>
                                            <a href="{{ url('/distribusibulk?periode=' . urlencode($periode)) }}" class="btn btn-info btn-block">
                                                <i class="nav-icon fas fa-edit"></i> 
                                            </a>
                                        </td>

                                    </tr>
                                    <tbody id="periode-{{ $loop->index }}" class="periode-body">
                                        @foreach ($records as $rekap)
                                            <tr>
                                                <td>
                                                    <a href="{{ url('/dataInput?id=' . $rekap->id_petani . '&id_musim=' . $rekap->id_musim) }}">
                                                        {{ $rekap->id_rekap }}
                                                    </a>
                                                </td>
                                                <td>{{ $rekap->rekap_lama }}</td>
                                                <td>{!! $rekap->periode !!}</td>
                                                <td>{!! $rekap->status !!}</td>
                                                <td>{{ $rekap->tgl_diterima ? \Carbon\Carbon::parse($rekap->tgl_diterima)->format('d-m-Y') : '' }}</td>
                                                <td>{{ $rekap->tgl_diproses ? \Carbon\Carbon::parse($rekap->tgl_diproses)->format('d-m-Y') : '' }}</td>
                                                <td>{{ $rekap->tgl_ditolak ? \Carbon\Carbon::parse($rekap->tgl_ditolak)->format('d-m-Y') : '' }}</td>
                                                <td>{{ 'Rp. ' . number_format($rekap->pengeluaran, 0, ',', '.') }}</td>
                                                <td>
                                                    <a href="{{ $rekap->tgl_ditolak ? url('/distribusitolak?id=' . $rekap->id_rekap . '&id_musim=' . $rekap->id_musim. '&id_petani=' . $rekap->id) : url('/formdistribusi?id=' . $rekap->id_rekap . '&id_musim=' . $rekap->id_musim. '&id_petani=' . $rekap->id) }}"
                                                        class="btn btn-block {{ $rekap->tgl_ditolak ? 'btn-danger' : 'btn-success' }}">
                                                        @if ($rekap->tgl_ditolak)
                                                            <i class="nav-icon fas fa-undo"></i> 
                                                        @else
                                                            <i class="nav-icon fas fa-edit"></i> 
                                                        @endif
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="6"></th>
                                    <th>{{ 'Rp. ' . number_format($totalpengeluaran, 0, ',', '.') }}</th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>         
                <!-- /.card-footer -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.row -->
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
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script>
        document.querySelectorAll('.periode-header').forEach(header => {
            header.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const tbody = document.getElementById(targetId);
                if (tbody) {
                    tbody.classList.toggle('d-none'); // Toggle the 'd-none' class to hide/show
                }
            });
        });
    
        // Ensure all bodies are expanded by default by removing 'd-none' class
        document.querySelectorAll('.periode-body').forEach(body => {
            body.classList.remove('d-none');
        });
    
        // Handle checkbox functionality
        document.querySelectorAll('.periode-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const targetClass = this.getAttribute('data-target');
                const childCheckboxes = document.querySelectorAll('.child-checkbox.' + targetClass);
                childCheckboxes.forEach(childCheckbox => {
                    childCheckbox.checked = this.checked;
                });
            });
        });
    </script>
    
</body>

</html>

</body>

</html>