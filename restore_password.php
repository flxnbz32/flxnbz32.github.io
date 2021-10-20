<?php require "server.php"; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Восстановление пароля</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header">
    <h2>Восстановление пароля</h2>
</div>
<div class="_form">
    <form method="post" action="restore_password.php">
        <?php include('errors.php');?>
<!--        <div class="inputGr">-->
<!--            <label>Username: </label>-->
<!--            <label><input type="text" name="username"></label>-->
<!--        </div>-->
        <div class="inputGr">
            <label>Новый пароль: </label>
            <label><input type="password" name="password1"></label>
        </div>
        <div class="inputGr">
            <label>Введите новый пароль снова: </label>
            <label><input type="password" name="password2"></label>
        </div>
        <div class="buttons">
            <div class="button two">
                <button type="submit" name="restore" class="btn">Восстановить</button>
            </div>
            <div class="button two">
                <button type="submit" name="cancel_restore" class="btn">Отмена</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>