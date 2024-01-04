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
            <!-- Line Chart -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Satış Miktarı</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                  <div id="line">
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <script type="text/javascript">
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                            ['Urun Adı', 'Urun Satış Miktarı'],
                            <?php 
                            $sql = "SELECT * FROM urun GROUP BY urun_ad";
                            $fire = mysqli_query($conn, $sql);
                                while ($result = mysqli_fetch_assoc($fire)) {
                                echo "['".$result["urun_ad"]."',".$result["urun_miktar"]."],";}
                            ?>
                            ]);

                            var options = {
                            title: 'Satış Miktar Performansı',
                            
                            hAxis: {
                            title: 'Ürün Adı'
                            },
                            vAxis: {
                            title: 'Satış Miktarı',
                            },
                            curveType: 'function',
                            legend: { position: 'bottom' }
                            };

                            var chart = new google.visualization.LineChart(document.getElementById('line'));

                            chart.draw(data, options);
                        }
                        </script>
                        <body>
                            <div id="line" class="card-body" style="width: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
                        </body>
                    </div>
                  </div>

             <!-- Bar Chart -->
             <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Ürün  Miktarı</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                  <div id="bar">
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <script type="text/javascript"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
                    <?php
                    $conn = new mysqli ('localhost', 'root', '', 'kds');
                    $query= $conn->query("SELECT kategori.kategori_ad, urun.urun_ad AS en_cok_satan_urun,
                    SUM(urun.urun_miktar) AS toplam_satis_miktar
                    FROM kategori JOIN urun ON kategori.kategori_id = urun.kategori_id
                    GROUP BY kategori.kategori_id
                    ORDER BY kategori.kategori_id, toplam_satis_miktar DESC; ");

                    $kategori_ad = array();
                    $en_cok_satan_urun = array();
                    $toplam_satis_miktar = array();

                    foreach ($query as $data) {
                        $kategori_ad[] = $data['kategori_ad'];
                        $en_cok_satan_urun[] = $data['en_cok_satan_urun'];
                        $toplam_satis_miktar[] = $data['toplam_satis_miktar'];
                    }

                    ?>

                    <body>
                    <div style="width: 500px; ">
                      <canvas id="myChart"></canvas>
                    </div>
                    <!--     <div id="drawChart" style="width: 100%; height: 500px;"></div>-->
                    
                    <script>
                    const labels = <?php echo json_encode($kategori_ad)?>;
                    const data = {
                      labels: labels,
                      datasets: [{
                        label: 'Kategoriye Göre En Çok Satılan Ürün Miktarı',
                        data: <?php echo json_encode($toplam_satis_miktar)?>,
                        backgroundColor: [
                          'rgba(255, 99, 132, 0.2)',
                          'rgba(255, 159, 64, 0.2)',
                          'rgba(255, 205, 86, 0.2)',
                          'rgba(75, 192, 192, 0.2)',
                          'rgba(54, 162, 235, 0.2)',
                          'rgba(153, 102, 255, 0.2)',
                          'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                          'rgb(255, 99, 132)',
                          'rgb(255, 159, 64)',
                          'rgb(255, 205, 86)',
                          'rgb(75, 192, 192)',
                          'rgb(54, 162, 235)',
                          'rgb(153, 102, 255)',
                          'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                      }]
                    };

                    const config = {
                      type: 'bar',
                      data: data,
                      options: {
                        scales: {
                          y: {
                            beginAtZero: true
                          }
                        }
                      },
                    };

                        var myChart = new Chart(
                            document.getElementById('myChart'),
                            config
                        );
                    </script>
                    <body>
                    <div id="bar" class="card-body" style="width: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
                    </body>
                  </div>
              </div>
            </div>

             <!-- Pie Chart -->
            <div class="card card-danger">
                <div class="card-header">
                  <h3 class="card-title">Ürün Dağılım Oranı</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                    <div id="pie">
                      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                      <script type="text/javascript">
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {

                          var data = google.visualization.arrayToDataTable([
                            ['Urun Adı', 'Urun Satış Miktarı'],
                          <?php 
                          $sql = "SELECT * FROM urun GROUP BY urun_ad ORDER BY urun_miktar ";
                          $fire = mysqli_query($conn, $sql);
                              while ($result = mysqli_fetch_assoc($fire)) {
                              echo "['".$result["urun_ad"]."',".$result["urun_miktar"]."],";}
                          ?>
                          ]);

                          var options = {
                            title: 'Satış Miktar Oranı'
                          };

                          var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                          chart.draw(data, options);
                        }
                      </script>
                      <body>
                      <div id="pie" class="card-body" style="width: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
                   
                      </body>
                    </div>
                </div>
              </div>

              <!-- Line Line Chart -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Yıllara Göre Gelir Dağılım Oranı</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                    <div class="lineline">
                      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                      <script type="text/javascript">
                          google.charts.load('current', {'packages':['corechart']});
                          google.charts.setOnLoadCallback(drawChart);

                          function drawChart() {
                              var data = google.visualization.arrayToDataTable([
                              ['Yıl', ''],
                              <?php 
                              $sql = "SELECT
                              EXTRACT(YEAR FROM urun_tarih) AS yil,
                              urun_ad,
                              SUM(urun_miktar) AS toplam_miktar,
                              SUM(urun_fiyat * urun_miktar) AS toplam_gelir
                              FROM urun GROUP BY yil, urun_ad ORDER BY yil, toplam_gelir DESC;";
                              $fire = mysqli_query($conn, $sql);
                                  while ($result = mysqli_fetch_assoc($fire)) {
                                  echo "['".$result["urun_ad"]."',".$result["toplam_miktar"]."],";}
                              ?>
                              ]);

                              var options = {
                              title: 'Yıllara Göre Satış Performansı',
                              hAxis: {
                              title: 'Ürün Adı'
                              },
                              vAxis: {
                              title: 'Satış Miktarı',
                              },
                              curveType: 'function',
                              legend: { position: 'bottom' }
                              };

                              var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                              chart.draw(data, options);
                          }
                      </script>
                        <body>
                          <div id="lineline" class="card-body" style="width: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
                        </body>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          </div>
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