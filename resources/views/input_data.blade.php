<?php
// Establish the connection
$con = mysqli_connect('localhost', 'root', '', 'simbako_app');

// Check connection
if (!$con) {
    die('Koneksi Error: ' . mysqli_connect_error());
}

// Initialize $user_data as an empty array
$user_data = array();
$total_harga = 0;

// Check if 'id' exists in the URL
if (isset($_GET['id'])) {
    // Get the ID from the query parameter
    $id = intval($_GET['id']); // Use intval to ensure $id is an integer

    // Fetch the user's data from the database
    $query_user = "SELECT * FROM users WHERE id = $id";
    $user_result = mysqli_query($con, $query_user);

    if ($user_result && mysqli_num_rows($user_result) > 0) {
        $user_data = mysqli_fetch_assoc($user_result);

        // Fetch rekap data for the current user
        $query_rekap = "SELECT * FROM rekap_2024 WHERE id_petani = $id";
        $rekap_result = mysqli_query($con, $query_rekap);

        // Check if rekap data query is successful
        if (!$rekap_result) {
            die('Error fetching rekap data: ' . mysqli_error($con));
        }
    } else {
        // User not found, redirect or show an error message
        echo "User not found.";
        exit; // Stop further execution
    }
} else {
    // Redirect or show an error message if 'id' is not provided
    echo "ID parameter is missing in the URL.";
    exit; // Stop further execution
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
                        <h1>List Rekap <?php echo $user_data['name']; ?></h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <button onclick="window.location.href='/inputPetani?id=<?php echo $id; ?>'"
                                    class="btn btn-primary">
                                    Tambah Rekap
                                </button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID Petani</th>
                                            <th>Netto Total</th>
                                            <th>Jumlah</th>
                                            <th>Komisi</th>
                                            <th>Hasil Bersih</th>
                                            <th>
                                                <div class="text-center">
                                            <th>Action</th>
                            </div>
                            </th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                        while ($row = mysqli_fetch_assoc($rekap_result)) {
                                            // Get data for each rekap row
                                            $id_petani = $row['id_petani'];
                                            $netto = $row['netto'];
                                            $harga_per_unit = $row['harga'];

                                            // Calculate total harga
                                            $jumlah = $netto * $harga_per_unit;
                                            $komisi = $jumlah * 0.1; // Example: 10% komisi
                                            $hasil_bersih = $jumlah - $komisi;

                                            // Format harga for display
                                            $jumlahFormatted = 'Rp. ' . number_format($jumlah, 0, ',', '.');
                                            $komisiFormatted = 'Rp. ' . number_format($komisi, 0, ',', '.');
                                            $hasilBersihFormatted = 'Rp. ' . number_format($hasil_bersih, 0, ',', '.');

                                            // Add to total_harga
                                            $total_harga += $jumlah;
                                        ?>
                                <tr>
                                    <td><?php echo $id_petani; ?></td>
                                    <td><?php echo number_format($netto, 0, ',', '.') . ' kg'; ?></td>
                                    <td><?php echo $jumlahFormatted; ?></td>
                                    <td><?php echo $komisiFormatted; ?></td>
                                    <td><?php echo $hasilBersihFormatted; ?></td>
                                    <td><button onclick="window.location.href='/inputPetani?id=<?php echo $id; ?>'"
                                            class="btn btn-block btn-success">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <button onclick="if(confirm('Are you sure you want to delete this record?')) window.location.href='/dataInput.php?id_rekap=<?php echo $row['id_rekap']; ?>'" class="btn btn-block btn-danger">
                                            Hapus
                                        </button> 
                                    </td>

                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Total Netto :</th>
                                    <th>Total Jumlah : <?php echo 'Rp. ' . number_format($total_harga, 0, ',', '.'); ?></th>
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
