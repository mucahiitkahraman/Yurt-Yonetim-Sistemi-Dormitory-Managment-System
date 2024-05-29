<?php
    session_start();

    if(!isset($_SESSION["kullaniciAdi"])) {
        header("Location: giriş_form.php");
        exit();
    }
?>
