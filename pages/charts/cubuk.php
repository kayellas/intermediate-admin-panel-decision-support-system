<?php include("header.php")?>
<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'kds');
    if (!$conn) {
        echo "bağlantı başarısız: " . mysqli_connect_error();
    } else {
        echo "bağlandı";
    }
?>

<html>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
</head>
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
<div style="width: 800px;">
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
</div>
</body>
</html>

