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
    <form method="post" action="get_link.php">
        <?php include('errors.php'); ?>
        <div class="inputGr">
            <label>Логин: </label>
            <label><input type="text" name="username"></label>
        </div>
        <div class="buttons">
            <div class="button two">
                <button type="submit" name="next" class="btn">Восстановить</button>
            </div>
            <div class="button two">
                <button type="submit" name="cancel_restoration" class="btn">Отмена</button>
            </div>
        </div>
    </form>
</div>
<br>
<div style="text-align: center">
    <?php
    if (isset($_SESSION['link'])) { ?>
        <a href="restore_password.php"><?php echo $_SESSION['link']; ?></a>
        <?php unset($_SESSION['link']);
    } ?>
</div>
</body>
</html>