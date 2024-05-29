<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Oturumun olup olmadığını kontrol et
if(!isset($_SESSION["ogrenci_ID"])){
    header("Location: giriş_form.php");
    exit();
}
?>
