<script src="show.js"></script>
<?php require 'server.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Регистрация</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="button">
    <a href="JAVASCRIPT:show()"><button class="regBut">Регистрация</button></a>
</div>
<div id="form" class="_form">
    <form method="post" action="registration.php" enctype="multipart/form-data">
        <!--        display errors here-->
        <?php include('errors.php'); ?>
        <div class="inputGr">
            <label>Логин: </label>
            <label><input type="text" name="username"></label>
        </div>
        <div class="inputGr">
            <label>Пароль: </label>
            <label><input type="password" name="password1"></label>
        </div>
        <div class="inputGr">
            <label>Пароль снова: </label>
            <label><input type="password" name="password2"></label>
        </div>
        <div class="inputGr">
            <label>ФИО:</label>
            <label><input type="text" name="name"></label>
        </div>
        <div class="inputGr">
            <label>Email: </label>
            <label><input type="text" name="email"></label>
        </div>
        <p>
            <label>Выберите аватар (jpg, gif or png):<br></label>
            <input type="FILE" name="file_upload">
        </p>
        <div class="button one">
            <button type="submit" name="register" class="btn">Зарегистрироваться</button>
        </div>
        <div class="already">
            <p>Уже зарегистрированы? <a href="login.php">Войти</a></p>
        </div>
    </form>
</div>
<!--<script src="show.js"></script>-->
<?php
//if (isset($_SESSION['but'])) {
//    echo '<script>';
//    echo 'show(true)';
//    echo '</script>';
//} else {
//    echo '<script>';
//    echo 'show(false)';
//    echo '</script>';
//}
//?>
</body>
</html>