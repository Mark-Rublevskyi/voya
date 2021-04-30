<?php
    include "blocks/headeradmin.php";
?>

<link rel="stylesheet" href="css/bootstrap.css">

<div style="margin: 100px auto; width: 80%;" class="wrapper-admin">
    <form action="static.php" method="post">
        <select name="changeValue" class="form-control" onchange="show(this.value)">
            <option value="1">Популярные товары</option>
            <option value="2">Не популярные товары</option>
            <option value="3">Продажи за период</option>
            <option value="4">Просроченные заказы</option>
        </select>
        <div style="display: none;" id="f">
            <p>С</p>
            <input class="form-control" type="date" name="startDate">
            <p>По</p>
            <input class="form-control" type="date" name="endDate">
        </div>
        <script>
            function show(val) {
                if(val == 3) {
                    document.getElementById("f").style.display="block";
                } else {
                    document.getElementById("f").style.display="none";
                }
            }
        </script>
        <input class="btn btn-target" type="submit" value="Выбрать" name="staticChange">
    </form>
    <?php 
        if(isset($_POST['staticChange'])) {
            if($_POST['changeValue'] == 1) {
                $str = "SELECT products.name,products.id, products.price, products.image, 
                COUNT(clientproducts.idClient)  FROM products INNER JOIN clientproducts 
                ON idProduct=products.id GROUP BY products.name,products.id, products.price, 
                products.image ORDER BY COUNT(clientproducts.idClient) DESC LIMIT 3";
                $res = $dbh->query($str);
                $row = $res->fetchAll();
                echo"<table class='table table-bordered'><tr><th>Индификатор</th><th>Название</th><th>Цена</th><th>Изображение</th><th>Кол-во</th></tr>";
                foreach($row as $value) {
                    $img = explode(";",$value['image']);
                    echo"<tr><td>{$value['id']}</td><td>{$value['name']}</td><td>{$value['price']}</td><td><img style='width: 10%;' src='img/{$img[0]}'></td><td>{$value['COUNT(clientproducts.idClient)']}</td></tr>";
                } echo"</table>";
            }
            elseif($_POST['changeValue'] == 2) {
                $str = "SELECT products.name,products.id, products.price, products.image, 
                COUNT(clientproducts.idClient)  FROM products LEFT JOIN clientproducts 
                ON idProduct=products.id GROUP BY products.name, products.id, products.price, products.image 
                ORDER BY COUNT(clientproducts.idClient) LIMIT 3";
                $res = $dbh->query($str);
                $row = $res->fetchAll();
                echo"<table class='table table-bordered'><tr><th>Индификатор</th><th>Название</th><th>Цена</th><th>Изображение</th><th>Кол-во</th></tr>";
                foreach($row as $value) {
                    $img = explode(";",$value['image']);
                    echo"<tr><td>{$value['id']}</td><td>{$value['name']}</td><td>{$value['price']}</td><td><img style='width: 10%;' src='img/{$img[0]}'></td><td>{$value['COUNT(clientproducts.idClient)']}</td></tr>";
                } echo"</table>";
            }
            elseif($_POST['changeValue'] == 3) {
                $str = "SELECT * FROM products INNER JOIN clientproducts ON idProduct=products.id 
                INNER  JOIN clients ON clientproducts.idClient=clients.id WHERE clients.date>='{$_POST['startDate']}' 
                AND clients.date<='{$_POST['endDate']}'";
                $str1 = "SELECT COUNT(*), SUM(products.price*clientproducts.count) FROM products INNER JOIN clientproducts ON idProduct=products.id 
                INNER  JOIN clients ON clientproducts.idClient=clients.id WHERE clients.date>='{$_POST['startDate']}' 
                AND clients.date<='{$_POST['endDate']}'";
                $res = $dbh->query($str);
                $row = $res->fetchAll();
                $res1 = $dbh->query($str1);
                $row1 = $res1->fetch();
                echo"<h2>Количество продаж {$row1['COUNT(*)']}, суммарная стоимость за период {$row1['SUM(products.price*clientproducts.count)']}</h2><table class='table table-bordered'><tr><th>Индификатор</th><th>Название</th><th>Цена</th><th>Изображение</th><th>Дата</th><th>Клиент</th><th>Статус</th></tr>";
                foreach($row as $value) {
                    $img = explode(";",$value['image']);
                    echo"<tr><td>{$value['id']}</td><td>{$value['name']}</td><td>{$value['price']}</td><td><img style='width: 10%;' src='img/{$img[0]}'></td><td>{$value['date']}</td><td>{$value['Full name']}</td><td>{$value['status']}</td></tr>";
                } echo"</table>";
            }
            elseif($_POST['changeValue'] == 4) {
                $str = "SELECT clients.id,`Full name`,`phone`,`status`,`date`, SUM(price*`count`) FROM `clients` INNER JOIN `clientproducts` ON clientproducts.idClient=clients.id INNER JOIN `products` ON clientproducts.idProduct = products.id WHERE CURRENT_DATE-`date`>2 and `status`='Новый' GROUP BY clients.id,`name`,`phone`,`status`,`date` ORDER BY SUM(price*`count`) DESC";
                $res = $dbh->query($str);
                $row = $res->fetchAll();
                echo"<table class='table table-bordered'><tr><th>Индификатор</th><th>ФИО</th><th>Телефон</th><th>Статус</th><th>Дата</th><th>Цена заказа</th></tr>";
                foreach($row as $value) {
                    $img = explode(";",$value['image']);
                    echo"<tr><td>{$value['id']}</td><td>{$value['Full name']}</td><td>{$value['phone']}</td><td>{$value['status']}</td><td>{$value['date']}</td><td>{$value['SUM(price*`count`)']}</td></tr>";
                } echo"</table>";
            }
        }
    ?>
</div>