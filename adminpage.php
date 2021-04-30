<?php
    session_start();
    include "db.php";
    if(isset($_SESSION['user'])){
        include "blocks/headeradmin.php";
        echo "<p style='margin: 80px 120px; font-size: 20px;' class='login-text'>Вы вошли как {$_SESSION['user']}</p>";
    } else {
        echo "<script>location = 'admin.php?login=1'</script>";
    }
?>