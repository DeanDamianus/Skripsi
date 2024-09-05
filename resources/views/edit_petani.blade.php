<?php

// Establish the connection
$con = mysqli_connect('localhost', 'root', '', 'simbako_app');

// Check connection
if (!$con) {
    die('Koneksi Error: ' . mysqli_connect_error());
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect data from the form
    $netto = $_POST['netto'];
    $harga = $_POST['harga'];
    $berat_gudang = $_POST['berat_gudang'];
    $grade = $_POST['grade'];
    $id_petani = $_GET['id']; // Assuming the ID is passed via the URL

    // Insert the data into the rekap_2024 table
    $insert_query = "INSERT INTO rekap_2024 (id_petani, netto, harga, berat_gudang, grade) 
                     VALUES ('$id_petani', '$netto', '$harga', '$berat_gudang', '$grade')";

    if (mysqli_query($con, $insert_query)) {
        echo "Data berhasil ditambahkan!";
    } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($con);
    }
}

// Fetch the user's data from the database
$id = $_GET['id'];
$nama = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($con, $nama);

if ($user_data = mysqli_fetch_assoc($result)) {
    $user_name = $user_data['name'];
} else {
    $user_name = 'Unknown'; // Default value if user not found
}

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
                    <button onclick="history.back()">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="col-sm-6">
                        <h1>Edit Nota <?php echo htmlspecialchars($user_name); ?></h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <form method="POST" action="">
            @csrf
            <input type="hidden" name="id_petani" value="<?php echo htmlspecialchars($id); ?>">
        
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Netto</label>
                            <input type="number" name="netto" class="form-control" placeholder="Masukkan Netto" required>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Harga Berat Keranjang</label>
                            <input type="number" name="harga" class="form-control" placeholder="Masukkan Harga" required>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Berat Gudang</label>
                            <input type="number" name="berat_gudang" class="form-control" placeholder="Masukkan Berat Gudang (Kg)" required>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Grade</label>
                            <input type="text" name="grade" class="form-control" placeholder="Masukkan Grade" required>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Ubah</button>
            </div>
        </form>
        
        
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.querySelector('form');
    
        form.addEventListener('submit', function(event) {
            // Display confirmation dialog
            var confirmed = confirm('Apakah anda yakin ingin menambahkan data berikut?');
            if (!confirmed) {
                // Prevent form submission if not confirmed
                event.preventDefault();
            }
        });
    });
    </script>
    
</html>
