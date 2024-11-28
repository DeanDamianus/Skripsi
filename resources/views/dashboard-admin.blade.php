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
                                <h3>{{ $totalNetto }} Kg</h3>
                                <p>Netto Keranjang diterima</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-weight-hanging"></i>
                            </div>
                            <a class="small-box-footer">
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
                            <a class="small-box-footer">
                            </a>
                        </div>
                    </div>
                    <!-- Jumlah Kotor -->
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-purple">
                            <div class="inner">
                                <h3>{{ $rekapcount }}<sup style="font-size: 20px"> Keranjang</sup></h3>
                                <p>Keranjang Terjual</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-basket"></i><!-- Basket icon -->
                            </div>
                            <a class="small-box-footer">
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
                            <a class="small-box-footer">
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
                                <h3 class="card-title">Tipe Penjualan {{ $selectedYear }}</h3>
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
                                <h3 class="card-title">Status Distribusi Pengiriman Keranjang {{ $selectedYear }}</h3>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.js"></script>




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
                    label: 'Terjual',
                    backgroundColor: 'rgb(111,66,193)',
                    borderColor: 'rgb(111,66,193)',
                    data: totalKeranjang,
                    stack: 'stack0', // Define stack group// Define stack group
                },
                {
                    label: 'Sisa',
                    backgroundColor: 'rgb(220,53,69)',
                    borderColor: 'rgb(220,53,69)',
                    data: sisakeranjang,
                    stack: 'stack0', // Define stack group
                },
            ]
        };

        var barChartCanvas = $('#barChartkeranjang').get(0).getContext('2d');
        var barChartData = $.extend(true, {}, areaChartData);

        // Bar chart options to make it stacked
        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: true, // Make x-axis stacked
                    scaleLabel: {
                        display: true,
                        labelString: 'Periode',
                        fontSize: 15
                    }
                },
                y: {
                    stacked: true, // Make y-axis stacked
                    scaleLabel: {
                        display: true,
                        labelString: 'Keranjang',
                    },
                    ticks: {
                        beginAtZero: true,
                    }
                }
            },
        };

        // Initialize the stacked bar chart
        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });
    </script>


    <script>
        var labels = @json($petani);
        var databersih = @json($databersih);
        var sisahutang = @json($sisahutangpetani);

        var barChartData = {
            labels: labels,
            datasets: [{
                    label: 'Hasil Bersih',
                    backgroundColor: 'rgb(40,167,69)',
                    borderColor: 'rgb(40,167,69)',
                    data: databersih,
                    stack: 'stack0',
                },
                {
                    label: 'Hutang',
                    backgroundColor: 'rgb(220,53,69)',
                    borderColor: 'rgb(220,53,69)',
                    data: sisahutang,
                    stack: 'stack0',
                },
            ]
        };

        var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d');

        var stackedBarChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: true, // Stacked x-axis
                    scaleLabel: {
                        display: true,
                        labelString: 'Petani',
                        fontSize: 15
                    }
                },
                y: {
                    stacked: true, // Stacked y-axis
                    ticks: {
                        callback: function(value) {
                            // Format the value as Rupiah
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
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
                        }).format(tooltipItem.raw); // Use tooltipItem.raw instead of tooltipItem.yLabel
                        return label;
                    }
                }
            }
        };

        // Create the stacked bar chart
        new Chart(stackedBarChartCanvas, {
            type: 'bar',
            data: barChartData,
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
                    backgroundColor: ['#28A745', '#17A2B8', '#FFC107', '#DC3545']
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
        var salesGraphChartCanvas = document.getElementById('line-chart').getContext('2d');
        var label = @json($labelmusim);
        var nettomusim = @json($nettomusim);

        var salesGraphChartData = {
            labels: label,
            datasets: [{
                label: '', // Empty label to hide it
                fill: true,
                borderWidth: 2,
                lineTension: 0.3,
                spanGaps: true,
                borderColor: '#ffffff',
                backgroundColor: 'rgba(255, 255, 255, 0.2)',
                pointRadius: 3,
                pointHoverRadius: 7,
                pointBackgroundColor: '#ffffff',
                data: nettomusim
            }]
        };

        var salesGraphChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    display: false // Hide the legend
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            // Only show the value without any label
                            return context.parsed.y + ' kg';
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tahun',
                        color: '#ffffff', // White label
                        font: {
                            size: 15
                        }
                    },
                    ticks: {
                        color: '#ffffff' // White ticks
                    },
                    grid: {
                        display: false
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Netto (kg)',
                        color: '#ffffff'
                    },
                    ticks: {
                        stepSize: 100,
                        color: '#ffffff', // White ticks
                        callback: function(value) {
                            return value + ' kg'; // Add "kg" to labels
                        }
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.2)', // Faint white gridlines
                        drawBorder: false
                    }
                }
            }
        };

        new Chart(salesGraphChartCanvas, {
            type: 'line',
            data: salesGraphChartData,
            options: salesGraphChartOptions
        });
    </script>


    <script>
        var salesGraphChartCanvas = document.getElementById('line-chart-bersih').getContext('2d');
        var label = @json($labelOmset);
        var omsettiapTahun = @json($omsettiapTahun);

        var salesGraphChartData = {
            labels: label,
            datasets: [{
                label: 'Omset',
                fill: true,
                borderWidth: 2,
                lineTension: 0.3, // Smooth curve
                spanGaps: true,
                borderColor: '#efefef', // Light gray line
                backgroundColor: 'rgba(239, 239, 239, 0.2)', // Transparent gray fill
                pointRadius: 3,
                pointHoverRadius: 7,
                pointBackgroundColor: '#efefef', // Gray points
                data: omsettiapTahun
            }]
        };

        var salesGraphChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    display: false // Hide legend
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            // Format the tooltip to display in Rupiah with commas
                            return 'Rp. ' + context.raw.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tahun',
                        color: '#efefef', // Light gray axis label
                        font: {
                            size: 15
                        }
                    },
                    ticks: {
                        color: '#efefef' // Light gray ticks
                    },
                    grid: {
                        display: false // Hide grid lines for x-axis
                    }
                },
                y: {
                    ticks: {
                        stepSize: 5000000, // Step interval for y-axis
                        color: '#efefef', // Light gray ticks
                        callback: function(value) {
                            // Format y-axis labels in Rupiah format
                            return "Rp. " + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    },
                    grid: {
                        color: 'rgba(239, 239, 239, 0.2)', // Faint grid lines
                        drawBorder: false
                    }
                }
            }
        };

        // Initialize the chart
        new Chart(salesGraphChartCanvas, {
            type: 'line',
            data: salesGraphChartData,
            options: salesGraphChartOptions
        });
    </script>



</body>

</html>
