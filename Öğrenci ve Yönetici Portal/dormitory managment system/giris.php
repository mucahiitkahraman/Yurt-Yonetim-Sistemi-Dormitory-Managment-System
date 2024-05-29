<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
</html>

<?php
require('db.php');
session_start();

if (isset($_POST['kullaniciAdi'], $_POST['sifre'])) {
    
    $response = $_POST['g-recaptcha-response'];
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => '6LfcvdApAAAAAHZBHAFUgAF9ffPw-k9KdU2POuTH',
        'response' => $response
    );
    $options = array(
        'http' => array (
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_success = json_decode($verify);

    if ($captcha_success->success == false) {
        echo "<script> Swal.fire({
            icon: 'error',
            title: 'Doğrulama yapılmadı!',
            text: 'Ben robot değilim doğrulaması yapmalısın.',
        }); 
        setTimeout(function(){
            window.location.href = 'giriş_form.php';
        }, 2000); 
        </script>";
        return;
    }

    $kullaniciAdi = $_POST['kullaniciAdi'];
    $sifre = $_POST['sifre'];

    
    $query = "SELECT * FROM kullanicilar WHERE kullaniciAdi=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$kullaniciAdi]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($sifre, $row['sifre'])) {
        if ($row['ogrenci_ID'] === null) {
            echo "<script> Swal.fire({
                icon: 'error',
                title: 'Oturum açmak için yetkiniz bulunmamaktadır.',
                text: 'Öğrenci numaranız bulunmuyor !',
            }); 
            setTimeout(function(){
                window.location.href = 'giriş_form.php';
            }, 2000); 
            </script>";
            exit(); 
        }
        $_SESSION['ogrenci_ID'] = $row['ogrenci_ID']; 
        $_SESSION['kullaniciAdi'] = $row['kullaniciAdi'];
        echo "<script> Swal.fire({
            icon: 'success',
            title: 'Giriş Başarılı!',
            text: 'Anasayfaya yönlendiriliyorsun.',
        }); 
        setTimeout(function(){
            window.location.href = 'anasayfa.php';
        }, 2000); 
        </script>";
        exit(); 
    } else {
        echo "<script> Swal.fire({
            icon: 'warning',
            title: 'Kullanıcı Adı veya Şifre yanlış!',
            text: 'Tekrar dene',
        }); 
        setTimeout(function(){
            window.location.href = 'giriş_form.php';
        }, 2000); 
        </script>";
    }
} 
?>
