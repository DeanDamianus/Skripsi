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
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="" class="nav-link">Home</a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <li class="nav-item d-none d-sm-inline-block">
                    <div class="dropdown">
                        <button class="nav-link" type="button" data-toggle="dropdown" style="border: black;">
                            {{ $selectedYear }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            @foreach ($musim as $season)
                                <div class="dropdown-divider"></div>
                                <a href="{{ url('/owner?tahun=' . $season->tahun) }}" class="dropdown-item">
                                    <i class="fas fa-calendar"></i> {{ $season->tahun }}
                                </a>
                            @endforeach
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
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="dist/img/simbakologo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">SIMBAKO</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
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


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    <strong>DASHBOARD</strong>
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href='{{ url('/owner?tahun=' . $selectedYear) }}' class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Global</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a a href='{{ url('/dashboardindividual?year=' . $selectedYear) }}'class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Individual</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item menu-close">
                            <a href="{{ url('/input?year=' . $selectedYear) }}" class="nav-link">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    <strong>INPUT NOTA</strong>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item menu-close">
                            <a href="{{ url('/hutang-admin?year=' . $selectedYear) }}" class="nav-link">
                                <i class="nav-icon fas fa-hand-holding-usd"></i>
                                <p>
                                    <strong>HUTANG</strong>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item menu-close">
                            <a href="{{ url('/distribusi?year=' . $selectedYear) }}" class="nav-link">
                                <i class="nav-icon fas fa-truck"></i>
                                <p>
                                    <strong>DISTRIBUSI</strong>
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
                                    <a href="{{ url('/datapetani?year=' . $selectedYear) }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Petani</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a a href="{{ url('/register?year=' . $selectedYear) }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tambah Petani</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item menu-close">
                            <a href="{{ url('/parameter?tahun=' . $selectedYear) }}" class="nav-link">
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

            <!-- /.sidebar -->
        </aside>


        <div class="content-wrapper">
            <div class="content">
                <div class="content-header">
                </div>
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalNetto }} Kg</sup></h3>
                                <p>Total Netto Keranjang</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-weight-hanging"></i>
                            </div>
                            <a href="{{ url('/input?year=' . $selectedYear) }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>

                    </div>
                    <!--NETO-->
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><sup
                                        style="font-size: 20px">Rp.</sup>{{ number_format($totalHarga, 0, ',', '.') }}
                                </h3>
                                <p>Total Harga Keranjang</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-coins"></i> <!-- Ikon koin -->
                            </div>
                            <a href="{{ url('/input?year=' . $selectedYear) }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Jumlah Kotor-->
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-purple">
                            <div class="inner">
                                <h3>{{ $rekapcount }}<sup style="font-size: 20px"> Keranjang</sup></h3>
                                <p>Total Keranjang</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-basket"></i><!-- Basket icon -->
                            </div>
                            <a href="{{ url('/input') }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Jumlah Bersih -->
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $jumlahPetani }}</h3>
                                <p>Jumlah Petani</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user"></i> <!-- Ikon orang -->
                            </div>
                            <a href="{{ url('/datapetani?year=' . $selectedYear) }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Tren Harga Keranjang Per-Periode</h3>

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
                                <div class="chart">
                                    <canvas id="lineChart"
                                        style="min-height: 250px; height: 250px; max-height: 300px; width: 100%; max-width: 1200px;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                              <h3 class="card-title">Grade Tembakau</h3>
              
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
                        <!-- /.card -->


                        <!-- /.card -->
                    </div>
                    <div class="col-6 lg-1">

                        <div class="card card-info">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <p class="card-title">Harga Keranjang yang Diterima</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <p class="d-flex flex-column">
                                        <span
                                            class="text-bold text-lg">{{ 'Rp. ' . number_format($hargaditerima, 0, ',', '.') }}</span>
                                    </p>
                                </div>
                                <!-- /.d-flex -->
                                <div class="position-relative mb-1">
                                    <canvas id="sales-charts" height="160"></canvas>
                                </div>
                                <div class="d-flex justify-content-center mt-1">
                                    <p class="text-bold">Periode</p>
                                </div>

                                <div class="d-flex flex-row justify-content-end">
                                    <span class="mr-2">
                                        <i class="fas fa-square text-primary"></i> Nota A
                                    </span>

                                    <span>
                                        <i class="fas fa-square text-gray"></i> Nota B
                                    </span>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Distribusi Nota A</h3>
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
                                <canvas id="donutChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!--nota A -->
                    </div>
                    <div class="col-md-6">
                        <!-- Nota B -->
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Distribusi Nota B</h3>
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
                                <canvas id="donutChart2"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.2.0
        </div>
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">SIMBAKO</strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Add Content Here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="dist/js/adminlte.js"></script>
    <!-- FLOT CHARTS -->
    <script src="plugins/flot/jquery.flot.js"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="plugins/flot/plugins/jquery.flot.resize.js"></script>
    <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
    <script src="plugins/flot/plugins/jquery.flot.pie.js"></script>
    <!-- OPTIONAL SCRIPTS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/pages/dashboard2.js"></script>
    <script>
        $(function() {

            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }

            var mode = 'index'
            var intersect = true
            //data periode untuk total jumla harga
            var periode1 = {{ $periode1 }}
            var periode1b = {{ $periode1b }};
            var periode2a = {{ $periode2a }};
            var periode2b = {{ $periode2b }};
            var periode3a = {{ $periode3a }};
            var periode3b = {{ $periode3b }};
            var periode4a = {{ $periode4a }};
            var periode4b = {{ $periode4b }};
            var periode5a = {{ $periode5a }};
            var periode5b = {{ $periode5b }};
            var periode6a = {{ $periode6a }};
            var periode6b = {{ $periode6b }};
            var periode7a = {{ $periode7a }};
            var periode7b = {{ $periode7b }};
            var periode8a = {{ $periode8a }};
            var periode8b = {{ $periode8b }};
            var periode9a = {{ $periode9a }};
            var periode9b = {{ $periode9b }};
            var periode10a = {{ $periode10a }};
            var periode10b = {{ $periode10b }};
            var periode11a = {{ $periode11a }};
            var periode11b = {{ $periode11b }};
            var periode12a = {{ $periode12a }};
            var periode12b = {{ $periode12b }};



            var $salesChart = $('#sales-charts')
            // eslint-disable-next-line no-unused-vars
            var salesChart = new Chart($salesChart, {
                type: 'bar',
                data: {
                    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                    datasets: [{
                            backgroundColor: '#007bff',
                            borderColor: '#007bff',
                            data: [periode1, periode2a, periode3a, periode4a, periode5a, periode6a,
                                periode7a, periode8a, periode9a, periode10a, periode11a, periode12a
                            ]
                        },
                        {
                            backgroundColor: '#ced4da',
                            borderColor: '#ced4da',
                            data: [periode1b, periode2b, periode3b, periode4b, periode5b, periode6b,
                                periode7b, periode8b, periode9b, periode10b, periode11b, periode12b
                            ]

                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            // display: false,
                            gridLines: {
                                display: true,
                                lineWidth: '2px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({
                                beginAtZero: true,
                                callback: function(value) {
                                    return 'Rp. ' + value.toLocaleString('id-ID', {
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 0
                                    });
                                }
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: true
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            })
        })
    </script>
    <script>
        $(function() {
            var harga1a = {{ $harga1_A }};
            var harga1b = {{ $harga1_B }};
            var harga2a = {{ $harga2_A }};
            var harga2b = {{ $harga2_B }};
            var harga3a = {{ $harga3_A }};
            var harga3b = {{ $harga3_B }};
            var harga4a = {{ $harga4_A }};
            var harga4b = {{ $harga4_B }};
            var harga5a = {{ $harga5_A }};
            var harga5b = {{ $harga5_B }};
            var harga6a = {{ $harga6_A }};
            var harga6b = {{ $harga6_B }};
            var harga7a = {{ $harga7_A }};
            var harga7b = {{ $harga7_B }};
            var harga8a = {{ $harga8_A }};
            var harga8b = {{ $harga8_B }};
            var harga9a = {{ $harga9_A }};
            var harga9b = {{ $harga9_B }};
            var harga10a = {{ $harga10_A }};
            var harga10b = {{ $harga10_B }};
            var harga11a = {{ $harga11_A }};
            var harga11b = {{ $harga11_B }};
            var harga12a = {{ $harga12_A }};
            var harga12b = {{ $harga12_B }};

            // Formatter for Rupiah
            var rupiahFormatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            });

            // Line chart data
            var lineChartData = {
                labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                datasets: [{
                        label: 'Nota A',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [harga1a, harga2a, harga3a, harga4a, harga5a, harga6a, harga7a, harga8a,
                            harga9a, harga10a, harga11a, harga12a
                        ]
                    },
                    {
                        label: 'Nota B',
                        backgroundColor: '#ced4da',
                        borderColor: '#ced4da',
                        pointRadius: false,
                        pointColor: '#ced4da',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: [harga1b, harga2b, harga3b, harga4b, harga5b, harga6b, harga7b, harga8b,
                            harga9b, harga10b, harga11b, harga12b
                        ]
                    },
                ]
            };

            // Disable fill for the datasets
            lineChartData.datasets[0].fill = false;
            lineChartData.datasets[1].fill = false;

            // Chart options
            var lineChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: true
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': ' + rupiahFormatter.format(tooltipItem.yLabel);
                        }
                    }
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: true,
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            callback: function(value) {
                                return rupiahFormatter.format(value);
                            }
                        },
                        gridLines: {
                            display: true,
                        }
                    }]
                }
            };

            // Ensure no dataset fill
            lineChartOptions.datasetFill = false;

            // Create the line chart
            var lineChartCanvas = $('#lineChart').get(0).getContext('2d');
            var lineChart = new Chart(lineChartCanvas, {
                type: 'line',
                data: lineChartData,
                options: lineChartOptions
            });
        });
    </script>
    <script>
        //grade
        $(function() {
            var gradeA = {{ $gradeA }};
            var gradeB = {{ $gradeB }};
            var gradeC = {{ $gradeC }};
            var gradeD = {{ $gradeD }};
            var pieData        = {
            labels: [
                'D',
                'C',
                'B',
                'A',
            ],
            datasets: [
                {
                data: [gradeD,gradeC,gradeB,gradeA],
                backgroundColor : [  '#00a65a','#f56954','#f39c12','#00c0ef',]
                }
            ]
            }
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
            var pieData        = pieData;
            var pieOptions     = {
            maintainAspectRatio : false,
            responsive : true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Create the first donut chart
            var ctxDonutA = $('#donutChart').get(0).getContext('2d');

            // Use Blade to pass the PHP variable to JavaScript
            var diterima = {{ $diterima }};
            var diproses = {{ $diproses }};
            var ditolak = {{ $ditolak }};
            var belumproses = {{ $belumproses }};

            // Prepare the data for the chart
            var donutDataA = {
                labels: ['Diterima', 'Diproses', 'Ditolak', 'Belum Diproses'],
                datasets: [{
                    data: [diterima, diproses, ditolak, belumproses],
                    backgroundColor: ['#00a65a', '#ffeb3b', '#dc3545', '#00c0ef'],
                }]
            };

            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            };

            // Create the first doughnut chart
            new Chart(ctxDonutA, {
                type: 'doughnut',
                data: donutDataA,
                options: donutOptions
            });

            // Create the second donut chart
            var ctxDonutB = $('#donutChart2').get(0).getContext('2d');

            // Use Blade to pass the PHP variable to JavaScript
            var diterimaB = {{ $diterima_B }};
            var diprosesB = {{ $diproses_B }};
            var ditolakB = {{ $ditolak_B }};
            var belumprosesB = {{ $belumproses_B }};

            // Prepare the data for the second chart
            var donutDataB = {
                labels: ['Diterima', 'Diproses', 'Ditolak', 'Belum Diproses'],
                datasets: [{
                    data: [diterimaB, diprosesB, ditolakB, belumprosesB],
                    backgroundColor: ['#00a65a', '#ffeb3b', '#dc3545', '#00c0ef'],
                }]
            };

            // Create the second doughnut chart
            new Chart(ctxDonutB, {
                type: 'doughnut',
                data: donutDataB,
                options: donutOptions
            });
        });
    </script>


</body>

</html>

</body>

</html>
