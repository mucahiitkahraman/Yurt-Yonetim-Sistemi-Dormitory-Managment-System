<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=dormitory managment system", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Sql Bağlantı hatası : " . $e->getMessage();
    exit(); // Hata oluştuğunda işlemi sonlandır
}
?>