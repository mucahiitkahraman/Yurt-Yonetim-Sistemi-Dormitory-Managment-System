<?php
include 'db.php'; // Veritabanı bağlantısı için db.php dosyasını dahil et

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phoneNumber = $_POST['phoneNumber'];
    $position = $_POST['position'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Şifreyi hash'le

    // Veritabanı bağlantısını aç
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Bağlantıyı kontrol et
    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    // Kullanıcıyı ekle
    $sqlUser = "INSERT INTO kullanicilar (kullaniciAdi, sifre) VALUES (?, ?)";
    $stmtUser = $conn->prepare($sqlUser);
    $stmtUser->bind_param("ss", $username, $password);

    if ($stmtUser->execute()) {
        $userId = $stmtUser->insert_id;

        // Personeli ekle
        $sqlStaff = "INSERT INTO personel (isim, soyisim, pozisyon) VALUES (?, ?, ?)";
        $stmtStaff = $conn->prepare($sqlStaff);
        $stmtStaff->bind_param("sss", $firstName, $lastName, $position);

        if ($stmtStaff->execute()) {
            $staffId = $stmtStaff->insert_id;

            // Kullanıcı tablosunda personel_ID'yi güncelle
            $sqlUpdateUser = "UPDATE kullanicilar SET personel_ID = ? WHERE kullanici_ID = ?";
            $stmtUpdateUser = $conn->prepare($sqlUpdateUser);
            $stmtUpdateUser->bind_param("ii", $staffId, $userId);
            $stmtUpdateUser->execute();

            echo "Kayıt başarılı!";
        } else {
            echo "Personel eklenirken hata oluştu: " . $stmtStaff->error;
        }
    } else {
        echo "Kullanıcı eklenirken hata oluştu: " . $stmtUser->error;
    }

    // Bağlantıyı kapat
    $stmtUser->close();
    $stmtStaff->close();
    $stmtUpdateUser->close();
    $conn->close();
}
?>
