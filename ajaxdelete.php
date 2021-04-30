<?php
    session_start();
    $id = $_POST['id'];
    unset($_SESSION[$id]);
?>