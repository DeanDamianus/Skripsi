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
                                    <a href='{{ url('/owner?tahun=' . $selectedYear) }}' class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Global</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a a
                                        href='{{ url('/dashboardindividual?years=' . $selectedYear) }}'class="nav-link">
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
                        <div class="small-box bg-success">
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
                            <a href="{{ url('/distribusi') }}" class="small-box-footer">
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
                    <div class="col-lg-12">
                        <div class="card card-success">
                            <div class="card-header" style="background-color: #dda446">
                                <h3 class="card-title">Perbandingan Keranjang</h3>
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
                                    <canvas id="barChartkeranjang"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card card-info">
                            <div class="card-header" style="background-color: #dda446">
                                <h3 class="card-title">Total Hasil Bersih + Hutang</h3>

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
                                    <canvas id="stackedBarChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header" style="background-color: #dda446">
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
                                <h3 class="card-title">Perbandingan Jual Luar</h3>

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

                    </div> --}}
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header" style="background-color: #dda446">
                                <h3 class="card-title">Status Distribusi Nota</h3>
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
    <script>
        //grade
        $(function() {
            var jualluar = {{ $jualLuar }};
            var jualdalam = {{ $jualDalam }};
            var pieData = {
                labels: [
                    'Jual GG',
                    'Jual Luar',
                ],
                datasets: [{
                    data: [jualdalam, jualluar],
                    backgroundColor: ['#00a65a', '#f56954']
                }]
            }
            var pieChartCanvas = $('#pieChartjualluar').get(0).getContext('2d')
            var pieData = pieData;
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
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
        var label = @json($labelPeriode);
        var totalKeranjang = @json($totalKeranjang);
        var sisakeranjang = @json($sisaKeranjangGrouped);
        var areaChartData = {
            labels: label,
            datasets: [{
                    label: 'Diterima',
                    backgroundColor: 'rgb(111,66,193)', // Purple background color
                    borderColor: 'rgb(111,66,193)', // Purple border color
                    pointRadius: false,
                    pointColor: '#6f42c1', // Dark purple point color
                    pointStrokeColor: 'rgb(111,66,193)', // Purple point stroke color
                    pointHighlightFill: '#fff', // Highlight fill color (white)
                    pointHighlightStroke: 'rgb(111,66,193)',
                    data: totalKeranjang 
                },
                {
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
            datasetFill: false
        }

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })
    </script>
    {{-- <script>
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
    </script> --}}
    <script>
        var labels = @json($petani);
        var dataOmset = @json($dataomset);
        var sisahutang = @json($sisahutangpetani);
        var barChartData = {
            labels: labels,
            datasets: [{
                    label: 'Omset',
                    backgroundColor: 'rgba(76, 175, 80, 0.9)', // Green background color
                    borderColor: 'rgba(76, 175, 80, 0.8)', // Green border color
                    pointRadius: false,
                    pointColor: '#4caf50', // Green point color
                    pointStrokeColor: 'rgba(76, 175, 80, 1)', // Green point stroke color
                    pointHighlightFill: '#fff', // Highlight fill color (white)
                    pointHighlightStroke: 'rgba(76, 175, 80, 1)', // Green point highlight stroke
                    data: dataOmset
                },
                {
                    label: 'Hutang',
                    backgroundColor: 'rgba(244, 67, 54, 0.9)', // Red background color
                    borderColor: 'rgba(244, 67, 54, 0.8)', // Red border color
                    pointRadius: false,
                    pointColor: '#f44336', // Red point color
                    pointStrokeColor: 'rgba(244, 67, 54, 1)', // Red point stroke color
                    pointHighlightFill: '#fff', // Highlight fill color (white)
                    pointHighlightStroke: 'rgba(244, 67, 54, 1)', // Red point highlight stroke
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
        //grade
        $(function() {
            var gradeA = {{ $gradeA }};
            var gradeB = {{ $gradeB }};
            var gradeC = {{ $gradeC }};
            var gradeD = {{ $gradeD }};
            var pieData = {
                labels: [
                    'D',
                    'C',
                    'B',
                    'A',
                ],
                datasets: [{
                    data: [gradeD, gradeC, gradeB, gradeA],
                    backgroundColor: ['#00a65a', '#f56954', '#f39c12', '#00c0ef', ]
                }]
            }
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
            var pieData = pieData;
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
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
        });
    </script>


</body>

</html>

</body>

</html>
