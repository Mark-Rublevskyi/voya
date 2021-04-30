<?php
    include 'blocks/headeradmin.php';
?>
<link rel="stylesheet" href="css/bootstrap.css">

<div style="margin: 100px auto; width: 80%;" class="wrapper-admin">
    <?php
        if(isset($_POST['findStatus'])) {
            $str = "SELECT clients.id,`status`,`Full name`,phone,`date`,`City`,`idPostOfficeNumber`, deliverymethods.name AS `deliveryname`,COUNT(products.name) 
            AS productname,SUM(price*count),paymentmethods.name AS paymentname FROM clients LEFT JOIN clientproducts ON 
            clientproducts.idClient=clients.id LEFT JOIN deliverymethods ON clients.idDeliveryMethod=deliverymethods.id LEFT JOIN 
            paymentmethods ON clients.idPaymentMethod=paymentmethods.id LEFT JOIN products ON clientproducts.idProduct=products.id 
            where status like '{$_POST['selectStatusFind']}'GROUP BY clients.id,`status`,`Full name`,phone,`date`,deliveryname, paymentname order by clients.id desc";
        } else {
            $str = "SELECT clients.id,`status`,`Full name`,phone,`date`,`City`,`idPostOfficeNumber`, deliverymethods.name AS `deliveryname`,COUNT(products.name) 
            AS productname,SUM(price*count),paymentmethods.name AS paymentname FROM clients LEFT JOIN clientproducts ON 
            clientproducts.idClient=clients.id LEFT JOIN deliverymethods ON clients.idDeliveryMethod=deliverymethods.id LEFT JOIN 
            paymentmethods ON clients.idPaymentMethod=paymentmethods.id LEFT JOIN products ON clientproducts.idProduct=products.id 
            GROUP BY clients.id,`status`,`Full name`,phone,`date`,deliveryname, paymentname order by clients.id desc";
        }
        $res=$dbh->query($str);
        $row=$res->fetchAll();
        echo "<table id='filter-table' class='table table-bordered'><tr><th>Индификатор</th><th>ФИО</th><th>Телефон</th><th>Email</th><th>Дата</th><th>Способ доставки</th><th>Способ оплаты</th><th>Город</th><th>Адрес</th><th>Сумма заказа</th><th>Статус</th></tr>";
        ?>
            <p>Выберите статус заказа</p>
            <form action="orders.php" method="post">
                <select name="selectStatusFind">
                    <option>Новый</option>
                    <option>Оплаченный</option>
                    <option>Отправленный</option>
                </select>
                <input type="submit" value="Найти" name="findStatus">
            </form>
            <datalist id="listFilter">
                    <option>Новый</option>
                    <option>Оплаченный</option>
                    <option>Отправленный</option>
                    <option>Закрытый</option>
            </datalist>
            <tr class="table-filters">
                <td><input type="text" class="form-control"></td>
                <td><input type="text" class="form-control"></td>
                <td><input type="text" class="form-control"></td>
                <td><input type="text" class="form-control"></td>
                <td><input type="text" class="form-control"></td>
                <td><input type="text" class="form-control"></td>
                <td><input type="text" class="form-control"></td>
                <td><input type="text" class="form-control"></td>
                <td><input type="text" class="form-control"></td>
                <td><input type="text" class="form-control"></td>
                <td>
                </td>
            </tr>
            <tbody>
        <?php
        $res1=$dbh->query("select * from status");
        $row1=$res1->fetchAll();
        foreach($row as $item) :
            echo "<tr class='table-data'><td>{$item['id']}</td>
            <td>{$item['Full name']}</td><td>{$item['phone']}</td>
            <td>{$item['email']}</td><td>{$item['date']}</td>
            <td>{$item['deliveryname']}</td><td>{$item['paymentname']}</td>
            <td>{$item['City']}</td><td>{$item['idPostOfficeNumber']}</td>
            <td>{$item['SUM(price*count)']}</td><td><form action='function.php' method='POST'><input type='hidden' value='{$item['id']}' name='orderId'><select name='statusSelect'>";
            foreach($row1 as $val) :
                echo "<option ";
                    if($val['name']==$item['status']) {
                        echo "selected";
                    }
                echo " value='{$val['name']}'>{$val['name']}</option>";
            endforeach;
            echo "</select><input class='btn btn-target' type='submit' name='btnChangeStatus' value='сохранить'></form><a href='orderproduct.php?id={$item['id']}' class='btn btn-target'>Посмотреть товары</a></td></tr>";
        endforeach;
        echo "</tbody></table>";
    ?>
</div>
<script src="js/jquery.js"></script>
<script src="js/filter.js"></script>