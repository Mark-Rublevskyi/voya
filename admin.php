<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Авторизация</title>
</head>
<body>
    <form name="login-name" class="login-form" action="check.php" method="post">
        <div class="header">
            <h1>Авторизация</h1>
            <span>
                Введите ваши регистрационные данные для входа в ваш личный кабинет
            </span>
            <?php
                if(isset($_GET['login'])) {
                    echo "<br> <h6 class='text-danger'>Ваши данные неверные<h6>";
                }
            ?>
        </div>
        <div class="content">
            <input type="text" class="form-control" name="username" placeholder="Логин" required>
            <input type="password" class="form-control" name="password" placeholder="Пароль" required>
        </div>
        <div class="footer">
            <input type="submit" value="Войти" name="btn-sub" class="btn btn-danger">
        </div>
    </form>
</body>
</html>