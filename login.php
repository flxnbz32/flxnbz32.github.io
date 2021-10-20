<?php require 'server.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Авторизация</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header">
    <h2>Авторизация</h2>
</div>
<div class="_form">
    <form method="post" action="login.php">
        <?php include('errors.php');?>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success">
                <h3>
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
        <?php endif ?>
        <div class="inputGr">
            <label>Логин: </label>
            <label><input type="text" name="username"></label>
        </div>
        <div class="inputGr">
            <label>Пароль: </label>
            <label><input type="password" name="password"></label>
        </div>
        <div class="button one">
            <button type="submit" name="login" class="btn">Войти</button>
        </div>
        <div class="already">
            <p><a href="get_link.php">Забыли пароль?</a></p>
        </div>
        <div class="already">
            <p>Еще не зарегистрировались? <a href="registration.php">Зарегистрироваться</a></p>
        </div>
    </form>
</div>
</body>
</html>