<?php

// Establish the connection
$con = mysqli_connect("localhost", "root", "", "simbako_app");

// Check connection
if(!$con){
    die("Koneksi Error: " . mysqli_connect_error());
}

// Query to get hutang_2024 along with the petani's (farmer's) name from the users table
$query = "SELECT hutang_2024.id_hutang, hutang_2024.tanggal_hutang, hutang_2024.bon, hutang_2024.cicilan, hutang_2024.tanggal_lunas, users.name 
       FROM hutang_2024
       JOIN users ON hutang_2024.id_hutang = users.id
       WHERE users.role = 'petani'";


$result = mysqli_query($con, $query);

$nama = "SELECT * FROM users WHERE role = 'petani'";
$resultNama = mysqli_query($con, $nama);

// Fetch users for the dropdown (only petani)
$userQuery = "SELECT id, name FROM users WHERE role = 'petani'";
$userResult = mysqli_query($con, $userQuery);

// Store users in an array
$users = [];
while ($userRow = mysqli_fetch_assoc($userResult)) {
    $users[] = $userRow;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SIMBAKO</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('/owner')}}" class="nav-link">Home</a>
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item d-none d-sm-inline-block">
        <div class="dropdown">
          <button class="nav-link" type="button" data-toggle="dropdown" style=" border: black;">
            2024
          </button>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-calendar"></i> 2025
            </a>
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
    <a href="{{url('/grade')}}" class="brand-link">
      <img src="dist/img/simbakologo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
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
          @if(Auth::check())
              <a href="#" class="d-block">{{ Auth::user()->name }}</a>
          @else
              <a href="#" class="d-block">Guest</a>
          @endif
        </div>
      </div>
      


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item menu-close">
                <a href="{{url('/owner')}}" class="nav-link">
                  <i class="nav-icon fas fa-exchange-alt"></i>
                  <p>
                    <strong>REKAP</strong>
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
              </li>
              <li class="nav-item menu-close">
                <a href="{{url('/parameter')}}" class="nav-link">
                  <i class="nav-icon fas fa-edit"></i>
                  <p>
                    <strong>PARAMETER</strong>
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
              </li>
              <li class="nav-item menu-close">
                <a href="{{url('/hutang-admin')}}" class="nav-link active">
                  <i class="nav-icon fas fa-hand-holding-usd"></i>
                  <p>
                    <strong>HUTANG</strong>
                    <i class="right fas fa-angle-down"></i>
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
                    <a href="{{url('/datapetani')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Petani</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a a href="{{url('/register')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tambah Akun</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('/hapuspetani')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Hapus Akun</p>
                    </a>
                  </li>
                </ul>
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
    <!-- Content Header (Page header) -->

    <!-- /.content-header -->

    <!-- Main content -->
          <!-- /.col-md-6 -->
          <div class="content">
            <div class="content-header">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <h1 class="m-0">List Hutang Petani</h1>
                  </div><!-- /.col -->
                  <div class="col-sm-6">
                  </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </div>
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover text-nowrap">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Nama Petani</th>
                        <th>Tanggal Hutang</th>
                        <th>Bon</th>
                        <th>Cicilan</th>
                        <th>Tanggal Lunas</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      while($row = mysqli_fetch_assoc($result)){
                        $bonFormatted = number_format($row['bon'], 0, ',', '.');
                        $cicilanFormatted = number_format($row['cicilan'], 0, ',', '.');
                          echo "<tr>";
                          echo "<td>" . $row['id_hutang'] . "</td>";
                          echo "<td>".  $row['name']."</td>";
                          echo "<td>" . $row['tanggal_hutang'] . "</td>";
                          echo "<td>Rp. " . $bonFormatted . "</td>";
                          echo "<td>Rp. " . $cicilanFormatted. "</td>";
                          echo "<td>" . $row['tanggal_lunas'] . "</td>";
                          echo "</tr>";
                      }
                      ?>
                    </tbody>
                    
                  </table>
                </div>
                
                <!-- /.card-body -->
              </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Hutang Baru</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nomor ID Petani:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-user"></i></span>
                                    </div>
                                    <select class="form-control">
                                      <option value="" selected disabled>Pilih ID Petani</option>
                                      <?php
                                      foreach ($users as $user) {
                                        echo "<option value='" . $user['id'] . "'>" . $user['id'] . " - " . $user['name'] . "</option>";

                                      }
                                      ?>
                                  </select>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- Date dd/mm/yyyy -->
                            <div class="form-group">
                                <label>Tanggal Hutang:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                        
                            <!-- IP mask -->
                            <div class="form-group">
                                <label>Bon</label>
                  
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="nav-icon fas fa-hand-holding-usd"></i></span>
                                    </div>
                                    <input type="number" class="form-control" data-inputmask="'alias': 'ip'" data-mask>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <form action="#" method="POST" id="quickForm">
                                @csrf
                                <div class="row" style="width: 100%; justify-content: center;">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-danger btn-block">Simpan</button>
                                    </div>
                                </div>
                            </form>
                            <!-- /.form group -->     
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col (left) -->
                <div class="col-md-6">
                  <div class="card card-green">
                    <div class="card-header">
                      <h3 class="card-title">Pelunasan / Cicilan</h3>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label>Tanggal Bayar:</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                          </div>
                          <input type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                        </div>
                        <!-- /.input group -->
                      </div>
                      <!-- /.form group -->
      
                      <!-- Date mm/dd/yyyy -->
                      <div class="form-group">
                        <label>Nomor ID Petani:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-user"></i></span>
                            </div>
                            <select class="form-control">
                                <option value="" selected disabled>Pilih ID Petani</option>
                                <?php
                                foreach ($users as $user) {
                                    echo "<option value='" . $user['id'] . "'>" . $user['id'] . " - " . $user['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <!-- /.input group -->
                    </div>
                    
                      <!-- IP mask -->
                      <div class="form-group">
                        <label>Jumlah Bayar</label>
      
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="nav-icon fas fa-hand-holding-usd"></i></span>
                          </div>
                          <input type="number" class="form-control" data-inputmask="'alias': 'ip'" data-mask>
                        </div>
                        <!-- /.input group -->
                      </div>
                      <form action="#" method="POST" id="quickForm">
                        @csrf

                                    <div class="row" style="width: 100%; justify-content: center;">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success btn-block">Selesai</button>
                                        </div>
                                    </div>
                      </form>
                      <!-- /.form group -->     
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.col (right) -->
              </div>
              <!-- /.card -->
            </div>
            
          </div>
        </div>
            <!-- /.form-group -->
          </div>
        </div>
        <!-- /.row -->
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
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">SIMBAKO</a>.</strong> All rights reserved.
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
<script src="dist/js/pages/dashboard3.js"></script>
<script src="dist/js/pages/dashboard2.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>

<script>
  $(function () {
    /*
     * Flot Interactive Chart
     * -----------------------
     */
    // We use an inline data source in the example, usually data would
    // be fetched from a server
    var data        = [],
        totalPoints = 100

    function getRandomData() {

      if (data.length > 0) {
        data = data.slice(1)
      }

      // Do a random walk
      while (data.length < totalPoints) {

        var prev = data.length > 0 ? data[data.length - 1] : 50,
            y    = prev + Math.random() * 10 - 5

        if (y < 0) {
          y = 0
        } else if (y > 100) {
          y = 100
        }

        data.push(y)
      }

      // Zip the generated y values with the x values
      var res = []
      for (var i = 0; i < data.length; ++i) {
        res.push([i, data[i]])
      }

      return res
    }

    var interactive_plot = $.plot('#interactive', [
        {
          data: getRandomData(),
        }
      ],
      {
        grid: {
          borderColor: '#f3f3f3',
          borderWidth: 1,
          tickColor: '#f3f3f3'
        },
        series: {
          color: '#3c8dbc',
          lines: {
            lineWidth: 2,
            show: true,
            fill: true,
          },
        },
        yaxis: {
          min: 0,
          max: 100,
          show: true
        },
        xaxis: {
          show: true
        }
      }
    )

    var updateInterval = 500 //Fetch data ever x milliseconds
    var realtime       = 'on' //If == to on then fetch data every x seconds. else stop fetching
    function update() {

      interactive_plot.setData([getRandomData()])

      // Since the axes don't change, we don't need to call plot.setupGrid()
      interactive_plot.draw()
      if (realtime === 'on') {
        setTimeout(update, updateInterval)
      }
    }

    //INITIALIZE REALTIME DATA FETCHING
    if (realtime === 'on') {
      update()
    }
    //REALTIME TOGGLE
    $('#realtime .btn').click(function () {
      if ($(this).data('toggle') === 'on') {
        realtime = 'on'
      }
      else {
        realtime = 'off'
      }
      update()
    })

    var sin = [],
        cos = []
    for (var i = 0; i < 14; i += 0.5) {
      sin.push([i, Math.sin(i)])
      cos.push([i, Math.cos(i)])
    }
    var line_data1 = {
      data : sin,
      color: '#3c8dbc'
    }
    var line_data2 = {
      data : cos,
      color: '#00c0ef'
    }
    $.plot('#line-chart', [line_data1, line_data2], {
      grid  : {
        hoverable  : true,
        borderColor: '#f3f3f3',
        borderWidth: 1,
        tickColor  : '#f3f3f3'
      },
      series: {
        shadowSize: 0,
        lines     : {
          show: true
        },
        points    : {
          show: true
        }
      },
      lines : {
        fill : false,
        color: ['#3c8dbc', '#f56954']
      },
      yaxis : {
        show: true
      },
      xaxis : {
        show: true
      }
    })
    //Initialize tooltip on hover
    $('<div class="tooltip-inner" id="line-chart-tooltip"></div>').css({
      position: 'absolute',
      display : 'none',
      opacity : 0.8
    }).appendTo('body')
    $('#line-chart').bind('plothover', function (event, pos, item) {

      if (item) {
        var x = item.datapoint[0].toFixed(2),
            y = item.datapoint[1].toFixed(2)

        $('#line-chart-tooltip').html(item.series.label + ' of ' + x + ' = ' + y)
          .css({
            top : item.pageY + 5,
            left: item.pageX + 5
          })
          .fadeIn(200)
      } else {
        $('#line-chart-tooltip').hide()
      }

    })
    /* END LINE CHART */

    /*
     * FULL WIDTH STATIC AREA CHART
     * -----------------
     */
    var areaData = [[2, 88.0], [3, 93.3], [4, 102.0], [5, 108.5], [6, 115.7], [7, 115.6],
      [8, 124.6], [9, 130.3], [10, 134.3], [11, 141.4], [12, 146.5], [13, 151.7], [14, 159.9],
      [15, 165.4], [16, 167.8], [17, 168.7], [18, 169.5], [19, 168.0]]
    $.plot('#area-chart', [areaData], {
      grid  : {
        borderWidth: 0
      },
      series: {
        shadowSize: 0, // Drawing is faster without shadows
        color     : '#00c0ef',
        lines : {
          fill: true //Converts the line chart to area chart
        },
      },
      yaxis : {
        show: false
      },
      xaxis : {
        show: false
      }
    })


    var bar_data = {
      data : [[1,10], [2,8], [3,4], [4,13], [5,17], [6,9]],
      bars: { show: true }
    }
    $.plot('#bar-chart', [bar_data], {
      grid  : {
        borderWidth: 1,
        borderColor: '#f3f3f3',
        tickColor  : '#f3f3f3'
      },
      series: {
         bars: {
          show: true, barWidth: 0.5, align: 'center',
        },
      },
      colors: ['#3c8dbc'],
      xaxis : {
        ticks: [[1,'January'], [2,'February'], [3,'March'], [4,'April'], [5,'May'], [6,'June']]
      }
    })

    var donutData = [
      {
        label: 'Series2',
        data : 30,
        color: '#3c8dbc'
      },
      {
        label: 'Series3',
        data : 20,
        color: '#0073b7'
      },
      {
        label: 'Series4',
        data : 50,
        color: '#00c0ef'
      }
    ]
    $.plot('#donut-chart', donutData, {
      series: {
        pie: {
          show       : true,
          radius     : 1,
          innerRadius: 0.5,
          label      : {
            show     : true,
            radius   : 2 / 3,
            formatter: labelFormatter,
            threshold: 0.1
          }

        }
      },
      legend: {
        show: false
      }
    })
    /*
     * END DONUT CHART
     */
    

    
  })

  function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
      + label
      + '<br>'
      + Math.round(series.percent) + '%</div>'
  }
      $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Pilih Petani",
            allowClear: true
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>
</html>

</body>
</html>

