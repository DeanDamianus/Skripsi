<?php
// Establish the connection
$con = new mysqli('localhost', 'root', '', 'simbako_app');

// Check connection
if ($con->connect_error) {
    die('Connection Error: ' . $con->connect_error);
}

// Enable error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Get the current `id_rekap` from the URL (assuming it's passed in the URL)
$id_rekap = isset($_GET['id_rekap']) ? intval($_GET['id_rekap']) : 0;

// Fetch the existing data for the selected `id_rekap`
$fetch_query = $con->prepare('SELECT * FROM rekap_2024 WHERE id_rekap = ?');
$fetch_query->bind_param('i', $id_rekap);
$fetch_query->execute();
$result = $fetch_query->get_result();

if ($data = $result->fetch_assoc()) {
    // Populate form with existing data
    $netto = $data['netto'];
    $harga = $data['harga'];
    $berat_gudang = $data['berat_gudang'];
    $grade = $data['grade'];
    $id_petani = $data['id_petani'];
} else {
    die('Data not found!');
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect data from the form
    $netto = $_POST['netto'];
    $harga = $_POST['harga'];
    $berat_gudang = $_POST['berat_gudang'];
    $grade = $_POST['grade'];

    // Update the existing data in the rekap_2024 table
    $update_query = $con->prepare("UPDATE rekap_2024 
                                    SET netto = ?, harga = ?, berat_gudang = ?, grade = ? 
                                    WHERE id_rekap = ?");
    $update_query->bind_param('ddsdi', $netto, $harga, $berat_gudang, $grade, $id_rekap);

    if ($update_query->execute()) {
    // Redirect using PHP header function
    header("Location: http://127.0.0.1:8000/input");
    exit; // Ensure no further code is executed after the redirect
} else {
    echo "Error: " . $update_query->error;
}

}

// Fetch the user's data from the `users` table
$nama_query = $con->prepare('SELECT * FROM users WHERE id = ?');
$nama_query->bind_param('i', $id_petani);
$nama_query->execute();
$result = $nama_query->get_result();

if ($user_data = $result->fetch_assoc()) {
    $user_name = $user_data['name'];
} else {
    $user_name = 'Unknown'; // Default value if user not found
}

$con->close();
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
                <ul class="navbar-nav">
                    <li class="nav-item d-none d-sm-inline-block">
                      <a href="{{url('/input')}}" class="nav-link">Home</a>
                    </li>
                </ul>
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
                        <h1>Edit Nota <?php echo htmlspecialchars($user_name); ?></h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <form method="POST" action="{{ route('editInput.update') }}">
            @csrf
            <input type="hidden" name="id_rekap" value="<?php echo htmlspecialchars($id_rekap); ?>">
            <input type="hidden" name="redirect_url" value="<?php echo htmlspecialchars($_SERVER['HTTP_REFERER']); ?>">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Netto</label>
                            <input type="number" name="netto" class="form-control" value="<?php echo htmlspecialchars($netto); ?>"
                                placeholder="Masukkan Netto" required>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Harga Berat Keranjang</label>
                            <input type="number" name="harga" class="form-control" value="<?php echo htmlspecialchars($harga); ?>"
                                placeholder="Masukkan Harga" required>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Berat Gudang</label>
                            <input type="number" name="berat_gudang" class="form-control" value="<?php echo htmlspecialchars($berat_gudang); ?>"
                                placeholder="Masukkan Berat Gudang (Kg)" required>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Grade</label>
                            <input type="text" name="grade" class="form-control" value="<?php echo htmlspecialchars($grade); ?>"
                                placeholder="Masukkan Grade" required>
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
@if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                alert('{{ session('success') }}');
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if the URL contains 'success=true'
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('success') === 'true') {
                alert('Data berhasil diubah!');
            }
        });
    </script>

</html>
