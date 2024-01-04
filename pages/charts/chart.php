<?php include("header.php")?>
<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'kds' );
    if (!$conn) {
        echo "bağlantı başarısız: " . mysqli_connect_error();
    } else {
        echo "bağlandı";
    }
?>
    <!-- Filtreleme seçenekleri -->
  <div>
    <label for="filterCategory">Kategoriye Göre Filtrele:</label>
    <select id="filterCategory" onchange="applyFilters()">
      <option value="all">Hepsi</option>
      <option value="1">Soft Drinks</option>
      <option value="2">Sıcak İçecekler</option>
      <option value="3">Alkollü İçecekler</option>

     
      <!-- Diğer kategori seçenekleri -->
    </select>
    <label for="filterDate">Yıla Göre Filtrele:</label>
    <select id="filterDate"  onchange="applyFilters()">
    <option value="all">Hepsi</option>
    <option value="today">2023</option>
    <option value="thisWeek">2022</option>
      <!-- Diğer tarih seçenekleri -->
    </select>
  </div>


  <!-- ChartJS ve filtreleme için JavaScript
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    function applyFilters() {
      const selectedCategory = document.getElementById('filterCategory').value;
      const selectedDate = document.getElementById('filterDate').value;

      // Sunucudan veri çekme
      fetch(`/api/data?category=${selectedCategory}&date=${selectedDate}`)
        .then(response => response.json())
        .then(data => {
          // Verileri kullanarak grafikleri güncelleme
          updateCharts(data);
        })
        .catch(error => console.error('Veri çekme hatası:', error));
    }

    document.addEventListener('DOMContentLoaded', function () {
      // Sayfa yüklendiğinde varsayılan filtreleme uygula
      applyFilters();
    });

    function updateCharts(data) {
      // Veri varsa, burada Chart.js veya başka bir kütüphane ile grafikleri güncelle
      // Örnek olarak Chart.js kullanımı:
      // ...
    }
  </script>  -->

<!-- <body>
  <script>
    // JavaScript kodları buraya gelir
  
    // Filtreleme işlemini gerçekleştiren bir fonksiyon:
    function filterData() {
      var selectedDay = document.getElementById("day").value;
      var selectedMonth = document.getElementById("month").value;
      var selectedYear = document.getElementById("year").value;
  
      // Tüm grafikleri güncelle
      updateCharts(selectedDay, selectedMonth, selectedYear);
    }
  
    // Sayfa yüklendiğinde gün, ay ve yıl seçeneklerini doldur
    document.addEventListener("DOMContentLoaded", function () {
      populateDays();
      // Aynı şekilde ay ve yıl seçeneklerini doldurabilirsiniz.
    });
  
    // Grafiği güncelleyen bir fonksiyon (örnek):
    function updateCharts(selectedDay, selectedMonth, selectedYear) {
      // Burada, veri setlerinizi seçilen tarihe göre güncelleyebilir ve
      // Chart.js veya başka bir grafik kütüphanesi ile grafikleri güncelleyebilirsiniz.
      // Örnek olarak Chart.js kullanıyorsanız, aşağıda bir örnek verilmiştir:
  
      // Örnek veri setleri
      var dataForChart1 = [/* ... */];
      var dataForChart2 = [/* ... */];
  
      // Grafik 1'i güncelle
      updateChart("areaChart", dataForChart1, "Area Chart");
  
      // Grafik 2'yi güncelle
      // updateChart("anotherChart", dataForChart2, "Another Chart");
  
      // İhtiyacınıza göre diğer grafikleri de güncelleyebilirsiniz.
    }
  
    // Grafik güncelleyen genel fonksiyon
    function updateChart(chartId, newData, chartTitle) {
      var chart = new Chart(document.getElementById(chartId).getContext("2d"), {
        type: "line", // Örnek olarak çizgi grafiği kullanılmıştır, ihtiyacınıza göre değiştirebilirsiniz.
        data: {
          labels: [/* ... */], // Etiketler
          datasets: [
            {
              label: chartTitle,
              data: newData,
              fill: false,
              borderColor: "rgb(75, 192, 192)",
              tension: 0.1
            }
          ]
        },
        options: {
          scales: {
            x: {
              type: "time", // Eğer x ekseniniz tarihse bu seçeneği kullanabilirsiniz
              time: {
                unit: "day" // İhtiyacınıza göre ayarlayabilirsiniz (day, month, year, ...)
              }
            },
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }
  </script>
</body>
  
 -->
 
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  
  const database = require('../../database.js');

  
    // Filtreleme işlemini gerçekleştiren bir fonksiyon:
    function filterData() {
      var selectedDate = document.getElementById('filterDate').value;
  
      // Sunucudan veri çekme (bu kısmı kendi veri kaynağınıza uyarlamalısınız)
      fetch(`/api/data?date=${selectedDate}`)
        .then(response => response.json())
        .then(data => {
          // Verileri kullanarak tüm grafikleri güncelleme
          updateAllCharts(data);
        })
        .catch(error => console.error('Veri çekme hatası:', error));
    }
  
    // Tüm grafikleri güncelleyen fonksiyon
    function updateAllCharts(data) {
      updateChart("areaChart", data.areaChartData, "Area Chart");
      updateChart("lineChart", data.lineChartData, "Line Chart");
      updateChart("donutChart", data.donutChartData, "Donut Chart");
      // Diğer grafikleri de aynı şekilde güncelleyebilirsiniz
    }

    function getData(selectedCategory, selectedDate, callback) {
      let query = 'SELECT * FROM urun WHERE 1';
    
      // Kategoriye göre filtreleme
      if (selectedCategory !== 'all') {
        query += ` AND kategori = '${selectedCategory}'`;
      }
    
      // Tarihe göre filtreleme
      if (selectedDate !== 'all') {
        // İhtiyaca göre tarih filtreleme kısmını güncelleyin
        // Örneğin: AND tarih = '2023-12-27'
      }
    
      // Sorguyu çalıştır
      connection.query(query, (error, results, fields) => {
        if (error) {
          console.error('Veri çekme hatası: ' + error.stack);
          callback(error, null);
          return;
        }
    
        // Veritabanından gelen verileri kullanarak istediğiniz işlemleri gerçekleştirin
        callback(null, results);
      });
    }
    
  
    // Tek bir grafik güncelleyen genel fonksiyon
    function updateChart(chartId, newData, chartTitle) {
      var chart = new Chart(document.getElementById(chartId).getContext('2d'), {
        type: 'line', // Grafik türünü istediğiniz gibi değiştirebilirsiniz
        data: {
          labels: newData.labels,
          datasets: [
            {
              label: chartTitle,
              data: newData.data,
              fill: false,
              borderColor: 'rgb(75, 192, 192)',
              tension: 0.1
            }
          ]
        },
        options: {
          scales: {
            x: {
              type: 'time',
              time: {
                unit: 'day'
              }
            },
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }
  
</script>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Urun Adı', 'Urun Satış Miktarı'],
        <?php 
        $sql = "SELECT * FROM urun ";
        $fire = mysqli_query($conn, $sql);
            while ($result = mysqli_fetch_assoc($fire)) {
            echo "['".$result["urun_ad"]."',".$result["urun_miktar"]."],";}
        ?>
        ]);

        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
    
</script>













    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Area Chart</h3>

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
                  <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            
            <!-- /.card -->

            <!-- DONUT CHART -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Donut Chart</h3>

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
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- PIE CHART -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Pie Chart</h3>

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

          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-6">
            <!-- LINE CHART -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Line Chart</h3>

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
                  <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- BAR CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Bar Chart</h3>

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
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- STACKED BAR CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Stacked Bar Chart</h3>

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
                  <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
    </div>
    <strong>PROF. DR. VAHAP TECİM - KDS PROJESİ İÇİN YAPILMIŞTIR. (ZEYNEP KAYA) &copy; 2023-2024</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Add Content Here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../../plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
    
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
   /*  var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label               : 'Digital Goods',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [28, 48, 40, 19, 86, 27, 90]
        },
        {
          label               : 'Electronics',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 40]
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,
      options: areaChartOptions
    }) */

    //-------------
    //- LINE CHART -
    //--------------
   /*  var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,
      options: lineChartOptions
    }) */

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
        var combinedData = [['Urun Adı', 'Urun Satış Miktarı']];

        <?php
        $sql = "SELECT * FROM urun ";
        $fire = mysqli_query($conn, $sql);
        while ($result = mysqli_fetch_assoc($fire)) {
            echo "combinedData.push(['" . $result["urun_ad"] . "'," . $result["urun_miktar"] . "]);";
        }
        ?>
        var donutData = google.visualization.arrayToDataTable(combinedData);


        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(donutData, options);
      }

    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Chrome',
          'IE',
          'FireFox',
          'Safari',
          'Opera',
          'Navigator',
      ],
      datasets: [
        {
          data: [700,500,400,600,300,100],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
 /*    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
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
    }) 
   */
    //-------------
    //- BAR CHART -
    //-------------
  /*   var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    }) */

    //---------------------
    //- STACKED BAR CHART -
    //---------------------
   /*  var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = $.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    new Chart(stackedBarChartCanvas, {
      type: 'bar',
      data: stackedBarChartData,
      options: stackedBarChartOptions
    }) */
  })

</script>