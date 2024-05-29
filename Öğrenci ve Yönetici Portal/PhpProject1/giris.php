<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Veritabanı bağlantısını dahil et
include 'db.php';

// Form verilerini al
$username = $_POST['username'];
$password = $_POST['password'];

// Kullanıcıyı veritabanında ara
$sql = $conn->prepare("SELECT * FROM kullanicilar WHERE kullaniciAdi = ?");
$sql->bind_param("s", $username);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Şifreyi kontrol et
    if (password_verify($password, $row['sifre'])) {
        // Giriş başarılı
        $_SESSION['username'] = $username;
        header("Location: anasayfa.php");
        exit(); // Yönlendirme sonrası scripti sonlandırmak için
    } else {
        // Şifre yanlış
        echo "Hata: Kullanıcı adı veya şifre yanlış.";
        header("Refresh: 3; URL=giris.html");
        exit();
    }
} else {
    // Kullanıcı bulunamadı
    echo "Hata: Kullanıcı adı veya şifre yanlış.";
    header("Refresh: 3; URL=giris.html");
    exit();
}

// Bağlantıyı kapat
$conn->close();
?>
