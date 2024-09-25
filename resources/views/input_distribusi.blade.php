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
                        <a href="{{ url('/input') }}" class="nav-link">Home</a>
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
                    <a href="javascript:history.back()" class="btn btn-outline-dark float-right"
                        style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; padding: 0; border: 2px solid black; background-color: transparent;">
                        <i class="fas fa-arrow-left" style="font-size: 20px; color: black;"></i>
                    </a>
                    <div class="col-sm-6">
                        <h1>Input Distribusi {{ $id_rekap }}</h1>
                    </div>
                </div>
            </div>
        </section>
        <!-- Main content -->
        <form method="POST" action="{{ route('inputdistribusi.store') }}">
            @csrf
            <input type="hidden" name="id_rekap" value="{{ $id_rekap }}">
            <input type="hidden" name="id_musim" value="{{ $idMusim }}">
            <input type="hidden" name="n_gudang" value="{{ $n_gudang }}">
            <input type="hidden" name="nt_pabrik" value="{{ $nt_pabrik }}">
            <input type="hidden" name="kasut" value="{{ $kasut }}">
            <input type="hidden" name="transport_gudang" value="{{ $transport_gudang }}">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mobil Berangkat <i class="fas fa-road"> </i> <i
                                    class="fas fa-arrow-right"></i></label>
                            <input type="number" name="mobil_berangkat" class="form-control" required
                                placeholder="{{ $mobil_berangkat ?? 'Masukkan Harga Berangkat' }}">
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Status <i class="fas fa-info-circle"></i></label>
                            <br>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="Diterima" name="status" value="Diterima"
                                    class="form-check-input" {{ $status === 'Diterima' ? 'checked' : '' }}>
                                <label class="form-check-label" for="Diterima">Diterima <i
                                        class="fas fa-check-circle"></i></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="Diproses" name="status" value="Diproses"
                                    class="form-check-input" {{ $status === 'Diproses' ? 'checked' : '' }}>
                                <label class="form-check-label" for="Diproses">Diproses <i
                                        class="fas fa-truck"></i></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="Ditolak" name="status" value="Ditolak"
                                    class="form-check-input" {{ $status === 'Ditolak' ? 'checked' : '' }}>
                                <label class="form-check-label" for="Ditolak">Ditolak <i
                                        class="fas fa-times"></i></label>
                            </div>
                        </div>

                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mobil Pulang <i class="fas fa-road"> </i> <i class="fas fa-arrow-left"></i></label>
                            <input type="number" name="mobil_pulang" class="form-control" required
                                placeholder="{{ $mobil_pulang ?? 'Masukkan Harga pulang' }}">

                        </div>
                        <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                </div>
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

</html>
