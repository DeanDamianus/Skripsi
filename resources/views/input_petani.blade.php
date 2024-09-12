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
    $jual_luar = $_POST['jual_luar'];
    $berat_gudang = $_POST['berat_gudang'];
    $grade = $_POST['grade'];
    $periode= $_POST['periode'];
    $seri = $_POST['seri'];
    $no_gg = $_POST['no_gg'];
    $id_petani = $_GET['id'];

    // Insert the data into the rekap_2024 table
    $insert_query = "INSERT INTO rekap_2024 (id_petani, netto, jual_luar, harga, berat_gudang, grade,berat_gudang,periode,seri,no_gg) 
                     VALUES ('$id_petani', '$netto','$jual_luar', '$harga', '$berat_gudang', '$grade','$berat_gudang' , '$periode', '$seri', '$no_gg')";
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
                <ul class="navbar-nav">
                    <li class="nav-item d-none d-sm-inline-block">
                      <a href="{{url('/owner')}}" class="nav-link">Home</a>
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
                    <a href="javascript:history.back()" class="btn btn-outline-dark float-right" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; padding: 0; border: 2px solid black; background-color: transparent;">
                        <i class="fas fa-arrow-left" style="font-size: 20px; color: black;"></i>
                    </a>   
                    <div class="col-sm-6">
                        <h1>Input Nota <label> <?php echo htmlspecialchars($user_name); ?> </label></h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
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
                                            <label>Harga Keranjang</label>
                                            <input type="number" name="harga" class="form-control" placeholder="Masukkan Harga" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Seri</label>
                                            <input type="text" id="seri" name="seri" class="form-control" placeholder="Masukkan Seri (TGL01)" required>
                                        </div>
                                        <div class="form-group">
                                            <label >Tipe</label><br>
                                            <input type="checkbox" id="jual_luar" name="jual_luar" class="">
                                            <a>Jual Luar</a>
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
                                            <label>Periode</label>
                                            <input type="text" name="periode" class="form-control" placeholder="Masukkan periode (1-A) " required>
                                        </div>
                                        <div class="form-group">
                                            <label>No.GG</label>
                                            <input type="text" id="no_gg" name="no_gg" class="form-control" placeholder="Masukkan No.GG" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Grade</label>
                                            <br>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="gradeA" name="grade" value="A" class="form-check-input" required>
                                                <label class="form-check-label" for="gradeA">A</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="gradeB" name="grade" value="B" class="form-check-input" required>
                                                <label class="form-check-label" for="gradeB">B</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="gradeC" name="grade" value="C" class="form-check-input" required>
                                                <label class="form-check-label" for="gradeC">C</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="gradeD" name="grade" value="D" class="form-check-input" required>
                                                <label class="form-check-label" for="gradeD">D</label>
                                            </div>
                                        </div>
                                        
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div>
        <!-- Main content -->
        
        
        
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
    var jualLuarCheckbox = document.getElementById('jual_luar');
    var seriField = document.getElementById('seri');
    var noGGField = document.getElementById('no_gg');
    var gradeField = document.getElementById('grade');

    // Function to toggle disabled state and clear input fields
    function toggleFields() {
        if (jualLuarCheckbox.checked) {
            seriField.disabled = true;
            noGGField.disabled = true;
            gradeField.disabled = true;

            // Clear the fields when checkbox is checked
            seriField.value = '';
            noGGField.value = '';
            gradeField.value = '';
        } else {
            seriField.disabled = false;
            noGGField.disabled = false;
            gradeField.disabled = false;
        }
    }

    // Attach event listener to the checkbox
    jualLuarCheckbox.addEventListener('change', toggleFields);

    // Call function on page load to set initial state
    toggleFields();
    
    form.addEventListener('submit', function(event) {

    });
});
</script>
<script>


    
</html>
