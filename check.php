<?php
    include "db.php";

    if(!isset($_POST['btn-sub'])) {
        echo "<script>location = 'admin.php'</script>";
    } else {
        $str = "select * from dbusers where login='{$_POST['username']}' and password='{$_POST['password']}'";
        $res = $dbh->query($str);
        $row = $res->fetch();
        if(isset($row['login'])) {
            session_start();
            $_SESSION['user'] = $_POST['username'];
            $_SESSION['role'] = $row['role'];
            echo "<script>location = 'adminpage.php'</script>";
        } else {
            echo "<script>location = 'admin.php?login=1'</script>";
        }
    }
?>