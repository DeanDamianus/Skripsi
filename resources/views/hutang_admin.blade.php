<?php
$con = mysqli_connect('localhost', 'root', '', 'simbako_app');

// Check connection
if (!$con) {
    die('Koneksi Error: ' . mysqli_connect_error());
}

// Query to get all users with role 'petani'
$allPetaniQuery = "SELECT id, name FROM users WHERE role = 'petani'";
$allPetaniResult = mysqli_query($con, $allPetaniQuery);

if (!$allPetaniResult) {
    die('Query Error: ' . mysqli_error($con));
}

$allPetani = [];
while ($userRow = mysqli_fetch_assoc($allPetaniResult)) {
    $allPetani[] = $userRow;
}

// Query to get users with entries in hutang_2024
$petaniInHutangQuery = "SELECT DISTINCT users.id, users.name 
                        FROM hutang_2024 
                        JOIN users ON hutang_2024.id_petani = users.id 
                        WHERE users.role = 'petani'";
$petaniInHutangResult = mysqli_query($con, $petaniInHutangQuery);

if (!$petaniInHutangResult) {
    die('Query Error: ' . mysqli_error($con));
}

$petaniInHutang = [];
while ($userRow = mysqli_fetch_assoc($petaniInHutangResult)) {
    $petaniInHutang[] = $userRow;
}

// Query to get hutang_2024 data
$query = "SELECT hutang_2024.id_petani, hutang_2024.tanggal_hutang, hutang_2024.bon, hutang_2024.cicilan, hutang_2024.tanggal_lunas, users.name 
          FROM hutang_2024
          JOIN users ON hutang_2024.id_petani = users.id
          WHERE users.role = 'petani'";

$result = mysqli_query($con, $query);

if (!$result) {
    die('Query Error: ' . mysqli_error($con));
}
?>



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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

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
                    <a href="{{ url('/owner') }}" class="nav-link">Home</a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-none d-sm-inline-block">
                    <div class="dropdown">
                        <button class="nav-link" type="button" data-toggle="dropdown" style=" border: black;">
                            2024
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <div class="dropdown-divider"></div>
                            <a href="{{ url('/owner2025') }}" class="dropdown-item">
                                <i class="fas fa-calendar"></i> 2025
                            </a>
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
            <a href="{{ url('/grade') }}" class="brand-link">
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
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item menu-close">
                            <a href="{{ url('/owner') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    <strong>DASHBOARD</strong>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item menu-close">
                            <a href="{{ url('/input') }}" class="nav-link">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    <strong>INPUT NOTA</strong>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item menu-close">
                            <a href="{{ url('/hutang-admin') }}" class="nav-link active">
                                <i class="nav-icon fas fa-hand-holding-usd"></i>
                                <p>
                                    <strong>HUTANG</strong>
                                    <i class="right fas fa-angle-down"></i>
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
                                    <a href="{{ url('/datapetani') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Petani</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a a href="{{ url('/register') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tambah Akun</p>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="{{ url('/hapuspetani') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Hapus Akun</p>
                                    </a>
                                </li> --}}
                            </ul>
                        </li>
                        <li class="nav-item menu-close">
                            <a href="{{ url('/parameter') }}" class="nav-link">
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
            <!-- Content Header (Page header) -->

            <!-- /.content-header -->

            <!-- Main content -->
            <!-- /.col-md-6 -->
            <div class="content">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">List Hutang Petani</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama Petani</th>
                                                <th>Tanggal Hutang</th>
                                                <th>Bon</th>
                                                <th>Cicilan</th>
                                                <th>Tanggal Lunas</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $bonFormatted = number_format($row['bon'], 0, ',', '.');
                                                $cicilanFormatted = number_format($row['cicilan'], 0, ',', '.');
                                                echo '<tr>';
                                                echo '<td>' . $row['id_petani'] . '</td>';
                                                echo '<td>' . $row['name'] . '</td>';
                                                echo '<td>' . $row['tanggal_hutang'] . '</td>';
                                                echo '<td>Rp. ' . $bonFormatted . '</td>';
                                                echo '<td>Rp. ' . $cicilanFormatted . '</td>';
                                                echo '<td>' . $row['tanggal_lunas'] . '</td>';
                                                echo '<td>
                                                        <form action="' . route('hutang.delete', ['id' => $row['id_petani']]) . '" method="POST" onsubmit="return confirm(\'Apakah anda yakin ingin menghapus data ini?\');">
                                                            ' . csrf_field() . '
                                                            ' . method_field('DELETE') . '
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                      </td>';
                                                echo '</tr>';
                                            }
                                            ?>
                                        </tbody>

                                    </table>
                                </div>

                                <!-- /.card-body -->
                            </div>
                            <div class="container">
                                <div class="row">
                                    <!-- Form for new debt -->
                                    <div class="col-md-6">
                                        <div class="card card-danger">
                                            <div class="card-header">
                                                <h3 class="card-title">Hutang Baru</h3>
                                            </div>
                                            <form action="{{ route('hutang.store') }}" method="POST">
                                                @csrf
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>Nomor ID Petani:</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="far fa-user"></i></span>
                                                            </div>
                                                            <select name="id_petani" class="form-control" required>
                                                                <option value="" selected disabled>Pilih Petani</option>
                                                                <?php foreach ($allPetani as $user) : ?>
                                                                    <option value="<?= $user['id'] ?>"><?= $user['id'] . ' - ' . $user['name'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tanggal Hutang:</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <input type="date" name="tanggal_hutang" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Bon</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="nav-icon fas fa-hand-holding-usd"></i></span>
                                                            </div>
                                                            <input type="number" name="bon" class="form-control" id='bon-input' required>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="width: 100%; justify-content: center;">
                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-danger btn-block">Simpan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                            
                                    <!-- Form for payment -->
                                    <div class="col-md-6">
                                        <div class="card card-green">
                                            <div class="card-header">
                                                <h3 class="card-title">Pelunasan / Cicilan</h3>
                                            </div>
                                            <form action="{{ route('pelunasan') }}" method="POST" id="quickForm">
                                                @csrf
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>Nomor ID Petani:</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="far fa-user"></i></span>
                                                            </div>
                                                            <select name="id_petani" class="form-control" required>
                                                                <option value="" selected disabled>Pilih Petani</option>
                                                                <?php foreach ($petaniInHutang as $user) : ?>
                                                                    <option value="<?= $user['id'] ?>"><?= $user['id'] . ' - ' . $user['name'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Jumlah Bayar</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="nav-icon fas fa-hand-holding-usd"></i></span>
                                                            </div>
                                                            <input type="number" name="jumlah_bayar" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="width: 100%; justify-content: center;">
                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-success btn-block">Selesai</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col (right) -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            <!-- /.form-group -->
        </div>
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
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">SIMBAKO</a>.</strong> All rights reserved.
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
</body>

</html>
</body>


