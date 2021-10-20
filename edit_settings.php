<?php
require "server.php";
if (!isset($_SESSION["user_id"])) {
    header('location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Редактирование</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header">
    <h2>Изменить пользователя</h2>
</div>
<div class="_form">
    <form method="POST" action="edit_settings.php" enctype="multipart/form-data">
        <!--display errors here-->
        <?php include('errors.php'); ?>
        <div class="inputGr"><h3>Пользователь: <?php echo $username; ?></h3></div>
        <div class="inputGr">
            <label>Новый пароль: </label>
            <label><input type="password" name="password1"></label>
        </div>
        <div class="inputGr">
            <label>Повторите новый пароль: </label>
            <label><input type="password" name="password2"></label>
        </div>
        <div class="inputGr">
            <label>Ваше ФИО:</label>
            <label><input type="text" name="name" value="<?php echo $name; ?>"></label>
        </div>
        <div class="inputGr">
            <label>Email: </label>
            <label><input type="text" name="email" value="<?php echo $email; ?>"></label>
        </div>
        <div class="inputGr">
            <label>Новый аватар (jpg, gif или png):<br></label>
            <input type="file" name="file_upload">
        </div>
        <div class="buttons">
            <div class="button two">
                <button type="submit" name="edit" class="btn">Изменить</button>
            </div>
            <div class="button two">
                <button type="submit" name="cancel_edit" class="btn">Отмена</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>