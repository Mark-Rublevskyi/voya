<?php
    session_start();
    include 'db.php';
    if(isset($_SESSION['role'])) {
?>

<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.0.10/css/all.css">
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/grid.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/media.css">

<header>
    <div class="wrapper">
        <div class="header-content">
            <nav class="side-bar">
                <a href="orders.php" class="block">
                    <div class="icon">
                        <p class="fas fa-truck"></p>
                    </div>
                    <div class="link">
                        <p>Заказы</p>
                    </div>
                </a>
                <a href="adminproduct.php" class="block">
                    <div class="icon">
                        <p class="fas fa-book"></p>
                    </div>
                    <div class="link">
                        <p>Товары</p>
                    </div>
                </a>
                <a href="sizeadmin.php" class="block">
                    <div class="icon">
                        <p class="far fa-window-maximize"></p>
                    </div>
                    <div class="link">
                        <p>Размеры</p>
                    </div>
                </a>
                <a href="static.php" class="block">
                    <div class="icon">
                        <p class="far fa-chart-bar"></p>
                    </div>
                    <div class="link">
                        <p>Статистика</p>
                    </div>
                </a>
                <a href="users.php" class="block">
                    <div class="icon">
                        <p class="fas fa-users"></p>
                    </div>
                    <div class="link">
                        <p>Пользователи</p>
                    </div>
                </a>
                <a href="categoryadmin.php" class="block">
                    <div class="icon">
                        <p class="fas fa-align-justify"></p>
                    </div>
                    <div class="link">
                        <p>Категории</p>
                    </div>
                </a>
            </nav>
            <div class="head">
                <a href="exit.php?id=1">Выйти из профиля</a>
            </div>
        </div>
    </div>
</header>
<?php
    } else {
        echo "<script>location = 'adminpage.php'</script>";
    }
?>