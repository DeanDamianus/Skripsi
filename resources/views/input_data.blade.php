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
                    <a href="{{ url('/input?year=' . $selectedYear) }}" class="btn btn-outline-dark float-right"
                        style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; padding: 0; border: 2px solid black; background-color: transparent;">
                        <i class="fas fa-arrow-left" style="font-size: 20px; color: black;"></i>
                    </a>
                    <div class="col-sm-6">
                        <h1>List Rekap <label> {{ $username}} </label></h1>
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
                                <button onclick="window.location.href='{{ url('/inputform?id=' . $idPetani . '&id_musim=' . $id . '&year=' . $selectedYear ) }}'" class="btn btn-primary">
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
                                        @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->id_rekap }}</td>
                                            <td>{{ number_format($item->bruto, 0, ',', '.') . ' kg' }}</td>
                                            <td>{{ number_format($item->netto, 0, ',', '.') . ' kg' }}</td>
                                            <td>{{ 'Rp. ' . number_format($harga, 0, ',', '.') }}</td>
                                            <td>{{ 'Rp. ' . number_format($item ->jumlah, 0, ',', '.') }}</td>
                                            <td>{{ 'Rp. ' . number_format($item->kj, 0, ',', '.') }}</td>
                                            <td>{{ 'Rp. ' . number_format($item->jumlahkotor, 0, ',', '.') }}</td>
                                            <td>{{ 'Rp. ' . number_format($item->komisi, 0, ',', '.') }}</td>
                                            <td>{{ 'Rp. ' . number_format($item->bersih, 0, ',', '.') }}</td>
                                            <td>{{ $item->berat_gudang }}</td>
                                            <td>{{ $item->grade }}</td>
                                            <td>{!! $item->indicator !!}</td>
                                            <td>{{ $item->cek}}</td>
                                            <td>
                                                <button {{--
                                                    onclick="if(confirm('Are you sure you want to delete this record?')) window.location.href='/dataInput?id=<?php echo htmlspecialchars($id); ?>&id_rekap=<?php echo htmlspecialchars($row['id_rekap']); ?>'"
                                                    --}} class="btn btn-block btn-danger">
                                                    <a><i class="fas fa-trash"></i></a>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>{{ number_format($totalbruto, 0, ',', '.') . ' kg' }}</th>
                                            <th>{{ number_format($totalnetto, 0, ',', '.') . ' kg' }}</th>
                                            <th></th>
                                            <th>{{ 'Rp. ' . number_format($totaljumlahharga, 0, ',', '.') }}</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>{{ 'Rp. ' . number_format($totaljumlahbersih, 0, ',', '.') }}</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>{{ $cektotal }}</th>
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