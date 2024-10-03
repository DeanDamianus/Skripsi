/* global Chart:false */

$(function () {

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
      labels: ['SARIDI', 'RIYANTO', 'TURMUDI', 'TUMAR', 'PERLU', 'MURAT', 'ROHMADI', 'CAMPUR',
      'TOFIK', 'SURAH', 'SIAMIN', 'AGUNG', 'MADYO', 'WALYONO', 'PAWIT', 'ZU', 'BIMA', 'MISGINI'],
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor: '#007bff',
          data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
        },
        {
          backgroundColor: '#ced4da',
          borderColor: '#ced4da',
          data: [1000, 2000, 3000, 2500, 2700, 2500, 3000]
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
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }

              return '$' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })

  var $salesChart2 = $('#sales-chart2')
  var salesChart = new Chart($salesChart2, {
    type: 'bar',
    data: {
      labels: ['SARIDI', 'RIYANTO', 'TURMUDI', 'TUMAR', 'PERLU', 'MURAT', 'ROHMADI', 'CAMPUR',
      'TOFIK', 'SURAH', 'SIAMIN', 'AGUNG', 'MADYO', 'WALYONO', 'PAWIT', 'ZU', 'BIMA', 'MISGINI'],
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor: '#007bff',
          data:[1000, 2000, 3000, 2500, 2700, 2500, 3000]
        },
        {
          backgroundColor: '#ced4da',
          borderColor: '#ced4da',
          data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
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
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }

              return '$' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })

  var $gradeTembakau = $('#grade-tembakau')
  var gradeTembakau = new Chart($salesChart2, {
    type: 'bar',
    data: {
      labels: ['SARIDI', 'RIYANTO', 'TURMUDI', 'TUMAR', 'PERLU', 'MURAT', 'ROHMADI', 'CAMPUR',
      'TOFIK', 'SURAH', 'SIAMIN', 'AGUNG', 'MADYO', 'WALYONO', 'PAWIT', 'ZU', 'BIMA', 'MISGINI'],
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor: '#007bff',
          data:[1000, 2000, 3000, 2500, 2700, 2500, 3000]
        },
        {
          backgroundColor: '#ced4da',
          borderColor: '#ced4da',
          data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
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
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }

              return '$' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
  

  var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = {
      labels: [
          'A',
          'B',
          'C',
          'D',
      ],
      datasets: [
        {
          data: [0,0,2,64],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

  
 
})

// lgtm [js/unused-local-variable]h
