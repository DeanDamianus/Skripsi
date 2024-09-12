<?php
// Establish the connection
$con = mysqli_connect('localhost', 'root', '', 'simbako_app');

// Check connection
if (!$con) {
    die('Koneksi Error: ' . mysqli_connect_error());
}

// Query to get all petani
$nama = "SELECT * FROM users WHERE role = 'petani'";
$result = mysqli_query($con, $nama);

$total_harga = 0; // Initialize total harga
$total_netto = 0; // Initialize total netto

if (!$result) {
    die('Error fetching petani data: ' . mysqli_error($con));
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
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    <strong>INPUT NOTA</strong>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item menu-close">
                            <a href="{{ url('/hutang-admin') }}" class="nav-link">
                                <i class="nav-icon fas fa-hand-holding-usd"></i>
                                <p>
                                    <strong>HUTANG</strong>
                                    <i class="right fas fa-angle-left "></i>
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
                                <li class="nav-item">
                                    <a href="{{ url('/hapuspetani') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Hapus Akun</p>
                                    </a>
                                </li>
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
        </aside>

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- /.content-header -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Data Rekap</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

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
                                            <th>Pajak KJ</th> 
                                            <!-- i want to make th Pajak KJ to make a calculation of if harga is <= 0
                                                then the netto will be * 1000, if harga <= 50000 netto will be * 2000,
                                                if harga <= 75000 netto will be * 3000,if harga <= 100000 netto will be * 4000,
                                                if harga <= 125000 netto will be * 5000,if harga <= 150000 netto will be * 6000,
                                             -->
                                            <th>Jumlah Total</th>
                                            <th>Jumlah Kotor</th> <!-- 
                                                i want the jumlah kotor to make the calculations of the value of Jumlah  total - pajak KJ - 
                                                table value from parameter_2024 name borong_jual - table value from parameter_2024 name naik_turun, 
                                             -->
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $id_petani = $row['id'];
                                    
                                            // Query to get the total netto for each petani
                                            $query_bruto = "SELECT SUM(netto) AS total_bruto FROM rekap_2024 WHERE id_petani = '$id_petani'";
                                            $bruto_result = mysqli_query($con, $query_bruto);
                                            $bruto_data = mysqli_fetch_assoc($bruto_result);
                                    
                                            // Debugging output
                                            if (!$bruto_data) {
                                                echo "<tr><td colspan='7'>Error fetching netto for petani ID: $id_petani</td></tr>";
                                                continue; // Skip this iteration if there's no data
                                            }
                                    
                                            $total_bruto = isset($bruto_data['total_bruto']) ? $bruto_data['total_bruto'] : 0;
                                    
                                            // Query to get the total harga for each petani
                                            $query_harga = "SELECT SUM(netto * harga) AS total_harga FROM rekap_2024 WHERE id_petani = '$id_petani'";
                                            $harga_result = mysqli_query($con, $query_harga);
                                            $harga_data = mysqli_fetch_assoc($harga_result);
                                    
                                            if (!$harga_data) {
                                                echo "<tr><td colspan='7'>Error fetching harga for petani ID: $id_petani</td></tr>";
                                                continue; // Skip if no data
                                            }
                                    
                                            $total_harga_per_petani = isset($harga_data['total_harga']) ? $harga_data['total_harga'] : 0;
                                    
                                            // Format harga
                                            $hargaFormatted = 'Rp. ' . number_format($total_harga_per_petani, 0, ',', '.');
                                    
                                            // Accumulate totals
                                            $total_netto += $total_bruto;
                                            $total_harga += $total_harga_per_petani;
                                    
                                            $pajak_kj = 0;
                                    
                                            if ($total_harga_per_petani < 0) {
                                                $pajak_kj = $total_bruto * 1000;
                                            } elseif ($total_harga_per_petani > 0 && $total_harga_per_petani <= 50000) {
                                                $pajak_kj = $total_bruto * 2000;
                                            } elseif ($total_harga_per_petani > 50000 && $total_harga_per_petani <= 75000) {
                                                $pajak_kj = $total_bruto * 3000;
                                            } elseif ($total_harga_per_petani > 75000 && $total_harga_per_petani <= 100000) {
                                                $pajak_kj = $total_bruto * 4000;
                                            } elseif ($total_harga_per_petani > 100000 && $total_harga_per_petani <= 125000) {
                                                $pajak_kj = $total_bruto * 5000;
                                            } elseif ($total_harga_per_petani > 125000 && $total_harga_per_petani <= 150000) {
                                                $pajak_kj = $total_bruto * 6000;
                                            }

                                            $pajakKJFormatted = 'Rp. ' . number_format($pajak_kj, 0, ',', '.');
                                            ?>
                                    
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo number_format($total_bruto, 0, ',', '.') . ' kg'; ?></td>
                                                <td><?php echo $pajakKJFormatted; ?></td>
                                                <td><?php echo $hargaFormatted; ?></td>
                                                <td><?php echo $pajakKJFormatted; ?></td>
                                                <td><a href="{{ url('/dataInput?id=' . $row['id']) }}" type="button" class="btn btn-block btn-success"><i class="nav-icon fas fa-edit"></i></a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th><?php echo number_format($total_netto, 0, ',', '.') . ' kg'; ?></th>
                                                <th></th>
                                                <th><?php echo 'Rp. ' . number_format($total_harga, 0, ',', '.'); ?></th>
                                                <th></th>
                                                <td></td>
                                                
                                            </tr>
                                        </tfoot>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            <!-- /.row -->
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

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.2.0
        </div>
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>

    <aside class="control-sidebar control-sidebar-dark">
        <!-- Add Content Here -->
    </aside>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if the URL contains 'success=true'
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('success') === 'true') {
                alert('Parameter berhasil diubah!');
            }
        });
    </script>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.js"></script>
    <!-- Add your custom JavaScript here -->
</body>

</html>
