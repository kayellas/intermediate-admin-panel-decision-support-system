<?php include("header.php")?>

<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'kds' );
    if (!$conn) {
        echo "bağlantı başarısız: " . mysqli_connect_error();
    } else {
        echo "bağlandı";
    }
?>
<html>
  <head>
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

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);
        }
        </script>
  </head>
  <body>
    <div id="curve_chart" style="width: 900px; height: 500px"></div>
  </body>
</html>
