<?php
    include 'blocks/headeradmin.php';
    $str="select clients.*,products.id as productId,tableofsize.name as sizename,
    products.name,image,folder,price,clientproducts.count, clientproducts.id as orderproductid from 
    clients inner join clientproducts on clients.id=clientproducts.idClient 
    inner join products on products.id=clientproducts.idProduct inner join category on 
    category.id=products.idCategory left join sizeproduct on 
    sizeproduct.idProduct=products.id left join tableofsize on 
    sizeproduct.idSize=tableofsize.id where 
    clients.id={$_GET['id']}";
    $res=$dbh->query($str);
    $row=$res->fetchAll();
?>
<link rel="stylesheet" href="css/bootstrap.css">

<div style="margin: 100px auto; width: 80%;" class="wrapper-admin">
    <h2>Заказ N<?php echo $row['0']['id'].",".$row[0]['Full name'];?></h2>
    <table class="order-product table table-bordered">
        <tr>
            <th>Индификатор</th>
            <th>Название</th>
            <th>Стоимость</th>
            <th>Изображение</th>
            <th>Количество</th>
            <th>размер</th>
            <th>Удалить</th>
        </tr>
        <?php 
            foreach($row as $item) :
                ?>
                    <tr>
                        <td><?php echo $item['id'] ?></td>
                        <td><?php echo $item['name'] ?></td>
                        <td><?php echo $item['price'] ?></td>
                        <td><img style="width: 150px;" src="img/<?php $image = explode(";",$item['image']); echo $image[0]; ?>"></td>
                        <td><form action="function.php" method="post"><input type="hidden" name="clientIdOrder" value="<?php echo $item['id'] ?>"><input type='hidden' value='<?php echo $item['orderproductid'];?>' name='countId'><input type="number" name="countProduct" value="<?php echo $item['count'] ?>"><input type="submit" name="saveCount"></form></td>
                        <td><?php echo $item['sizename'] ?></td>
                        <td><form action="function.php" method="post"><input type="hidden" name="idorderproduct" value="<?php echo $item['orderproductid'] ?>"><input class="btn btn-target" name="deleteorderproduct" type="submit" value="Delete"></form></td>
                    </tr>
                <?php
            endforeach;
        ?>
    </table>
</div>