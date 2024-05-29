<?php
    session_start();
    if(session_destroy()) {
        header("Location: giriş_form.php");
    }
?>
