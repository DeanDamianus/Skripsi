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
                            <a href="#" class="nav-link active" style="background-color: #dda446;">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    <strong>DASHBOARD</strong>
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href='{{ url(' /owner?tahun=' . $selectedYear) }}' class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Global</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a a href='{{ url('/dashboardindividual?year=' . $selectedYear) }}'
                                        class="nav-link">
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
                            <a href=f class="nav-link">
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
                                <h3>{{ $totalNetto }} Kg</h3>
                                <p>Netto Keranjang diterima</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-weight-hanging"></i>
                            </div>
                            <a href="{{ url('/input?year=' . $selectedYear) }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Netto -->
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><sup
                                        style="font-size: 20px">Rp.</sup>{{ number_format($totalHarga, 0, ',', '.') }}
                                </h3>
                                <p>Omset diterima</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-coins"></i> <!-- Coin icon -->
                            </div>
                            <a href="{{ url('/input?year=' . $selectedYear) }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Jumlah Kotor -->
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-purple">
                            <div class="inner">
                                <h3>{{ $rekapcount }}<sup style="font-size: 20px"> Keranjang</sup></h3>
                                <p>Keranjang diterima</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-basket"></i><!-- Basket icon -->
                            </div>
                            <a href="{{ url('/distribusi?year=' . $selectedYear) }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Jumlah Bersih -->
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $sisa }}</h3>
                                <p>Keranjang sisa</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <a href="{{ url('/distribusi?year=' . $selectedYear) }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <section class="col-lg-4 connectedSortable">
                        <div class="card bg-gradient-info">
                            <div class="card-header border-0">
                                <i class="fas fa-weight-hanging"></i>
                                Berat Netto Keranjang Diterima Tiap Tahun
                                </h3>
                            </div>
                            <div class="card-body">
                                <canvas class="chart" id="line-chart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </section>
                    <div class="col-lg-8 ">
                        <div class="card card-success">
                            <div class="card-header" style="background-color: #dda446">
                                <h3 class="card-title">Perbandingan Distribusi Keranjang {{ $selectedYear }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="barChartkeranjang"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card card-info">
                            <div class="card-header" style="background-color: #dda446">
                                <h3 class="card-title">Total Bersih + Hutang {{ $selectedYear }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="stackedBarChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <section class="col-lg-4 connectedSortable">
                        <div class="card bg-gradient-success">
                            <div class="card-header border-0">
                                <i class="fas fa-coins"></i>
                                Omset Diterima Tiap Tahun
                                </h3>
                            </div>
                            <div class="card-body">
                                <canvas class="chart" id="line-chart-bersih"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </section>
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header" style="background-color: #dda446">
                                <h3 class="card-title">Grade Tembakau {{ $selectedYear }}</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="pieChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                        <!-- /.card -->
                    </div>
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header" style="background-color: #dda446">
                                <h3 class="card-title">Perbandingan Jual Luar {{ $selectedYear }}</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="pieChartjualluar"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                        <!-- /.card -->
                    </div>
                    {{-- <div class="col-6 lg-1">

                        <div class="card card-info">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <p class="card-title">Harga Keranjang yang Diterima</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <p class="d-flex flex-column">
                                        <span class="text-bold text-lg">{{ 'Rp. ' . number_format($hargaditerima, 0,
                                            ',', '.') }}</span>
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

                    </div> --}}
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header" style="background-color: #dda446">
                                <h3 class="card-title">Status Distribusi {{ $selectedYear }}</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="donutChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!--nota A -->
                    </div>
                    {{-- <div class="col-md-4">
                        <!-- Info Boxes Style 2 -->
                        <div class="info-box mb-3 bg-warning">
                            <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Netto Keranjang Diterima</span>
                                <span class="info-box-number"> {{ $totalNetto }} Kg</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                        <div class="info-box mb-3 bg-success">
                            <span class="info-box-icon"><i class="far fa-heart"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Mentions</span>
                                <span class="info-box-number">92,050</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                        <div class="info-box mb-3 bg-danger">
                            <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Downloads</span>
                                <span class="info-box-number">114,381</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                        <div class="info-box mb-3 bg-info">
                            <span class="info-box-icon"><i class="far fa-comment"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Direct Messages</span>
                                <span class="info-box-number">163,921</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div> --}}
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
        <strong>Copyright &copy; 2014-2021 SIMBAKO</strong> All rights reserved.
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>


    <script>
        $(function() {
            var jualluar = {{ $jualLuar }};
            var jualdalam = {{ $jualDalam }};
            var pieData = {
                labels: [
                    'Jual Gudang Garam',
                    'Jual Luar',
                ],
                datasets: [{
                    data: [jualdalam, jualluar],
                    backgroundColor: ['#00a65a', '#dc3545']
                }]
            };

            var pieChartCanvas = $('#pieChartjualluar').get(0).getContext('2d');
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: false,
                plugins: {
                    datalabels: {
                        color: '#000',
                        formatter: (value, context) => {
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            if (value === 0) {
                                return null; // Do not display label if value is 0
                            }
                            let percentage = ((value / total) * 100).toFixed(1); // Calculate percentage
                            return `${percentage}%)`; // Show percentage and value
                        },
                        font: {
                            weight: 'bold',
                            size: 12, // Slightly increase size for better readability
                            family: 'Arial, sans-serif', // Use a more readable font
                        },
                        align: 'center', // Center the labels inside the slices
                    }
                },
            };

            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions,
                plugins: [ChartDataLabels], // Register the datalabels plugin
            });
        });
    </script>


    <script>
        var label = @json($labelPeriode);
        var totalKeranjang = @json($totalKeranjang);
        var sisakeranjang = @json($sisaKeranjang);
        var areaChartData = {
            labels: label,
            datasets: [{
                    label: 'Sisa',
                    backgroundColor: 'rgb(220,53,69)',
                    borderColor: 'rgb(220,53,69)',
                    pointRadius: false,
                    pointColor: 'rgb(220,53,69)',
                    pointStrokeColor: 'rgb(220,53,69)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgb(220,53,69)',
                    data: sisakeranjang
                },
                {
                    label: 'Diterima',
                    backgroundColor: 'rgb(111,66,193)',
                    borderColor: 'rgb(111,66,193)',
                    pointRadius: false,
                    pointColor: '#6f42c1',
                    pointStrokeColor: 'rgb(111,66,193)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgb(111,66,193)',
                    data: totalKeranjang
                },
            ]
        }
        var barChartCanvas = $('#barChartkeranjang').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        var temp1 = areaChartData.datasets[1]
        barChartData.datasets[0] = temp1
        barChartData.datasets[1] = temp0

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    stacked: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Periode',
                        fontSize: 15
                    }
                }],
                yAxes: [{
                    stacked: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Keranjang'
                    }
                }]
            },
        }
        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })
    </script>


    <script>
        var labels = @json($petani);
        var databersih = @json($databersih);
        var sisahutang = @json($sisahutangpetani);
        var barChartData = {
            labels: labels,
            datasets: [{
                    label: 'Hasil Bersih',
                    backgroundColor: 'rgb(40,167,69)', // Green background color
                    borderColor: 'rgb(40,167,69)', // Green border color
                    pointRadius: false,
                    pointColor: '#28a745', // Green point color
                    pointStrokeColor: 'rgb(40,167,69)', // Green point stroke color
                    pointHighlightFill: '#fff', // Highlight fill color (white)
                    pointHighlightStroke: 'rgb(40,167,69)', // Green point highlight stroke
                    data: databersih
                },
                {
                    label: 'Hutang',
                    backgroundColor: 'rgb(220,53,69)', // Red background color
                    borderColor: 'rgb(220,53,69)', // Red border color
                    pointRadius: false,
                    pointColor: '#dc3545', // Red point color
                    pointStrokeColor: 'rgb(220,53,69)', // Red point stroke color
                    pointHighlightFill: '#fff', // Highlight fill color (white)
                    pointHighlightStroke: 'rgb(220,53,69)', // Red point highlight stroke
                    data: sisahutang // Use different data if necessary
                },
            ]
        }
        var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
        var stackedBarChartData = $.extend(true, {}, barChartData)

        var stackedBarChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    stacked: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Petani',
                        fontSize: 15
                    }
                }],
                yAxes: [{
                    stacked: true,
                    ticks: {
                        callback: function(value) {
                            // Convert the value to Rupiah format
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var label = data.datasets[tooltipItem.datasetIndex].label || '';
                        if (label) {
                            label += ': ';
                        }
                        // Format the value as Indonesian Rupiah (IDR)
                        label += new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(tooltipItem.yLabel);
                        return label;
                    }
                }
            }
        };


        new Chart(stackedBarChartCanvas, {
            type: 'bar',
            data: stackedBarChartData,
            options: stackedBarChartOptions
        });
    </script>

    <script>
        $(function() {
            var gradeA = {{ $gradeA }};
            var gradeB = {{ $gradeB }};
            var gradeC = {{ $gradeC }};
            var gradeD = {{ $gradeD }};
            var pieData = {
                labels: ['D', 'C', 'B', 'A'],
                datasets: [{
                    data: [gradeD, gradeC, gradeB, gradeA],
                    backgroundColor: ['#00a65a', '#ffeb3b', '#dc3545', '#00c0ef'],
                }]
            };

            var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    datalabels: {
                        color: '#000',
                        formatter: (value, context) => {
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            if (value === 0) {
                                return null; // Do not display label if value is 0
                            }
                            let percentage = ((value / total) * 100).toFixed(1); // Calculate percentage
                            return `${percentage}%)`; // Show percentage and value
                        },
                        font: {
                            weight: 'bold',
                            size: 12, // Slightly increase size for better readability
                            family: 'Arial, sans-serif', // Use a more readable font
                        },
                        align: 'center', // Center the labels inside the slices
                    }


                }
            };

            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions,
                plugins: [ChartDataLabels], // Activate the datalabels plugin
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
            plugins: {
                datalabels: {
                    color: '#000', // Font color for readability
                    formatter: (value, context) => {
                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                        let percentage = ((value / total) * 100).toFixed(1); // Calculate percentage
                        if (percentage === "0.0") {
                            return null; // Don't display the label if percentage is 0
                        }
                        return `${percentage}%`; // Show percentage if it's not zero
                    },
                    font: {
                        weight: 'bold',
                        size: 14, // Adjust size based on preference
                        family: 'Arial, sans-serif',
                    },
                    align: 'center', // Center the labels inside the slices
                    offset: 0, // Adjust if labels are too close to the slices
                }
            }
        };

            // Create the first doughnut chart
            new Chart(ctxDonutA, {
                type: 'pie', // Use 'pie' for donut chart as well
                data: donutDataA,
                options: donutOptions,
                plugins: [ChartDataLabels], // Activate the datalabels plugin
            });
        });
    </script>

    <script>
        var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')
        var label = @json($labelmusim);
        var nettomusim = @json($nettomusim);

        var salesGraphChartData = {
            labels: label,
            datasets: [{
                label: 'Netto',
                fill: true,
                borderWidth: 2,
                lineTension: 0,
                spanGaps: true,
                borderColor: '#efefef',
                pointRadius: 3,
                pointHoverRadius: 7,
                pointColor: '#efefef',
                pointBackgroundColor: '#efefef',
                data: nettomusim
            }]
        }

        var salesGraphChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    scaleLabel: { // Place scaleLabel directly under xAxes
                        display: true,
                        labelString: 'Tahun', // The label text you want to display
                        fontColor: '#efefef', // Color of the label text
                        fontSize: 15 // Optional: adjust font size
                    },
                    ticks: {
                        fontColor: '#efefef'
                    },
                    gridLines: {
                        display: false,
                        color: '#efefef',
                        drawBorder: false
                    }
                }],
                yAxes: [{
                    ticks: {
                        stepSize: 100,
                        fontColor: '#efefef',
                        callback: function(value) {
                            return value + ' kg'; // Add kg suffix to each y-axis label
                        }
                    },
                    gridLines: {
                        display: true,
                        color: '#efefef',
                        drawBorder: false

                    }
                }]
            }
        }

        // This will get the first returned node in the jQuery collection.
        // eslint-disable-next-line no-unused-vars
        var salesGraphChart = new Chart(salesGraphChartCanvas, { // lgtm[js/unused-local-variable]
            type: 'line',
            data: salesGraphChartData,
            options: salesGraphChartOptions
        })
    </script>
    <script>
        var salesGraphChartCanvas = $('#line-chart-bersih').get(0).getContext('2d')
        var label = @json($labelOmset);
        var omsettiapTahun = @json($omsettiapTahun);

        var salesGraphChartData = {
            labels: label,
            datasets: [{
                label: 'Rp. ',
                fill: true,
                borderWidth: 2,
                lineTension: 0,
                spanGaps: true,
                borderColor: '#efefef',
                pointRadius: 3,
                pointHoverRadius: 7,
                pointColor: '#efefef',
                pointBackgroundColor: '#efefef',
                data: omsettiapTahun
            }]
        }

        var salesGraphChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    scaleLabel: { // Place scaleLabel directly under xAxes
                        display: true,
                        labelString: 'Tahun', // The label text you want to display
                        fontColor: '#efefef', // Color of the label text
                        fontSize: 15 // Optional: adjust font size
                    },
                    ticks: {
                        fontColor: '#efefef'
                    },
                    gridLines: {
                        display: false,
                        color: '#efefef',
                        drawBorder: false
                    }
                }],
                yAxes: [{
                    ticks: {
                        stepSize: 5000000,
                        fontColor: '#efefef',
                        callback: function(value) {
                            return "Rp. " + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    },
                    gridLines: {
                        display: true,
                        color: '#efefef',
                        drawBorder: false

                    }
                }]
            }
        }

        // This will get the first returned node in the jQuery collection.
        // eslint-disable-next-line no-unused-vars
        var salesGraphChart = new Chart(salesGraphChartCanvas, { // lgtm[js/unused-local-variable]
            type: 'line',
            data: salesGraphChartData,
            options: salesGraphChartOptions
        })
    </script>



</body>

</html>
