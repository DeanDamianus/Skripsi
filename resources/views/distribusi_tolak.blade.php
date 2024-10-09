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
                        <h1>Distribusi Ulang {{ $userId }}</h1>
                    </div>
                </div>
            </div>
        </section>
        <!-- Main content -->
        <form method="POST" action="{{ route('distribusiulang') }}">
            @csrf
            <input type="hidden" name="jual_luar_value" id="jual_luar_value" value="0">
            <input type="hidden" name="id_petani" value="{{ $idpetani }}">
            <input type="hidden" name="id_musim" value="{{ $idMusim }}">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Berat Gudang <i class="fas fa-warehouse"></i></label>
                            <input type="number" name="berat_gudang" class="form-control"
                                placeholder="Masukkan Berat Gudang (Kg)" value="{{ old('berat_gudang', $data->berat_gudang) }}"required>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Harga Keranjang <i class="fas fa-dollar-sign"></i></label>
                            </label>
                            <input type="number" name="harga" class="form-control"
                                placeholder="Masukkan Harga" value="{{ old('harga', $data->harga) }}"required>
                        </div>
                        <div class="form-group">
                            <label>Seri <i class="fas fa-calendar"></i></label>
                            <input type="text" id="seri" name="seri" class="form-control"
                                placeholder="Masukkan Seri (TGL01)"value="{{ old('seri', $data->seri) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Grade <i class="fas fa-star-half-alt"></i></label>
                            <br>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="gradeA" name="grade" value="A" class="form-check-input" 
                                    {{ old('grade', $data->grade) === 'A' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="gradeA">A</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="gradeB" name="grade" value="B" class="form-check-input" 
                                    {{ old('grade', $data->grade) === 'B' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="gradeB">B</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="gradeC" name="grade" value="C" class="form-check-input" 
                                    {{ old('grade', $data->grade) === 'C' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="gradeC">C</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="gradeD" name="grade" value="D" class="form-check-input" 
                                    {{ old('grade', $data->grade) === 'D' ? 'checked' : '' }} required>
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
                                placeholder="Masukkan Bruto" value="{{ old('bruto', $data->bruto) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Netto <i class="fas fa-weight-hanging"></i></label>
                            <input type="number" name="netto" class="form-control"
                                placeholder="Masukkan Netto" value="{{ old('netto', $data->netto) }}" required>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Periode <i class="fas fa-clock"></i></label></label>
                            <input type="text" name="periode" class="form-control"
                                placeholder="Masukkan periode dan Nota (1-A) " value="{{ old('periode', $data->periode) }}" required>
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
