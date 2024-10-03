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
                    <a href="{{ url('/dashboardindividual?year=' . $selectedYear) }}"
                        class="btn btn-outline-dark float-right"
                        style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; padding: 0; border: 2px solid black; background-color: transparent;">
                        <i class="fas fa-arrow-left" style="font-size: 20px; color: black;"></i>
                    </a>
                    <div class="col-sm-6">
                        <h1>Dashboard <label> {{ $username }} </label></h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fa fa-coins"></i></span>
          
                        <div class="info-box-content">
                          <span class="info-box-text">Omset</span>
                          <span class="info-box-number">{{ 'Rp. ' . number_format($totalbersih, 0, ',', '.')}}</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-hand-holding-usd"></i></span>
          
                        <div class="info-box-content">
                          <span class="info-box-text">Hutang</span>
                          <span class="info-box-number">{{ 'Rp. ' . number_format($remainingHutang, 0, ',', '.')}}</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-dollar-sign"></i></span>
          
                        <div class="info-box-content">
                          <span class="info-box-text">Hasil Bersih</span>
                          <span class="info-box-number">{{ 'Rp. '. number_format($totalbersih - $remainingHutang, 0,',','.' )}}</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                      <div class="info-box">
                        <span class="info-box-icon bg-purple"><i class="fas fa-leaf"></i></span>
          
                        <div class="info-box-content">
                          <span class="info-box-text">Total Keranjang</span>
                          <span class="info-box-number">{{ $rekap }}</span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                  </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-success">
                            <div class="card-header">
                              <h3 class="card-title">Hutang</h3>
              
                              <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                  <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                  <i class="fas fa-times"></i>
                                </button>
                              </div>
                            </div>
                            <div class="card-body">
                              <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                          </div>
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
    <script src="../../plugins/chart.js/Chart.min.js"></script>
</body>
<script>
    $(function () {
        // Get the remaining hutang passed from the controller
        var remainingHutang = {{ $remainingHutang ?? 0 }};
        var jumlahbersih = {{ $totalbersih ?? 0 }};

        var donutData = {
            labels: [
                'Hutang',
                'Omset',
            ],
            datasets: [
                {
                    data: [remainingHutang, jumlahbersih],
                    backgroundColor: ['#dc3545', '#17a2b8'],
                }
            ]
        };

        var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
        var pieData = donutData;
        var pieOptions = {
            maintainAspectRatio: false,
            responsive: true,
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        // Get the value of the data
                        var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];

                        // Format the value as currency (Rupiah)
                        return 'Rp. ' + value.toLocaleString('id-ID');
                    }
                }
            }
        };

        // Create pie chart
        new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
        });
    });
</script>
  

</html>
