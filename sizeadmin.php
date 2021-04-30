<link rel="stylesheet" href="css/bootstrap.css">
<?php
    include "blocks/headeradmin.php";
    $str="select * from tableofsize";
    $res=$dbh->query($str);
    $row=$res->fetchAll(); 
    ?>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jscript.js"></script>
    <div style="margin: 100px auto; width: 80%;" class="wrapper-admin">
    <button class='btn btn-primary' data-toggle="modal" data-target="#exampleModal">Добавить размер</button>
    <div class="modal fade" id="exampleModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <form class="add-size" action="function.php" method="post">
                        <div class="modal-body"> 
                            <input class="form-control" placeholder="Название размера" type="text" name="nameSize">
                        </div>
                        <div class="modal-footer">
                            <input class="btn btn-primary" name="addSize" type="submit" value="Добавить">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    echo "<table class='table table-bordered'>";
    ?>
        <tr>
            <th>Индификатор</th>
            <th>Название</th>
            <th>Удалить</th>
        </tr>
    <?php
    foreach($row as $item) :
        echo "<tr><td>{$item['id']}</td><td>{$item['name']}</td><td><form action='function.php' method='post'><input type='hidden' name='id' value='{$item['id']}' ><input name='deleteSize' class='btn btn-target' type='submit' value='delete'></form></td></tr>";
    endforeach;
    echo "</table></div>";
?>