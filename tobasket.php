<?php 
session_start();
?>
<?php
// var_dump($_SESSION);
// echo "<br>";
    if(isset($_POST['tobasket'])) {
        if(isset($_SESSION['role'])) {
            unset($_SESSION['role']);
            unset($_SESSION['user']);
        }
        $id='id_'.$_POST['id'].'_'.$_POST['size'];
        if(isset($_SESSION[$id])) {
            // if($_SESSION[$id]['size']==$_POST['size']) {
                $_SESSION[$id]['count']=$_SESSION[$id]['count']+=1;
            // }
            // else {
                // $_SESSION[$id]=['count'=>1,'size'=>$_POST['size']];
            //} 
            }
            else {
                $_SESSION[$id]=['id'=>$_POST['id'],'count'=>1,'size'=>$_POST['size']];
            }
            // var_dump($_SESSION);
            echo "<script>location = 'product.php?id=".$_POST['id']."'</script>";
        }
// $_SESSION['id'][0]=['count'=>1,'size'=>$_POST['size']];
?>