<?php
// Establish the connection
$con = new mysqli('localhost', 'root', '', 'simbako_app');

// Check connection
if ($con->connect_error) {
    die('Connection Error: ' . $con->connect_error);
}

// Get the current `id_rekap` from the URL (assuming it's passed in the URL)
$id_rekap = isset($_GET['id_rekap']) ? intval($_GET['id_rekap']) : 0;

// Fetch the existing data for the selected `id_rekap`
$fetch_query = $con->prepare("SELECT * FROM rekap_2024 WHERE id_rekap = ?");
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
    $update_query->bind_param('ssssi', $netto, $harga, $berat_gudang, $grade, $id_rekap);

    if ($update_query->execute()) {
        echo "Data successfully updated!";
    } else {
        echo "Error: " . $update_query->error;
    }
}

// Fetch the user's data from the `users` table
$nama_query = $con->prepare("SELECT * FROM users WHERE id = ?");
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
                    <img src="dist/img/simbakologo.png" alt="SIMBAKO Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">SIMBAKO</span>
                </a>
                <!-- More Navbar Code Here -->
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
            </div>
        </section>

        <!-- Main content -->
        <form method="POST" action="">
            <input type="hidden" name="id_rekap" value="<?php echo htmlspecialchars($id_rekap); ?>">
        
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Netto</label>
                            <input type="number" name="netto" class="form-control" value="<?php echo htmlspecialchars($netto); ?>" placeholder="Masukkan Netto" required>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Harga Berat Keranjang</label>
                            <input type="number" name="harga" class="form-control" value="<?php echo htmlspecialchars($harga); ?>" placeholder="Masukkan Harga" required>
                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Berat Gudang</label>
                            <input type="number" name="berat_gudang" class="form-control" value="<?php echo htmlspecialchars($berat_gudang); ?>" placeholder="Masukkan Berat Gudang (Kg)" required>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Grade</label>
                            <input type="text" name="grade" class="form-control" value="<?php echo htmlspecialchars($grade); ?>" placeholder="Masukkan Grade" required>
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
            var confirmed = confirm('Apakah anda yakin ingin mengubah data berikut?');
            if (!confirmed) {
                // Prevent form submission if not confirmed
                event.preventDefault();
            }
        });
    });
</script>
</html>
