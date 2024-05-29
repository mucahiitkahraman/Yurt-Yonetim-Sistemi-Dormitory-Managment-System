<?php
session_start();
include 'db.php';

// Giriş kontrolü
if (!isset($_SESSION['username'])) {
    header("Location: giris.html");
    exit();
}

if (isset($_POST['yurt_ID'])) {
    $yurt_ID = $_POST['yurt_ID'];

    // Yurdu veritabanından sil
    $sql = "DELETE FROM yurtlar WHERE yurt_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $yurt_ID);

    if ($stmt->execute()) {
        echo "Yurt başarıyla silindi.";
    } else {
        echo "Hata: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Geçersiz istek.";
}
?>
