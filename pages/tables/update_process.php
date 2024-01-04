<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['personel_id'])) {
    $personelId = $_POST['personel_id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "personel_takip";

    $connection = new mysqli($servername, $username, $password, $database);
    if ($connection->connect_error) {
        die("Connection failed" . $connection->connect_error);
    }

    $personelAdi = $_POST['personel_adi'];
    $personelSoyadi = $_POST['personel_soyadi'];
    $personelTc = $_POST['personel_tc'];
    $personelMail = $_POST['personel_mail'];
    $personelTel = $_POST['personel_tel'];
    $personelTurId = $_POST['personel_tur_id'];

    $sql = "UPDATE personel SET 
        personel_adi = ?, 
        personel_soyadi = ?, 
        personel_tc = ?, 
        personel_mail = ?, 
        personel_tel = ?, 
        personel_tur_id = ?
        WHERE personel_id = ?";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param("ssssssi", $personelAdi, $personelSoyadi, $personelTc, $personelMail, $personelTel, $personelTurId, $personelId);

    if ($stmt->execute()) {
        // Başarılı bir şekilde güncellendiğinde kursiyer.php sayfasına yönlendirme yapabilirsiniz
        /* header("Location: kursiyer.php"); */
        echo '<script type="text/javascript">alert("Güncelleme başarıyla gerçekleştirildi.");</script>';
        header("Location: update_process.php");

        exit();
    } else {
        die("Güncelleme hatası: " . $stmt->error);
    }

    $stmt->close();
    $connection->close();

} else {
    // Hatalı veya eksik parametrelerle erişim durumunda başka bir sayfaya yönlendirme yapabilirsiniz
    header("Location: panel.php");
    exit();
}
?>
