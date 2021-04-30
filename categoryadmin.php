<link rel="stylesheet" href="css/bootstrap.css">
<?php
    include "blocks/headeradmin.php";

    $str = "select * from category";
    $res = $dbh->query($str);
    $row = $res->fetchAll();
?>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>

<div style="margin: 100px auto; width: 80%;" class="wrapper-admin">
    <button style="margin: 10px 0" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Добавить категорию
    </button>
    <div class="modal fade" id="exampleModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-body"> 
                        <form class="add-user-to-db" action="function.php" method="post">
                            <input class="form-control" type="text" name="nameCategory" placeholder="Введите название категории">
                            <input class="form-control" type="text" name="nameFolder" placeholder="Введите название папки">
                            <input class="btn btn-primary" type="submit" value="Добавить" name="add-category">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <table  class="user-table table table-bordered">
        <tr>
            <th>Индификатор</th>
            <th>Название</th>
            <th>Удалить категорию</th>
        </tr>
        <?php
            foreach($row as $value) {
                echo "<tr><td>{$value['id']}</td><td>{$value['name']}</td><td>
                <button style='margin: 10px 0' type='button' id='{$value['id']}' class='btn btn-primary' data-toggle='modal' data-target='#exampleDelModal'>
                    Добавить категорию
                </button>
                </td></tr>";
                ?>
                    <div class="modal fade" id="exampleDelModal" tabindex="-1">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="modal-body"> 
                                        <form class="add-user-to-db" action="function.php" method="post">
                                            <p class="Cate"></p>
                                            <form action='function.php' method='post'><input type='hidden' name='id' id="hiddenCat" class="edit-content"><input type='submit' class='btn btn-target' name='deleteCategory'  value='delete'></form>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>-->
                    <!--<script data-require="bootstrap@*" data-semver="3.1.1" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>-->
                    <script src="jquery.js"></script>
                    <script src="bootstrap.min.js"></script>
                    <link href="bootstrap.css">
                    <script>
                        $('#exampleDelModal').on('show.bs.modal', function(e) {
                            var $modal = $(this),
                                esseyId = e.relatedTarget.id;
                            $modal.find('#hiddenCat').val(esseyId);
                    
                            $.ajax("ajaxCt.php", {
                                type: "POST",
                                data: {id: esseyId},
                                success: function(data) {
                                    $('.Cate').html(data)
                                }
                            })
                        });
                    </script>
                <?php
            }
        ?>
    </table>
</div>