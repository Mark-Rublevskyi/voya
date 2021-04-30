<?php
session_start();
include 'db.php';
$self = $_SERVER['PHP_SELF'];
$str = "select * from `pages` where `url`='{$self}'";
$res = $dbh->query($str);
$row = $res->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="<?php echo $row['description'] ?>">
    <meta name="keywords" content="<?php echo $row['keywords'] ?>">
    <meta name="google-site-verification" content="msEYzpO5GBmtqqSuZ6Gjm9KTgXG5B_3AKw9W5_JYKcU" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.0.10/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media.css">
    <title><?php echo $row['title'] ?></title>
</head>
<body>
    <div class="mobile-container">
        <div class="overlay" data-mobile="close"></div>
        <div class="mobile-content">
            <div class="top-bar">
                <div class="close">
                    <button class="fal fa-times" data-mobile="close"></button>
                </div>
            </div>
            <?php
                $res = $dbh->query("select * from category");
                $row = $res->fetchAll();                                   
                echo "<ul>"; 
                echo "<li><a href='shirts.php?id=0'>Вся одежда</a></li>";
                foreach($row as $item) :
                echo "<li><a href='shirts.php?id={$item['id']}'>{$item['name']}</a></li>";
                endforeach; echo "</ul>";
            ?>
        </div>
    </div>
    <header>
        <div class="top-header">
            <div class="wrapper">
                <div class="top-header-content">
                    <div class="header-bar">
                        <div class="header-bar-icon">
                            <button class="open-burger-menu fal fa-bars" data-mobile="open"></button>
                        </div>
                    </div>
                    <a href="index.php">
                        <div class="shop-title">
                            <h1>voya</h1>
                        </div>
                    </a>
                    <div class="header-menu">
                        <!-- <a class="menu-item">EN</a>
                        <button class="fal fa-search menu-item"></button> -->
                        <a href="basket.php" class="fal fa-shopping-bag menu-item"><?php 
                            if(isset($_SESSION['role'])) {
                                unset($_SESSION['role']);
                                unset($_SESSION['user']);
                            } 
                            $count=0; 
                            foreach($_SESSION as $item) : 
                                $count=$count+$item['count']; 
                            endforeach; 
                            if($count != 0) {
                                echo "<span class='countbasket' id='countProd'>".$count."</span>";
                            }
                            ?>
                            
                        </a>
                        <div class="dropdown hidden" id="dropBasket">
                            <h2 >Корзина</h2>
                            <?php
                                foreach($_SESSION as $val1) {
                                    $str2 = "SELECT * from products where id={$val1['id']}";
                                    $res=$dbh->query($str2);
                                    $row=$res->fetch();
                                    $img=explode(";", $row['image']);
                                    ?>
                                    <div class="product">
                                        <div class="left-bar">
                                            <div class="left-bar-image">
                                                <img src="img/<?php echo $img[0] ?>">
                                            </div>
                                            <div class="left-bar-description">
                                                <div class="cost">
                                                    <p><?php echo $row['name'] ?></p>
                                                </div>
                                                <div class="type">
                                                    <p><?php echo $row['price'] ?> грн</p>
                                                </div>
                                                <div class="size">
                                                    <p>Размер: <?php echo $val1['size']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="right-bar">
                                            <div class="delete">
                                                <button id="id_<?php echo $val1['id']."_".$val1['size'];?>" onclick="delFromBasket(this.id)" class="fal fa-times"></button>
                                            </div>
                                            <div id="hex"></div>
                                            <script src="js/jquery.js"></script>
                                            <script>
                                                function delFromBasket(id) {
                                                    $.ajax({
                                                    url : 'ajaxdelete.php',
                                                    type : 'POST',
                                                    data : {
                                                    'id' : id
                                                    },
                                                    success : function(data) {
                                                        document.getElementById(id).closest(".product").remove();
                                                        location.reload();
                                                    }
                                                    });
                                                }
                                            </script>
                                        </div>
                                    </div>
                                    <?php
                                }
                            ?>
                            <div class="unshow-basket">
                                <a id="unshow">Продолжить покупки</a>
                                <style>
                                #unshow {
                                    color: #47A18E;
                                    text-align: center;
                                    font-size: 16px;
                                }
                                .unshow-basket {
                                    padding-top: 10px;
                                    width: max-content;
                                    margin: 0 auto;
                                }
                                </style>
                            </div>
                            <div class="to-basket">
                                <a href="basket.php">Перейти в корзину</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/unshow.js"></script>