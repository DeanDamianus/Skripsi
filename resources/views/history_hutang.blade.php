
<!DOCTYPE html>

<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Top Navigation</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="{{ url('/owner') }}" class="navbar-brand">
            <img src="../dist/img/simbakologo.png" alt="SIMBAKO Logo" class="brand-image img-circle elevation-3"
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
  <section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <a href="{{ url('/hutang-admin') }}" class="btn btn-outline-dark float-right"
                style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; padding: 0; border: 2px solid black; background-color: transparent;">
                <i class="fas fa-arrow-left" style="font-size: 20px; color: black;"></i>
            </a>
            <div class="col-sm-6">
                <h1>List Rekap <label> {{ $history->isNotEmpty() ? $history[0]->name : 'N/A' }} </label></h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID Hutang</th>
                                    <th>Tanggal Hutang</th>
                                    <th>Tanggal Cicilan</th>
                                    <th>Tanggal Lunas</th>
                                    <th>Bon</th>
                                    <th>Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($history as $item)
                                    <tr>
                                        <td>{{ $item->id_hutang }}</td>
                            
                                        <!-- Check if tanggal_lunas is not null before formatting -->
                                        <td>
                                            @if ($item->tanggal_hutang)
                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal_hutang)->format('d F Y') }}
                                            @else
                                                <em>-</em>
                                            @endif
                                        </td>
                                        
                                        <!-- Check if tanggal_cicilan is not null before formatting -->
                                        <td>
                                            @if ($item->tanggal_cicilan)
                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal_cicilan)->format('d F Y') }}
                                            @else
                                                <em>-</em>
                                            @endif
                                        </td>
                                        
                                        <!-- Repeat the check for tanggal_lunas for display as a strong tag -->
                                        <td><strong>
                                            @if ($item->tanggal_lunas)
                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', $item->tanggal_lunas)->format('d F Y') }}
                                            @else
                                                <em>-</em>
                                            @endif
                                        </strong></td>
                                        
                            
                                        <!-- Format bon -->
                                        <td>{{ 'Rp. ' . number_format($item->bon, 0, ',', '.') }}</td>
                            
                                        <td>
                                            <a href="" class="btn btn-success">
                                                <i class="fa fa-print"></i>
                                            </a>
                                        </td>
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
        <!-- /.row -->
    </div>
</div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
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
