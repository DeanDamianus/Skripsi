<?php
// Establish the connection
$con = mysqli_connect('localhost', 'root', '', 'simbako_app');

// Check connection
if (!$con) {
    die('Koneksi Error: ' . mysqli_connect_error());
}

// Initialize variables
$user_data = [];
$total_harga = 0;
$total_netto = 0;
$total_bruto = 0;
$total_gudang = 0; 
$total_bersih = 0;
$cekkilo = 0;

// Check if 'id' exists in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch the user's data from the database
    $query_user = "SELECT * FROM users WHERE id = $id";
    $user_result = mysqli_query($con, $query_user);

    if ($user_result && mysqli_num_rows($user_result) > 0) {
        $user_data = mysqli_fetch_assoc($user_result);

        // Fetch rekap data for the current user
        $query_rekap = "SELECT rekap_2024.*, parameter_2024.biaya_jual, parameter_2024.naik_turun,parameter_2024.kepala_petani 
                FROM rekap_2024 
                JOIN parameter_2024 ON parameter_2024.id = 1
                WHERE rekap_2024.id_petani = $id";
        $rekap_result = mysqli_query($con, $query_rekap);

        // Check if rekap data query is successful
        if (!$rekap_result) {
            die('Error fetching rekap data: ' . mysqli_error($con));
        }
    } else {
        echo 'User not found.';
        exit();
    }
} else {
    echo 'ID parameter is missing in the URL.';
    exit();
}

// Check if 'id_rekap' exists in the URL and perform deletion
if (isset($_GET['id_rekap']) && !empty($_GET['id_rekap'])) {
    $id_rekap = intval($_GET['id_rekap']);

    // Delete the record
    $query_delete = "DELETE FROM rekap_2024 WHERE id_rekap = $id_rekap";
    if (mysqli_query($con, $query_delete)) {
        // Redirect to the same page to refresh the data
        header("Location: /dataInput?id=$id");
        exit();
    } else {
        die('Error deleting record: ' . mysqli_error($con));
    }
}

// Close the connection
mysqli_close($con);
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
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <a href="{{ url('/input') }}"class="btn btn-outline-dark float-right" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; padding: 0; border: 2px solid black; background-color: transparent;">
                        <i class="fas fa-arrow-left" style="font-size: 20px; color: black;"></i>
                    </a>         
                    <div class="col-sm-6">
                        <h1>List Rekap <label> <?php echo htmlspecialchars($user_data['name']); ?> </label></h1>
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
                                    <i class="nav-icon fas fa-plus"></i>
                                </button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.Krj</th>
                                            <th>Bruto</th>
                                            <th>Netto</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>KJ</th>
                                            <th>Jumlah Kotor</th>
                                            <th>Komisi</th>
                                            <th>Jumlah Bersih</th>
                                            <th>Gudang</th>
                                            <th>Grade</th>
                                            <th>Info</th>
                                            <th>Cek Kilo</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $subtotal_bersih = 0;
                                        while ($row = mysqli_fetch_assoc($rekap_result)) {
                                            // Get data for each rekap row
                                            $id_rekap = $row['id_rekap'];
                                            $id_petani = $row['id_petani'];
                                            $jual_luar = $row['jual_luar'];
                                            $bruto= $row['bruto'];
                                            $netto = $row['netto'];
                                            $harga_per_unit = $row['harga'];
                                            $grade = $row['grade'];
                                            $beratgg = $row['berat_gudang'];
                                            $biaya_jual = $row['biaya_jual'];
                                            $naik_turun = $row['naik_turun'];
                                            $kepala_petani = $row['kepala_petani'];
                                        
                                            $jumlah = $netto * $harga_per_unit;
                                        
                                            // Add to total_harga, total_netto, total_gudang
                                            $total_harga += $jumlah;
                                            $total_netto += $netto;
                                            
                                            
                                            // Calculate KJ
                                            $pajak_kj = 0;
                                            if ($harga_per_unit <= 50000) {
                                                $pajak_kj = 1000 * $netto;
                                            } elseif ($harga_per_unit <= 75000) {
                                                $pajak_kj = 2000 * $netto;
                                            } elseif ($harga_per_unit <= 100000) {
                                                $pajak_kj = 3000 * $netto;
                                            } elseif ($harga_per_unit <= 125000) {
                                                $pajak_kj = 4000 * $netto;
                                            } elseif ($harga_per_unit <= 150000) {
                                                $pajak_kj = 5000 * $netto;
                                            } else {
                                                $pajak_kj = 6000 * $netto;
                                            }
                                        
                                            $jumlahKotor = $jumlah - $pajak_kj - $biaya_jual - $naik_turun;
                                            $komisi = $jumlahKotor * $kepala_petani;
                                        
                                            if ($jual_luar == 1) {
                                                $hasil_bersih = $jumlahKotor; // Set hasil_bersih to jumlahKotor
                                                $indicator = '<span class="badge badge-warning">Jual Luar</span>'; // Visual indicator
                                            } else {
                                                $hasil_bersih = $jumlahKotor - $komisi;
                                                $indicator = ''; // No indicator
                                            }
                                            
                                            $subtotal_bersih += $hasil_bersih;
                                            
                                            // Formatting 
                                            $jumlahFormatted = 'Rp. ' . number_format($jumlah, 0, ',', '.');
                                            $hargaFormatted = 'Rp. ' . number_format($harga_per_unit, 0, ',', '.');
                                            $pajakKJFormatted = 'Rp. ' . number_format($pajak_kj, 0, ',', '.');
                                            $hasilBersihFormatted = 'Rp. ' . number_format($hasil_bersih, 0, ',', '.');
                                            $komisiFormatted = 'Rp. ' . number_format($komisi, 0, ',', '.');
                                            $jumlahkotorFormatted = 'Rp. ' . number_format($jumlahKotor, 0, ',', '.');
                                            $total_bruto += $bruto;
                                            $cek = $bruto - $beratgg;

                                            
                                        ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($id_rekap); ?></td>
                                                <td><?php echo number_format($bruto, 0, ',', '.') . ' kg'; ?></td>
                                                <td><?php echo number_format($netto, 0, ',', '.') . ' kg'; ?></td>
                                                <td><?php echo $hargaFormatted; ?></td>
                                                <td><?php echo htmlspecialchars($jumlahFormatted); ?></td>
                                                <td><?php echo htmlspecialchars($pajakKJFormatted); ?></td>
                                                <td><?php echo $jumlahkotorFormatted; ?></td>
                                                <td><?php echo htmlspecialchars($komisiFormatted); ?></td>
                                                <td><?php echo $hasilBersihFormatted; ?></td>
                                                <td><?php echo number_format($beratgg, 0, ',', '.') . ' kg'; ?></td>
                                                <td><?php echo htmlspecialchars($grade); ?></td>
                                                <td><?php echo $indicator; ?></td>
                                                <td><?php echo $cek != 0 ? $cek: '-'; ?></td>   
                                                
                                                {{-- <td>
                                                    <button
                                                        onclick="window.location.href='/editInput?id=<?php echo htmlspecialchars($id); ?>&id_rekap=<?php echo htmlspecialchars($row['id_rekap']); ?>'"
                                                        class="btn btn-block btn-success">
                                                        <a><i class="fas fa-edit"></i></a>
                                                    </button>
                                                </td> --}}
                                                <td>
                                                    <button
                                                        onclick="if(confirm('Are you sure you want to delete this record?')) window.location.href='/dataInput?id=<?php echo htmlspecialchars($id); ?>&id_rekap=<?php echo htmlspecialchars($row['id_rekap']); ?>'"
                                                        class="btn btn-block btn-danger">
                                                        <a><i class="fas fa-trash"></i></a>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th><?php echo number_format($total_bruto, 0, ',', '.') . ' kg'; ?></th>   
                                            <th><?php echo number_format($total_netto, 0, ',', '.') . ' kg'; ?></th>   
                                            <th></th>
                                            <th>Total: <?php echo 'Rp. ' . number_format($total_harga, 0, ',', '.'); ?></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Total: <?php echo number_format($subtotal_bersih, 0, ',', '.'); ?></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
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
