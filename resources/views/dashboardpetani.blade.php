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
                        <h1><label><img src="{{ $foto ? asset('uploads/' . $foto) : asset('dist/img/blank.png') }}"
                                    alt="user-avatar" class="img-circle img-fluid"
                                    style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                {{ $username }} </label> </h1>
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
                                <span
                                    class="info-box-number">{{ 'Rp. ' . number_format($totalbersih, 0, ',', '.') }}</span>
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
                                <span
                                    class="info-box-number">{{ 'Rp. ' . number_format($sisahutang, 0, ',', '.') }}</span>
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
                                <span
                                    class="info-box-number">{{ 'Rp. ' . number_format($totalbersih - $sisahutang, 0, ',', '.') }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-purple">
                                <i class="fas fa-shopping-basket"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Keranjang</span>
                                <span class="info-box-number">{{ $rekap . ' keranjang' }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Netto</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <p class="d-flex flex-column">
                                        <span class="text-bold text-lg"><strong>{{ $totalnetto }}</strong> Kg</span>
                                        <span>Berdasarkan Grade</span>
                                    </p>
                                </div>
                                <!-- /.d-flex -->

                                <div class="position-relative mb-4">
                                    <canvas id="sales-chart" height="200"></canvas>
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
                                <canvas id="pieChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Grade</h3>

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
                                <canvas id="pieCharthutang"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Total Netto <strong>{{ $totalnetto }}</strong> Kg</h3>

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
                                    <canvas id="barChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>

                    </div> --}}

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
    $(function() {
        var netto_d_a = {{ $netto_d_a }};
        var netto_d_b = {{ $netto_d_b }};
        var netto_c_a = {{ $netto_c_a }};
        var netto_c_b = {{ $netto_c_b }};
        var netto_b_a = {{ $netto_b_a }};
        var netto_b_b = {{ $netto_b_b }};
        var netto_a_a = {{ $netto_a_a }};
        var netto_a_b = {{ $netto_a_b }};

        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        }

        var mode = 'index'
        var intersect = true

        var $salesChart = $('#sales-chart')
        // eslint-disable-next-line no-unused-vars
        var salesChart = new Chart($salesChart, {
            type: 'bar',
            data: {
                labels: ['D', 'C', 'B', 'A'],
                datasets: [{
                        backgroundColor: '#007bff',
                        borderColor: '#007bff',
                        data: [netto_d_a, netto_c_a, netto_b_a, netto_a_a]
                    },
                    {
                        backgroundColor: '#ced4da',
                        borderColor: '#ced4da',
                        data: [netto_d_b, netto_c_b, netto_b_b, netto_a_b]
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
                        display: true,
                        gridLines: {
                            display: true,
                            lineWidth: '4px',
                            color: 'rgba(0, 0, 0, .2)',
                            zeroLineColor: 'transparent'
                        },
                        ticks: $.extend({

                            beginAtZero: true,

                            // Include a dollar sign in the ticks
                            callback: function(value) {
                                return value + ' Kg'; // Add 'Kg' to each tick value
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
        var netto_d_a = {{ $netto_d_a }};
        var netto_d_b = {{ $netto_d_b }};
        var netto_c_a = {{ $netto_c_a }};
        var netto_c_b = {{ $netto_c_b }};
        var netto_b_a = {{ $netto_b_a }};
        var netto_b_b = {{ $netto_b_b }};
        var netto_a_a = {{ $netto_a_a }};
        var netto_a_b = {{ $netto_a_b }};

        var data = {
            labels: ['Grade D', 'Grade C', 'Grade B', 'Grade A'], // Updated labels for clarity
            datasets: [{
                    label: 'Nota A',
                    backgroundColor: 'rgba(60,141,188,0.9)', // Keep a distinct color
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [netto_d_a, netto_c_a, netto_b_a, netto_a_a]
                },
                {
                    label: 'Nota B',
                    backgroundColor: 'rgba(210, 214, 222, 1)',
                    borderColor: 'rgba(210, 214, 222, 1)',
                    pointRadius: false,
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data: [netto_d_b, netto_c_b, netto_b_b, netto_a_b]
                }
            ]
        };

        var barChartCanvas = $('#barChart').get(0).getContext('2d');
        var barChartData = $.extend(true, {}, data);

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Grade' // Add X-axis title
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Kg' // Add Y-axis title
                    },
                    ticks: {
                        callback: function(value) {
                            return value + ' Kg'; // Add 'Kg' to the Y-axis values
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    enabled: true, // Enable tooltips (default is true, but for clarity)
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw +
                                ' Kg'; // Custom tooltip text
                        }
                    }
                }
            },
            datasetFill: false
        };

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });
    });
</script>



<script>
    $(function() {
        // Get the remaining hutang passed from the controller
        var remainingHutang = {{ $sisahutang ?? 0 }};
        var jumlahbersih = {{ $totalbersih ?? 0 }};

        var donutData = {
            labels: [
                'Hutang',
                'Omset',
            ],
            datasets: [{
                data: [remainingHutang, jumlahbersih],
                backgroundColor: ['#dc3545', '#17a2b8'],
            }]
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
<script>
    $(function() {
        //grade
        // Get the remaining hutang passed from the controller
        var remainingHutang = {{ $remainingHutang ?? 0 }};
        var jumlahbersih = {{ $totalbersih ?? 0 }};
        var gradeA = {{ $gradeA }};
        var gradeB = {{ $gradeB }};
        var gradeC = {{ $gradeC }};
        var gradeD = {{ $gradeD }};
        var donutData = {
            labels: [
                'D',
                'C',
                'B',
                'A',
            ],
            datasets: [{
                data: [gradeD, gradeC, gradeB, gradeA],
                backgroundColor: [  '#00a65a','#f56954','#f39c12','#00c0ef',]
            }]
        };

        var pieChartCanvas = $('#pieCharthutang').get(0).getContext('2d');
        var pieData = donutData;
        var pieOptions = {
            maintainAspectRatio: false,
            responsive: true,
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
