<?php
// Establish the connection
$con = mysqli_connect("localhost", "root", "", "simbako_app");

// Check connection
if (!$con) {
    die("Koneksi Error: " . mysqli_connect_error());
}

// Query to count the number of users with role 'petani'
$query = "SELECT COUNT(*) AS jumlah_petani FROM users WHERE role = 'petani'";
$result = mysqli_query($con, $query);
$data = mysqli_fetch_assoc($result);
$jumlah_petani = $data['jumlah_petani'] ?? 0;

// Query to calculate total netto
$nettoQuery = "SELECT SUM(netto) AS total_netto FROM rekap_2024";
$nettoResult = mysqli_query($con, $nettoQuery);
$nettoData = mysqli_fetch_assoc($nettoResult);
$totalNetto = $nettoData['total_netto'] ?? 0;
?>

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
                <a href="../../index3.html" class="nav-link">Home</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item d-none d-sm-inline-block">
                <div class="dropdown">
                    <button class="nav-link" type="button" data-toggle="dropdown" style="border: black;">
                        2024
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
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

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <img src="dist/img/simbakologo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">SIMBAKO</span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="dist/img/owner.png" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    @if(Auth::check())
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    @else
                        <a href="#" class="d-block">Guest</a>
                    @endif
                </div>
            </div>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-exchange-alt"></i>
                            <p>
                                <strong>REKAP</strong>
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item menu-close">
                        <a href="{{url('/input')}}" class="nav-link">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                <strong>INPUT NOTA</strong>
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item menu-close">
                        <a href="{{url('/hutang-admin')}}" class="nav-link">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>
                                <strong>HUTANG</strong>
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
                                <a href="{{url('/datapetani')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Petani</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('/register')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tambah Akun</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('/hapuspetani')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Hapus Akun</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item menu-close">
                        <a href="{{url('/parameter')}}" class="nav-link">
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
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Rekap Pengumpulan</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?php echo number_format($totalNetto, 0, ',', '.'); ?><sup style="font-size: 20px"> Kg</sup></h3>
                                <p>Total Netto Keranjang</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-weight-hanging"></i>
                            </div>
                            <a href="{{url('/datapetani')}}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><sup style="font-size: 20px">Rp.</sup>151.712.500</h3>
                                <p>Total Jumlah</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-coins"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><sup style="font-size: 20px">Rp.</sup>128.348.900</h3>
                                <p>Total Bayar</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <a href="#" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?php echo number_format($jumlah_petani, 0, ',', '.'); ?></h3>
                                <p>Total Petani</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <a href="{{url('/datapetani')}}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
