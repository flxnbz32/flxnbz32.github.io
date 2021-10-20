<?php require 'server.php';
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
} ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Домашняя страница</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header">
    <h2>Добро пожаловать, <?php echo $name ?></h2>
</div>
<div class="homepage">
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
    <?php if (isset($_SESSION["user_id"])) { ?>
        <p>Ваш логин: <strong><?php echo $username ?></strong></p>
        <p>Почта: <?php echo $email ?></p>
        <img alt="<?php $_SESSION["user_id"] ?>" src="<?php echo $avatar ?>" width=300, height=300>
        <form method="post" action="home.php" enctype="multipart/form-data">
            <div class="buttons">
                <div class="button two">
                    <button type="submit" id="homeBtn1" class="btn" name="send_edit">Изменить</button>
                    <button type="submit" id="homeBtn2" class="btn" name="logout">Выйти</button>
                </div>
            </div>
        </form>
    <?php } ?>
</div>
</body>
</html>