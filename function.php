<?php
    session_start();
    include 'db.php';
    if(isset($_POST['postButton'])) {
        $date = date("y-m-d");
        if($_POST['delivery'] == 2) {
            $number=$_POST['postNumber'];
        } else {
            $number="Улица: ".$_POST['street']." Дом: ".$_POST['house']." подъезд: ".$_POST['entrance']." квартира: ".$_POST['flat'];
        }
        $str = "INSERT INTO `clients`(`Full name`, `phone`, `idDeliveryMethod`, `idPaymentMethod`, `idPostOfficeNumber`, `City`, `date`,`status`)
        VALUES('{$_POST['fullName']}','{$_POST['tel']}',{$_POST['delivery']},{$_POST['payment']},'{$number}','{$_POST['city']}','{$date}','новый')";
        $dbh->query($str);
        $lastId = $dbh->lastInsertId();
        foreach($_SESSION as $item) :
            $string = "INSERT INTO `clientproducts`(`idProduct`, `idClient`, `count`, `size`) VALUES ({$item['id']},{$lastId},{$item['count']}, '{$item['size']}')";
            $dbh->query($string);
        endforeach;
        session_unset();
        echo "<script>location = 'form.php?id={$lastId}'</script>";
    }
    function delProd($id){
        include "db.php";
        $str2 = "SELECT image,folder FROM `products` INNER JOIN category ON products.idCategory = category.id WHERE products.id={$id}";
        $res=$dbh->query($str2);
        $row=$res->fetch();
        $exp = explode(";", $row['image']);
        $countImageDel = count($exp);
        $folder = $row['folder'];
        for($i = 0; $i < $countImageDel; $i++) {
            $put = "img/".$exp[$i];
            unlink($put);
        }
        $str1 = "DELETE FROM `sizeproduct` WHERE idProduct={$id}";
        $dbh->query($str1);
        $str = "DELETE FROM `products` WHERE id={$id}";
        $dbh->query($str);   
    }

    if(isset($_POST['send-user'])) {
        $rr=password_hash($post_data['pass1'], PASSWORD_DEFAULT);
        $str = "INSERT INTO `dbusers`(`login`, `password`, `email`, `role`)
        VALUES('{$_POST['login']}','{$_POST['pass1']}','{$_POST['email']}','{$_POST['role']}')";
        $dbh->query($str);
        echo "<script>location = 'users.php'</script>";
    }

    if(isset($_POST['deleteUser'])) {
        $str = "DELETE FROM `dbusers` WHERE id={$_POST['id']}";
        $dbh->query($str);
        echo "<script>location = 'users.php'</script>";
    }

    if(isset($_POST['deleteCategory'])) {
        $str1 = "SELECT * FROM `products` WHERE idCategory={$_POST['id']}";
        $res1 = $dbh->query($str1);
        $row1 = $res1->fetchAll();
        foreach($row1 as $item) :
            delProd($item['id']);    
        endforeach;
        $str3 = "SELECT folder FROM category WHERE id={$_POST['id']}";
        $res1 = $dbh->query($str3);
        $row1 = $res1->fetch();
        $fold = $row1['folder'];
        $dir = "/var/www/cnmatzvg/data/www/voya.com.ua/img/{$fold}";
        if(is_dir($dir)) {
            rmdir($dir);
        }
        $str = "DELETE FROM `category` WHERE id={$_POST['id']}";
        $dbh->query($str);
        echo "<script>location = 'categoryadmin.php'</script>";
    }
    if(isset($_POST['deleteProduct'])) { 
        delProd($_POST['id']);
        echo "<script>location = 'adminproduct.php'</script>";
    }
    
    if(isset($_POST['deleteProdBasket'])) {
        $id = $_POST['productId'];
        unset($_SESSION[$id]);
        echo "<script>location='basket.php'</script>";
    }

    if(isset($_POST['addproduct'])) {
        $string = "select folder from category where id={$_POST['category']}";
        $res = $dbh->query($string);
        $row = $res->fetch();
        $folder = $row['folder'];
        $str1 = "";
        foreach($_FILES as $item) :
            foreach($item['name'] as $value) :
                $str1 = $str1.$folder."/{$value};";
            endforeach;
        endforeach;
        $str1 = substr($str1,0,-1);
        // echo $str1;
        $str = "INSERT INTO `products`(`idCategory`, `name`, `price`, `description`, `image`, `material`, `sale`)
        VALUES('{$_POST['category']}','{$_POST['productname']}','{$_POST['cost']}','{$_POST['descript']}','{$str1}','{$_POST['material']}',{$_POST['sale']})";
        $dbh->query($str);
        $countimage = count($_FILES['image']['name']);
        for($i = 0; $i<$countimage; $i++) {
            $filepast = $_FILES['image']['tmp_name'][$i];
            $error = $_FILES['image']['error'][$i];
            $type = finfo_open(FILEINFO_MIME_TYPE);
            $fileinfo = (string)finfo_file($type, $filepast);
            finfo_close($type);
            if(strpos($fileinfo,'image')===false) {
                die('Можно загружать только изображения');
            }
            $limitbyte = 1024*1024*5;
            $image = getimagesize($filepast);
            if(filesize($filepast)>$limitbyte) {
                die('Размер изображение не должен привышать 5mb');
            }
            if(isset($_FILES) && $error == 0) {
                $dir = "img/".$folder.'/'.$_FILES['image']['name'][$i];
                move_uploaded_file($_FILES['image']['tmp_name'][$i],$dir);
                echo "Файл загружен";
            } else {
                echo "Файл не загружен";
            }
        }
        $idProd = $dbh->lastInsertId();
        $i = 0;
        foreach($_POST['size'] as $val) :
            $str2 = "INSERT INTO `sizeproduct`(`idSize`, `idProduct`) VALUES ({$val},{$idProd})";
            $dbh->query($str2);
            $i++;
        endforeach;
        echo "<script>location = 'addproduct.php'</script>";
    }

    if(isset($_POST['editproduct'])) {
        $string = "select folder from category where id={$_POST['category']}";
        $res = $dbh->query($string);
        $row = $res->fetch();
        $folder = $row['folder'];
        $str2 = "SELECT folder FROM category INNER JOIN products ON products.idCategory = category.id WHERE products.id = {$_POST['id']}";
        $row2 = $dbh->query($str2);
        $res2 = $row2->fetch();
        $folder2 = $res2['folder'];
        $str1 = "";
        foreach($_POST['image-ol'] as $item) :
            $item1 = strpos($item,'/');
            $item1 = substr($item, 0, $item1);
            $item2 = str_replace($item1,$folder,$item);
            $str1 = $str1."{$item2};";
        endforeach;
        foreach($_FILES as $item) :
            foreach($item['name'] as $value) :
                if(!empty($value)) {
                    $str1 = $str1.$folder."/{$value};";
                }
            endforeach;
        endforeach;
        if($folder2 != $folder) {
            foreach($_POST['image-ol'] as $item) :
                $dir = "img/".$item;
                $item1 = explode("/",$item);
                $item2 = $item1[1];              
                $dir2 = "img/".$folder."/".$item2;
                rename($dir,$dir2);
            endforeach;
        }
            $countimage = count($_FILES['image']['name']);
            for($i = 0; $i<$countimage; $i++) {
                if(!empty($_FILES['image']['name'][$i])) {
                    $filepast = $_FILES['image']['tmp_name'][$i];
                    $error = $_FILES['image']['error'][$i];
                    $type = finfo_open(FILEINFO_MIME_TYPE);
                    $fileinfo = (string)finfo_file($type, $filepast);
                    finfo_close($type);
                    if(strpos($fileinfo,'image')===false) {
                        die('Можно загружать только изображения');
                    }
                    $limitbyte = 1024*1024*5;
                    $image = getimagesize($filepast);
                    if(filesize($filepast)>$limitbyte) {
                        die('Размер изображение не должен привышать 5mb');
                    }
                    if(isset($_FILES) && $error == 0) {
                        $dir = "img/".$folder.'/'.$_FILES['image']['name'][$i];
                        move_uploaded_file($_FILES['image']['tmp_name'][$i],$dir);
                        echo "Файл загружен";
                    } else {
                        echo "Файл не загружен";
                    }
                }
            }
        // var_dump($_FILES);

        $str1 = substr($str1,0,-1);

        $str = "UPDATE `products` SET `idCategory`={$_POST['category']},`name`='{$_POST['productname']}',`price`={$_POST['cost']},`description`='{$_POST['descript']}',`image`='{$str1}',`material`='{$_POST['material']}'";
        if($_POST['sale']=="") {
            $str=$str;
        } else {
            $str=$str.",`sale`={$_POST['sale']}";
        }
        $str=$str." WHERE id={$_POST['id']}";
        echo $str;
        $i = 0;
        $str2 = "DELETE FROM `sizeproduct` WHERE idProduct={$_POST['id']}";
        $dbh->query($str2);
        foreach($_POST['size'] as $val) :
            $str2 = "INSERT INTO `sizeproduct`(`idSize`, `idProduct`) VALUES ({$val},{$_POST['id']})";
            echo $str2;
            $dbh->query($str2);
            $i++;
        endforeach;
        // echo $str1;
        $dbh->query($str);
        echo "<script>location = 'adminproduct.php'</script>";
    }

    if(isset($_POST['add-category'])) {
        $str = "INSERT INTO `category`(`name`,`folder`) VALUES('{$_POST['nameCategory']}','{$_POST['nameFolder']}')";
        $dbh->query($str);
        $dir = "/var/www/cnmatzvg/data/www/voya.com.ua/img/{$_POST['nameFolder']}";
        if(file_exists($dir)) {
            echo "Такая папка уже есть";
        } else {        
            mkdir($dir,0777,true);
        }
        echo "<script>location = 'categoryadmin.php'</script>";
    }

    if(isset($_POST['btnChangeStatus'])) {
        if($_POST['statusSelect']  == "Закрытый") {
            $str1="INSERT INTO `archive` select * from `clients` where clients.id={$_POST['orderId']}";
            $dbh->query($str1);
            $str2 = "DELETE FROM `clientproducts` where clientproducts.idClient={$_POST['orderId']}";
            $dbh->query($str2);
            $str = "DELETE FROM `clients` where clients.id={$_POST['orderId']}";
        } else {
            $str = "UPDATE clients SET `status`='{$_POST['statusSelect']}' WHERE clients.id={$_POST['orderId']}";
        }
        $dbh->query($str);
        echo "<script>location='orders.php'</script>";
    }
    
    if(isset($_POST['saveCount'])) {
        $str = "UPDATE clientproducts SET `count`='{$_POST['countProduct']}' WHERE id={$_POST['countId']}";
        $dbh->query($str);
        echo "<script>location='orderproduct.php?id={$_POST['clientIdOrder']}'</script>";
    }

    if(isset($_POST['addSize'])) {
        $str = "INSERT INTO `tableofsize`(`name`) VALUES('{$_POST['nameSize']}')";
        $dbh->query($str);
        echo "<script>location = 'sizeadmin.php'</script>";
    }

    if(isset($_POST['deleteSize'])) {
        $str = "DELETE FROM `tableofsize` WHERE id={$_POST['id']}";
        $dbh->query($str);
        echo "<script>location = 'sizeadmin.php'</script>";
    }
    
    if(isset($_POST['deleteorderproduct'])) {
        $str = "DELETE FROM clientproducts WHERE id={$_POST['idorderproduct']}";
        $dbh->query($str);
        echo "<script>location='orders.php'</script>";
    }
?>