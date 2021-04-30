<link rel="stylesheet" href="css/bootstrap.css">
<?php
    include 'blocks/headeradmin.php';
?>

<div style="margin: 100px auto; width: 80%;" class="wrapper-admin">
    <a style="margin: 10px 0;" class="btn btn-primary" href="addproduct.php">Добавит товар</a>
    <h1 style="font-size: 20px; padding-bottom: 10px;">Список товаров</h1>
    <table class="table table-bordered">
        <tr>
            <th>Индификатор</th>
            <th>Название категории</th>
            <th>Название товара</th>
            <th>Цена</th>
            <th>Скидка</th>
            <th>Изображение</th>
            <th>Размер</th>
            <th>Описание</th>
            <th>Материал</th>
            <th>Удалить/Редактировать</th>
        </tr>
        <?php
            $str = "SELECT products.*, category.name as 'cat' FROM `products` INNER JOIN category ON products.idCategory=category.id";
            $res = $dbh->query($str);
            $row = $res->fetchAll();
            foreach($row as $item) {
                $image = explode(';', $item['image']);
                echo "<tr><td>{$item['id']}</td><td>{$item['cat']}</td><td>{$item['name']}</td>
                <td>{$item['price']}</td><td>{$item['sale']}</td><td><img style='width: 100px;' src='img/$image[0]'></img></td><td>";
                $str1 = "SELECT tableofsize.name FROM `sizeproduct` INNER JOIN products
                ON products.id=sizeproduct.idProduct LEFT JOIN tableofsize ON tableofsize.id=sizeproduct.idSize 
                WHERE sizeproduct.idProduct={$item['id']}";
                $res1 = $dbh->query($str1);
                $row1 = $res1->fetchAll();
                foreach($row1 as $value) {
                    echo $value['name']."<br>";
                }
                echo "</td><td>{$item['description']}</td><td>{$item['material']}</td><td><form action='function.php' 
                method='post'><input type='hidden' name='id' value='{$item['id']}'>
                <input type='submit' class='btn btn-target' name='deleteProduct' value='delete'></form><form action='editproduct.php' 
                method='post'><input type='hidden' name='id' value='{$item['id']}'>
                <input type='submit' class='btn btn-target' name='editProduct' value='Edit'></form></td></tr>";
            }
        ?>
    </table>
</div>