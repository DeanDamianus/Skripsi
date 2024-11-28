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
                            <span class="info-box-icon bg-info"><i class="fas fa-weight-hanging"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Netto</span>
                                <span
                                    class="info-box-number">{{ $totalnetto. ' Kg'}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-coins"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Omset</span>
                                <span
                                    class="info-box-number">{{ 'Rp. ' . number_format($sumJumlahKotor, 0, ',', '.') }}</span>
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
                                <span class="info-box-text">Keranjang Terjual</span>
                                <span class="info-box-number">{{ $rekap . ' keranjang' }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="fas fa-box-open"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Keranjang Sisa</span>
                                <span
                                    class="info-box-number">{{ ($dataSisaKeranjang) . ' Keranjang' }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>  
                    <!-- /.col -->
                </div>
                <div class="row">
                    {{-- <div class="col-md-12">
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
                    </div> --}}
                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header" style="background-color: #dda446">
                                <h3 class="card-title">Perbandingan Netto</h3>
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
                        <div class="card card-success">
                            <div class="card-header" style="background-color: #dda446">
                                <h3 class="card-title">Rasio Hasil Bersih dan Hutang</h3>
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
                                    <canvas id="barChartRasio"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-success">
                            <div class="card-header" style="background-color: #dda446">
                                <h3 class="card-title">Status Distribusi Pengiriman Keranjang</h3>

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
                            <div class="card-header" style="background-color: #dda446">
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
                                <canvas id="pieChartgrade"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-info">
                            <div class="card-header" style="background-color: #dda446">
                                <h3 class="card-title">Tipe Penjualan</h3>

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
        $(function() {
            var username = @json($username); 
            var sisahutang = {{ $sisahutang }};
            var totalbersih = {{ $totalbersih }};
            var barChartCanvas = $('#barChartRasio').get(0).getContext('2d');
            
            var areaChartData = {
                labels: [username],
                datasets: [{
                        label: 'Hutang',
                        backgroundColor: 'rgba(220,53,69,1)',
                        borderColor: 'rgba(220,53,69,1)',
                        pointRadius: false,
                        pointColor: 'rgba(220,53,69,1)',
                        pointStrokeColor: 'rgba(220,53,69,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,53,69,1)',
                        data: [sisahutang]
                    },
                    {
                        label: 'Hasil Bersih',
                        backgroundColor: 'rgba(40,167,69,1)',
                        borderColor: 'rgba(40,167,69,1)',
                        pointRadius: false,
                        pointColor: 'rgba(40,167,69,1)',
                        pointStrokeColor: 'rgba(40,167,69,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(40,167,69,1)',
                        data: [totalbersih]
                    },
                ]
            }
    
            var barChartData = $.extend(true, {}, areaChartData);
            var temp0 = areaChartData.datasets[0];
            var temp1 = areaChartData.datasets[1];
            barChartData.datasets[0] = temp1;
            barChartData.datasets[1] = temp0;
    
            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: true,
                datasetFill: true,
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true
                    }
                }
            }
    
            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            });
        });
    </script>
    

    <script>
        $(function() {
            var jualluar = {{ $jualLuar }};
            var jualdalam = {{ $jualDalam }};

            // Data for the pie chart
            var pieData = {
                labels: [
                    'Jual Gudang Garam',
                    'Jual Luar',
                ],
                datasets: [{
                    data: [jualdalam, jualluar],
                    backgroundColor: ['#00a65a', '#f56954']
                }]
            };
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
            // Create the chart
            var pieChartCanvas = $('#pieChartjualluar').get(0).getContext('2d');
            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions,
                plugins: [ChartDataLabels]
            });
        });
    </script>

    <script>
        $(function() {
            // Data variables passed from the backend
            var label = @json($labelPeriode);
            var totalNetto = @json($nettoSum);
            var nettoBelumProses = @json($nettoBelumProses);

            // Chart data configuration
            var stackedBarChartData = {
                labels: label,
                datasets: [{
                        label: 'Diterima',
                        backgroundColor: 'rgba(40,167,69,1)', // Green
                        borderColor: 'rgba(40,167,69,1)',
                        borderWidth: 1,
                        data: totalNetto,
                    },
                    {
                        label: 'Belum Dikirim',
                        backgroundColor: 'rgba(220,53,69,1)', // Red
                        borderColor: 'rgba(220,53,69,1)',
                        borderWidth: 1,
                        data: nettoBelumProses,
                    },
                ],
            };

            // Chart options for a stacked bar chart
            var stackedBarChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: true,
                        title: {
                            display: true,
                            text: 'Periode', // X-axis title
                        },
                    },
                    y: {
                        stacked: true,
                        title: {
                            display: true,
                            text: 'Berat (Kg)', // Y-axis title
                        },
                        ticks: {
                            beginAtZero: true,
                            callback: function(value) {
                                return value + ' Kg'; // Format tick values
                            },
                        },
                    },
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.raw} Kg`;
                            },
                        },
                    },
                },
            };

            // Get the canvas element
            var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d');

            // Create the stacked bar chart
            new Chart(stackedBarChartCanvas, {
                type: 'bar',
                data: stackedBarChartData,
                options: stackedBarChartOptions,
            });
        });
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
            var diterima = {{ $diterima }};
            var diproses = {{ $diproses }};
            var ditolak = {{ $ditolak }};
            var belumproses = {{ $belumproses }};
            var pieData = {
                labels: [
                    'Diterima',
                    'Diproses',
                    'Ditolak',
                    'Belum Diproses'
                ],
                datasets: [{
                    data: [diterima, diproses, ditolak, belumproses],
                    backgroundColor: ['#00a65a', '#ffeb3b', '#dc3545', '#00c0ef'],
                }]
            };
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    datalabels: {
                        color: '#000', // Warna font untuk kemudahan baca
                        formatter: (value) => {
                            if (value === 0) {
                                return null; // Tidak menampilkan label jika nilai 0
                            }
                            return value; // Menampilkan total value
                        },
                        font: {
                            weight: 'bold',
                            size: 14, // Ukuran font
                            family: 'Arial, sans-serif',
                        },
                        align: 'center', // Label ditempatkan di tengah slice
                        offset: 0, // Penyesuaian jika label terlalu dekat dengan slice
                    }
                }
            };

            // Create the chart
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions,
                plugins: [ChartDataLabels]
            });
        });
    </script>
    <script>
        $(function() {
            var remainingHutang = {{ $remainingHutang ?? 0 }};
            var jumlahbersih = {{ $totalbersih ?? 0 }};
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
                    backgroundColor: ['#28A745', '#17A2B8','#FFC107' ,'#DC3545']
                }]
            };
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
            // Create the chart
            var pieChartCanvas = $('#pieChartgrade').get(0).getContext('2d');
            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions,
                plugins: [ChartDataLabels]
            });
        });
    </script>
    <script>
        $(function() {
            var diterima = {{ $diterima }};
            var diproses = {{ $diproses }};
            var ditolak = {{ $ditolak }};
            var belumproses = {{ $belumproses }};
            var pieData = {
                labels: [
                    'Diterima',
                    'Diproses',
                    'Ditolak',
                    'Belum Diproses'
                ],
                datasets: [{
                    data: [diterima, diproses, ditolak, belumproses],
                    backgroundColor: ['#00a65a', '#ffeb3b', '#dc3545', '#00c0ef'],
                }]
            };
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
            // Create the chart
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions,
                plugins: [ChartDataLabels]
            });
        });
    </script>
</body>

</html>
