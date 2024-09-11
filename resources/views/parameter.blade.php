<?php
// Connect to the database
$con = mysqli_connect('localhost', 'root', '', 'simbako_app');

// Check connection
if (!$con) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Fetch the record with ID 1
$id = 1;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update the record
    $biaya_jual = $_POST['biaya_jual'];
    $naik_turun = $_POST['naik_turun'];

    $sql_update = 'UPDATE parameter_2024 SET biaya_jual = ?, naik_turun = ? WHERE id = ?';
    $stmt_update = $con->prepare($sql_update);
    $stmt_update->bind_param('ddi', $biaya_jual, $naik_turun, $id);
    $stmt_update->execute();
    $stmt_update->close();

    // Redirect with success flag
    header('Location: parameter.php?success=true');
    exit();
} else {
    $sql = 'SELECT * FROM parameter_2024 WHERE id = ?';
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
}

// Close connection
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
                        <li class="nav-item menu-close">
                            <a href="{{ url('/input') }}" class="nav-link">
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
                        <li class="nav-item menu-open">
                            <a href="{{ url('/parameter') }}" class="nav-link active">
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
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Input Parameter</h1>
                        </div>
                    </div>
                </div>
            </section>

            <div class="content">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-body">
                                        <!-- Display message if available -->
                                        <?php if (isset($message)): ?>
                                        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
                                        <?php endif; ?>

                                        <!-- Form for Editing Parameter -->
                                        <form method="POST" href="{{ url('/parameter') }}">
                                            @csrf
                                            <input type="hidden" name="id"
                                                value="<?= htmlspecialchars($row['id']) ?>">

                                            <div class="form-group">
                                                <label for="biaya_jual">Biaya Jual</label>
                                                <input type="number" name="biaya_jual" class="form-control"
                                                    id="biaya_jual"
                                                    value="<?= htmlspecialchars($row['biaya_jual']) ?>" step="0.01"
                                                    required>
                                            </div>

                                            <div class="form-group">
                                                <label for="naik_turun">Naik Turun</label>
                                                <input type="number" name="naik_turun" class="form-control"
                                                    id="naik_turun"
                                                    value="<?= htmlspecialchars($row['naik_turun']) ?>" step="0.01"
                                                    required>
                                            </div>

                                            <div class="form-group mb-0">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="terms"
                                                        class="custom-control-input" id="exampleCheck1" required>
                                                    <label class="custom-control-label" for="exampleCheck1">Saya
                                                        Setuju akan <a href="#">pergantian Parameter
                                                            Berikut</a>.</label>
                                                </div>
                                            </div>

                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
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
</body>

</html>
