<link rel="stylesheet" href="css/bootstrap.css">
<?php
    include "blocks/headeradmin.php";
    $str = "SELECT products.*, category.name as 'cat' FROM `products` INNER JOIN category ON products.idCategory=category.id";
    $res = $dbh->query($str);
    $row = $res->fetchAll();
    $str1 = "select * from products where id={$_POST['id']}";
    $res1 = $dbh->query($str1);
    $row1 = $res1->fetch();
    
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
                        echo "<option";
                            if($item['id']==$row1['idCategory']) {
                                echo " selected ";
                            }
                        echo " value='{$item['id']}'>{$item['name']}</option>";
                    }
                ?>
            </select>
        </label>
        <input type="hidden" value="<?php echo $row1['id']; ?>" name="id">
        <input type="text" value="<?php echo $row1['name']; ?>" class="form-control" name="productname" placeholder="Введите название товара">
        <input type="text" value="<?php echo $row1['price']; ?>" class="form-control" name="cost" placeholder="Введите цену продукта">
        <input type="text" value="<?php echo $row1['sale']; ?>" class="form-control" name="sale" placeholder="Введите скидку продукта">
        <!-- .... -->
        <p>Выбрать фотографии</p>
        <?php
            $exp1 = explode(";",$row1['image']);
            $k = 1;
            echo "<table id='timg'><tbody>";
            foreach($exp1 as $val) {
                echo "<tr id='i{$k}'><td><img class='editphoto' style='width: 10%; display: block;' 
                src='img/{$val}'/><input type='hidden' id='l{$k}' name='image-ol[]' value='{$val}'><input class='image' id='m{$k}' onchange='changefiles(this.id)' type='file' name='image[]' 
                multiple accept='image/*'/><input type='button' id='b{$k}' class='btn btn-target' name='{$val}' 
                onclick='delImg(this.name, {$_POST['id']}, this.id)' value='Удалить фото'></td></tr>";
                $k++;
            }
            echo "</tbody></table>";
        ?>
        <script>
            
            function changefiles(id) {
                let id1 = 'l'+id.slice(1);
                document.getElementById(id1).remove();
            }

        </script>
        <button type="button" onclick="addImg()">добавить картинку</button>
        <label>
            <!-- .... -->
            <p>Размеры</p>
            <select class="form-control" required name="size[]" multiple>
                <?php
                    $str = "select * from tableofsize";
                    $res = $dbh->query($str);
                    $row = $res->fetchAll();
                    $str2 = "select * from sizeproduct where idProduct={$_POST['id']}";
                    $res2 = $dbh->query($str2);
                    $row2 = $res2->fetchAll();                   
                    foreach($row as $item) :
                        echo "<option";
                        foreach($row2 as $val) :
                                if($val['idSize'] == $item['id']) {
                                    echo " selected ";
                                }
                        endforeach;
                        echo " value='{$item['id']}'>{$item['name']}</option>";    
                    endforeach;
                ?>
            </select>
        </label>
        <input class="form-control" value="<?php echo $row1['description']; ?>" type="text" name="descript" placeholder="Описание продукта">
        <input class="form-control" value="<?php echo $row1['material']; ?>" type="text" name="material" placeholder="Материал продукта">
        <input class="btn btn-target" type="submit" value="Редактировать" name="editproduct">
    </form>
</div>
<script src="js/jquery.js"></script>
<script src="js/function.main.js"></script>