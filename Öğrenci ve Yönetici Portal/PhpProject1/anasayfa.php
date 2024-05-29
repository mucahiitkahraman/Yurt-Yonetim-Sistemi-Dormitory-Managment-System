<?php
session_start();

// anasayfa.html dosyasını oku
$homepage = file_get_contents('anasayfa.html');

// Yönetici adını ve butonu değiştirme
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $homepage = str_replace('Yönetici!', $username, $homepage);
    $homepage = str_replace('<button id="login-button" class="redirect-button" onclick="window.location.href=\'giris.html\'">Giriş</button>', '<button id="login-button" class="redirect-button btn-logout" onclick="window.location.href=\'cikis.php\'">Çıkış</button>', $homepage);
    $homepage = str_replace('class="sidebar-link disabled"', 'class="sidebar-link"', $homepage);
} else {
    $homepage = str_replace('<button id="login-button" class="redirect-button btn-logout" onclick="window.location.href=\'cikis.php\'">Çıkış</button>', '<button id="login-button" class="redirect-button" onclick="window.location.href=\'giris.html\'">Giriş</button>', $homepage);
    $homepage = str_replace('class="sidebar-link"', 'class="sidebar-link disabled"', $homepage);
}

// Güncellenmiş içeriği göster
echo $homepage;
?>
