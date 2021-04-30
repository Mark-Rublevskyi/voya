<link rel="stylesheet" href="css/bootstrap.css">
<?php 
    include 'blocks/headeradmin.php';

    $str = "select * from dbusers";
    $res = $dbh->query($str);
    $row = $res->fetchAll();
?>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jscript.js"></script>

<div style="margin: 100px auto; width: 80%;" class="wrapper-admin">
    <button style="margin: 10px 0" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Добавить пользователя
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-body"> 
                        <form class="add-user-to-db" action="function.php" method="post">
                            <input class="form-control" type="text" name="login" id="login" placeholder="Введите логин">
                            <input class="form-control" type="password" name="pass1" id="password" required class="register-input" onKeyUp="passValid('form','pass1','pass12','submit'),isRavno('form','pass1','pass2','pass22','submit')" pattern="(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{6,}" placeholder="Введите пароль">
                            <span id="pass11" style="display: none;"><span id="pass12"></span></span>
                            <input class="form-control" type="password" name="pass2" id="password-check" required class="register-input" title="" onKeyUp="isRavno('form','pass1','pass2','pass22','submit')" placeholder="Подтвердите пароль">
                            <span id="pass22"></span>
                            <ol>
                                <li> одне число; </li>
                                <li> одну латинську букву в нижньому регістрі;</li>
                                <li> одну латинську букву в верхньому регістрі;</li>
                                <li> складається не менше, ніж з 6 символів </li>
                            </ol>

                            <input class="form-control" type="email" name="email" id="email" placeholder="Электроная почта">
                            <select class="form-control" name="role" id="role">
                                <option value="1">Админ</option>
                                <option value="2">Создатель</option>
                            </select>
                            <input class="btn btn-primary" type="submit" value="зарегистрироваться" name="send-user">
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
            <th>Логин</th>
            <th>Пароль</th>
            <th>Эл. почта</th>
            <th>Роль</th>
            <th>Удалить аккаунт</th>
        </tr>
        <?php
            foreach($row as $value) {
                echo "<tr><td>{$value['id']}</td><td>{$value['login']}</td><td>{$value['password']}</td>
                <td>{$value['email']}</td><td>{$value['role']}</td><td>
                <form action='function.php' method='post'><input type='hidden' name='id' value='{$value['id']}'>
                <input type='submit' class='btn btn-target' name='deleteUser' value='delete'></form></td></tr>";
            }
        ?>
    </table>
</div>
