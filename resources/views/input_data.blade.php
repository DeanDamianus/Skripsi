<?php

// Establish the connection
$con = mysqli_connect('localhost', 'root', '', 'simbako_app');

// Check connection
if (!$con) {
    die('Koneksi Error: ' . mysqli_connect_error());
}

//Querry nama
$nama = "SELECT * FROM users WHERE role = 'petani'";
$result = mysqli_query($con, $nama);

$total_harga = 0;
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
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="{{ url('/input') }}" class="navbar-brand">
                    <img src="dist/img/simbakologo.png" alt="SIMBAKO Logo" class="brand-image img-circle elevation-3"
                        style="opacity: .8">
                    <span class="brand-text font-weight-light">SIMBAKO</span>
                </a>
                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{ url('/owner') }}" class="nav-link"></a>
                        </li>
                    </ul>
                </div>

                <!-- Right navbar links -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
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
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>List Rekap John Doe</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- Main content -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID Petani</th>
                                            <th>Nama Petani</th>
                                            <th>Netto Total</th>
                                            <th>Jumlah</th>
                                            <th>Komisi</th>
                                            <th>Hasil Bersih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                  while($row = mysqli_fetch_assoc($result)){
                      // Query to get the total bruto for each petani
                      $id_petani = $row['id'];
                      $query_bruto = "SELECT SUM(netto) AS total_bruto FROM rekap_2024 WHERE id_petani = '$id_petani'";
                      $bruto_result = mysqli_query($con, $query_bruto);
                      $bruto_data = mysqli_fetch_assoc($bruto_result);
                      
                      $total_bruto = isset($bruto_data['total_bruto']) ? $bruto_data['total_bruto'] : 0;
                      
                      $query_harga = "SELECT harga FROM rekap_2024 WHERE id_petani = '$id_petani'";
                      $harga_result = mysqli_query($con, $query_harga);
                      $harga_data = mysqli_fetch_assoc($harga_result);
                      
                      $harga_per_unit = isset($harga_data['harga']) ? $harga_data['harga'] : 0;
                      
                      $harga = $total_bruto * $harga_per_unit;
                      $hargaFormatted = 'Rp. ' . number_format($harga, 0, ',', '.');
                      $total_harga += $harga;
                      ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo number_format($total_bruto, 0, ',', '.') . ' kg'; ?></td>
                                            <td><?php echo $hargaFormatted; ?></td>
                                            <td>Komisi Calculation</td>
                                            <td>Hasil Bersih Calculation</td>
                                        </tr>
                                        <?php 
                  }
                  ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>

                                            <th></th>
                                            <th></th>
                                            <th>Total Netto : <?php ?></th>
                                            <th>Total Jumlah : <?php echo number_format($total_harga, 0, ',', '.'); ?></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
</body>

</html>
