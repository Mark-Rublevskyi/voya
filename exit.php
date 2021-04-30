<?php
    if (isset($_GET['id'])){
        session_start();
        unset($_SESSION['user']);
        session_destroy();
        header('Location: admin.php');
    }           
?> 