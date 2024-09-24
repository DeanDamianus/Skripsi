{{-- <?php
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
    $bruto = $_POST['bruto'];
    $harga = $_POST['harga'];
    $jual_luar = $_POST['jual_luar']; 
    $berat_gudang = $_POST['berat_gudang'];
    $grade = $_POST['grade'];
    $id_petani = $_POST['id_petani'];
    $periode = $_POST['periode'];
    $seri = $_POST['seri'];
    $no_gg = $_POST['no_gg'];

    // Insert the data into the rekap_2024 table
    $insert_query = "INSERT INTO rekap_2024 (id_petani, netto, bruto, jual_luar, harga, berat_gudang, grade, periode, seri, no_gg) 
                    VALUES ('$id_petani', '$netto','$bruto', '$jual_luar', '$harga', '$berat_gudang', '$grade', '$periode', '$seri', '$no_gg')";

    if (mysqli_query($con, $insert_query)) {
        echo "Data berhasil ditambahkan!";
    } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($con);
    }
}

// Fetch the user's data from the database
$id = isset($_GET['id']) ? $_GET['id'] : null;
if ($id === null) {
    die('Error: ID parameter is missing.');
}

$nama_query = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($con, $nama_query);

if ($user_data = mysqli_fetch_assoc($result)) {
    $user_name = $user_data['name'];
} else {
    $user_name = 'Unknown'; // Default value if user not found
}

$total_harga = 0;
?> --}}

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
                    <a href="{{ url('/dataInput?id=' . $userId . '&id_musim='. $idMusim. '&year='. $selectedYear) }}" class="btn btn-outline-dark float-right"
                        style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; padding: 0; border: 2px solid black; background-color: transparent;">
                        <i class="fas fa-arrow-left" style="font-size: 20px; color: black;"></i>
                    </a>
                    <div class="col-sm-6">
                        <h1>Input Nota <label>
                            
                            </label></h1>
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
                        <form method="POST" action="{{ route('inputPetani.store') }}">
                            @csrf
                            <input type="hidden" name="jual_luar_value" id="jual_luar_value" value="0">
                            <input type="hidden" name="id_petani" value={{ $userId }}>
                            <input type="hidden" name="id_petani" value="{{ $idMusim }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Berat Gudang <i class="fas fa-warehouse"></i></label>
                                            <input type="number" name="berat_gudang" class="form-control"
                                                placeholder="Masukkan Berat Gudang (Kg)" required>
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label>Harga Keranjang <i class="fas fa-dollar-sign"></i></label>
                                            </label>
                                            <input type="number" name="harga" class="form-control"
                                                placeholder="Masukkan Harga" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Seri <i class="fas fa-calendar"></i></label>
                                            <input type="text" id="seri" name="seri" class="form-control"
                                                placeholder="Masukkan Seri (TGL01)" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Grade <i class="fas fa-star-half-alt"></i></i></label>
                                            <br>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="gradeA" name="grade" value="A"
                                                    class="form-check-input" required>
                                                <label class="form-check-label" for="gradeA">A</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="gradeB" name="grade" value="B"
                                                    class="form-check-input" required>
                                                <label class="form-check-label" for="gradeB">B</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="gradeC" name="grade" value="C"
                                                    class="form-check-input" required>
                                                <label class="form-check-label" for="gradeC">C</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" id="gradeD" name="grade" value="D"
                                                    class="form-check-input" required>
                                                <label class="form-check-label" for="gradeD">D</label>
                                            </div>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bruto <i class="fas fa-weight-hanging"></i></label>
                                            <input type="number" name="bruto" class="form-control"
                                                placeholder="Masukkan Bruto" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Netto <i class="fas fa-weight-hanging"></i></label>
                                            <input type="number" name="netto" class="form-control"
                                                placeholder="Masukkan Netto" required>
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label>Periode <i class="fas fa-clock"></i></label></label>
                                            <input type="text" name="periode" class="form-control"
                                                placeholder="Masukkan periode (1-A) " required>
                                        </div>
                                        <div class="form-group">
                                            <label>No.GG <i class="fas fa-hashtag"></i></label>
                                            <input type="text" id="no_gg" name="no_gg" class="form-control"
                                                placeholder="Masukkan No.GG" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Tipe </label> <i class="fas fa-exchange-alt"></i><br>
                                            <input type="checkbox" id="jual_luar_checkbox" name="jual_luar_checkbox">
                                            <label for="jual_luar_checkbox"> <span class="badge badge-warning">Jual
                                                    Luar</span></label>
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
        var jualLuarCheckbox = document.getElementById('jual_luar_checkbox');
        var jualLuarValueField = document.getElementById('jual_luar_value');
    
        // Get the form fields to be disabled and cleared
        var periodeField = document.querySelector('input[name="periode"]');
        var seriField = document.getElementById('seri');
        var noGGField = document.getElementById('no_gg');
        var gradeFields = document.querySelectorAll('input[name="grade"]');
    
        // Function to update hidden input based on checkbox state and clear inputs if needed
        function updateJualLuarValue() {
            if (jualLuarCheckbox.checked) {
                jualLuarValueField.value = '1';  // Checked state, value = 1
                
                // Disable and clear the fields when Jual Luar is selected
                periodeField.disabled = true;
                periodeField.value = '';  // Clear input
    
                seriField.disabled = true;
                seriField.value = '';     // Clear input
    
                noGGField.disabled = true;
                noGGField.value = '';     // Clear input
    
                gradeFields.forEach(function(field) {
                    field.disabled = true;
                    field.checked = false;  // Clear selection
                });
            } else {
                jualLuarValueField.value = '0'; 
                
                periodeField.disabled = false;
                seriField.disabled = false;
                noGGField.disabled = false;
                gradeFields.forEach(function(field) {
                    field.disabled = false;
                });
            }
        }
    
        // Attach event listener to the checkbox
        jualLuarCheckbox.addEventListener('change', updateJualLuarValue);
    
        // Call the function on page load to set initial state
        updateJualLuarValue();
    });
</script>


</html>