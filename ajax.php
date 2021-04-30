<?php 
    session_start();
    $id = $_GET['id'];
    $_SESSION[$id]['count']=$_GET['value'];
    // echo json_encode($_SESSION[$_GET['id']]);
    // echo $_GET['id'];
    // var_dump($_SESSION);
    die;
?>