<link rel="stylesheet" href="css/bootstrap.css">
<?php
    include "blocks/headeradmin.php";
    $str = "SELECT products.*, category.name as 'cat' FROM `products` INNER JOIN category ON products.idCategory=category.id";
    $res = $dbh->query($str);
    $row = $res->fetchAll();
?>

<div style="margin: 100px auto; width: 80%;" class="wrapper-admin">
    <form action="function.php" class="addprod" method="post" enctype="multipart/form-data">
        <label>
            <p>Категория</p>
            <select class="form-control" name="category">
                <?php
                    $str = "select * from category";
                    $res = $dbh->query($str);
                    $row = $res->fetchAll();
                    foreach($row as $item) {
                        echo "<option value='{$item['id']}'>{$item['name']}</option>";
                    }
                ?>
            </select>
        </label>
        <input type="text" class="form-control" name="productname" placeholder="Введите название товара">
        <input type="text" class="form-control" name="cost" placeholder="Введите цену продукта">
        <input type="text" class="form-control" name="sale" placeholder="Введите скиду продукта">
        <!-- .... -->
        <p>Выбрать фотографии</p>
        <input class="image" type="file" name="image[]" multiple accept="image/*">
        <label>
            <!-- .... -->
            <p>Размеры</p>
            <select class="form-control" required name="size[]" multiple>
                <?php
                    $str = "select * from tableofsize";
                    $res = $dbh->query($str);
                    $row = $res->fetchAll();
                    foreach($row as $item) {
                        echo "<option value='{$item['id']}'>{$item['name']}</option>";
                    }
                ?>
            </select>
        </label>
        <input class="form-control" type="text" name="descript" placeholder="Описание продукта">
        <input class="form-control" type="text" name="material" placeholder="Материал продукта">
        <input class="btn btn-target" type="submit" value="Добавить" name="addproduct">
    </form>
</div>