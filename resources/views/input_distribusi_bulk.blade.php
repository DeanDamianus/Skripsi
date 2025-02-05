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
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
                        <h1>Input Bulk Distribusi Nomor Rekap {{ $periode }}</h1>
                    </div>
                </div>
            </div>
        </section>
        <!-- Main content -->
        <form method="POST" action="{{ route('inputbulk') }}">
            @csrf
            @foreach ($idrekap as $id)
                <input type="hidden" name="id_rekap[]" value="{{ $id }}">
            @endforeach
            <input type="hidden" name="id_musim" value="{{ $idMusim }}">
            <input type="hidden" name="n_gudang" value="5000">
            <input type="hidden" name="nt_pabrik" value="10000">
            <input type="hidden" name="kasut" value="10000">
            <input type="hidden" name="transport_gudang" value="5000">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mobil Berangkat <i class="fas fa-road"> </i> <i
                                    class="fas fa-arrow-right"></i></label>
                            <input type="number" name="mobil_berangkat" class="form-control" required
                                placeholder="{{ $mobil_berangkat ?? 'Masukkan Harga Berangkat' }}"
                                value="{{ old('mobil_berangkat', $mobil_berangkat ?? '') }}">
                        </div>
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
                                <input type="radio" id="Dikembalikan" name="status" value="Dikembalikan"
                                    class="form-check-input" {{ $status === 'Dikembalikan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="Dikembalikan">Dikembalikan <i
                                        class="fas fa-times"></i></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mobil Pulang <i class="fas fa-road"> </i> <i class="fas fa-arrow-left"></i></label>
                            <input type="number" name="mobil_pulang" class="form-control" required
                                placeholder="{{ $mobil_pulang ?? 'Masukkan Harga pulang' }}"
                                value="{{ old('mobil_pulang', $mobil_pulang ?? '') }}">
                        </div>
                        <div class="col-13">
                            <label>Grade <i class="fas fa-star-half-alt"></i></label>
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0" style="height: 250px;">
                                    <table class="table table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>ID Keranjang</th>
                                                <th>Grade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $rekap)
                                                <tr>
                                                    <td>{{ $rekap->id_rekap }}</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" id="gradeA_{{ $rekap->id_rekap }}" name="grade_{{ $rekap->id_rekap }}"
                                                                value="A" class="form-check-input"
                                                                {{ $rekap->grade == 'A' ? 'checked' : '' }} required>
                                                            <label class="form-check-label" for="gradeA_{{ $rekap->id_rekap }}">A</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" id="gradeB_{{ $rekap->id_rekap }}" name="grade_{{ $rekap->id_rekap }}"
                                                                value="B" class="form-check-input"
                                                                {{ $rekap->grade == 'B' ? 'checked' : '' }} required>
                                                            <label class="form-check-label" for="gradeB_{{ $rekap->id_rekap }}">B</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" id="gradeC_{{ $rekap->id_rekap }}" name="grade_{{ $rekap->id_rekap }}"
                                                                value="C" class="form-check-input"
                                                                {{ $rekap->grade == 'C' ? 'checked' : '' }} required>
                                                            <label class="form-check-label" for="gradeC_{{ $rekap->id_rekap }}">C</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" id="gradeD_{{ $rekap->id_rekap }}" name="grade_{{ $rekap->id_rekap }}"
                                                                value="D" class="form-check-input"
                                                                {{ $rekap->grade == 'D' ? 'checked' : '' }} required>
                                                            <label class="form-check-label" for="gradeD_{{ $rekap->id_rekap }}">D</label>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>

                    </div>

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
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

</body>

</html>
