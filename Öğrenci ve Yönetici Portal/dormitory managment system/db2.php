<?php

    $baglan = mysqli_connect("localhost","root","","dormitory managment system");
    
    if (mysqli_connect_errno()){
        echo "Sql Bağlantı hatası : " . mysqli_connect_error();
    }
?>