<?php
    include 'db.php';
    $str = "select * from category where id={$_POST['id']}";
    $res = $dbh->query($str);
    $row = $res->fetchAll();
    echo "Если вы удалите категорию {$row[0]['name']}, то все товары в ней удалятся. Вы точно хотите удалить?";
    $str1 = "select COUNT(*) from products where idCategory={$_POST['id']}";
    $res1 = $dbh->query($str1);
    $row1 = $res1->fetch();
    echo " "."Количество товаров: ".$row1['COUNT(*)'];
?>