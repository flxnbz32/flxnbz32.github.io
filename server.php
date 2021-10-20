<?php

include('global.php');

// get data from db if cookie['key'] was set - done
if (isset($_SESSION['user_id'])) {
    $url = $_SERVER['REQUEST_URI'];
    if (strpos($url, "home")) {
        $database = new mysqli("localhost", "root", "", "web4");
        $id = $_SESSION['user_id'];
        $query = "SELECT auth_key FROM authorization WHERE user_id='$id'";
        if ($result = $database->query($query)) {
            if ($arr = $result->fetch_assoc()) {
                $key = $arr['auth_key'];
                setcookie("key", $key, time() + 60 * 60 * 24 * 365);
                $query = "SELECT * FROM users WHERE id='$id'";
                if ($result = $database->query($query)) {
                    $arr = $result->fetch_assoc();
                    $username = $arr['username'];
                    $email = $arr['email'];
                    $name = $arr['realname'];
                    $avatar = $arr['avatar'];
                }
            }
        }
        else {
            header("location: login.php");
            exit;
        }
    }
    if (strpos($url, "edit")) {
        $database = new mysqli("localhost", "root", "", "web4");
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE id='$id'";
        if ($result = $database->query($query)) {
            $arr = $result->fetch_assoc();
            $username = $arr['username'];
            $email = $arr['email'];
            $name = $arr['realname'];
            $avatar = $arr['avatar'];
        }
        else {
            header("location: login.php");
            exit;
        }
    }
}

// block-none
if (isset($_POST['reg'])) {
    if (isset($_SESSION['but'])) {
        unset($_SESSION['but']);
    } else {
        $_SESSION['but'] = "but";
    }
}

// LOGIN - done
if (isset($_POST["login"])) {
    $database = new mysqli("localhost", "root", "", "web4");
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username)) {
        array_push($errors, "Требуется ввести логин");
    }
    if (empty($password)) {
        array_push($errors, "Требуется ввести пароль");
    }
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT id, username FROM users WHERE username = '$username' AND password='$password'";
        if ($result = $database->query($query)) {
            if ($result->num_rows) {
                console_log($result);
                $arr = $result->fetch_assoc();
                $id = $arr['id'];
                $_SESSION['user_id'] = $id;
                $key = gen_key();
                $query = "INSERT INTO authorization (auth_key , user_id) values ('$key', '$id')";
                $database->query($query);
//                autorization($arr['id'], $database, $arr['username']);
                $database->close();
                $_SESSION['success'] = "Авторизация прошла успешно";
                header("location: home.php");
                exit;
            } else {
                $database->close();
                array_push($errors, "Неверный логин или пароль");
                console_log("Неверный логин или пароль");
            }
        } else {
            $database->close();
            array_push($errors, "Неверный логин или пароль");
            console_log("Неверный логин или пароль");
        }
    }
}

// LOGOUT - done
if (isset($_POST["logout"])) {
    if (isset($_COOKIE["key"]) || isset($_SESSION["user_id"])) {
        $key = $_COOKIE["key"];
        $id = $_SESSION["user_id"];
        setcookie("key", "", 1);
        unset($_SESSION["user_id"]);
        $database = new mysqli("localhost", "root", "", "web4");
        $query = "DELETE FROM authorization WHERE auth_key = '$key' OR user_id = '$id'";
        $database->query($query);
        $database->close();
        header("location: login.php");
        exit;
    }
}

// go to "edit settings" - done
if (isset($_POST['send_edit'])) {
    header("location: edit_settings.php");
    exit;
}

// edit - done
if (isset($_POST["edit"])) {
    $database = new mysqli("localhost", "root", "", "web4");
    $id = $_SESSION["user_id"];
    $email = $_POST["email"];
    $name = $_POST["name"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];
    $avatar = $_FILES["file_upload"]["name"];
    if (empty($email)) {
        array_push($errors, "Требуется ввести E-mail");
    }
    if (empty($name)) {
        array_push($errors, "Требуется ввести ФИО");
    }
    if ($password1 != $password2) {
        array_push($errors, "Пароли не совпадают");
    }
    if (!count($errors)) {
        if (!empty($avatar)) {
            $uploadFile = "";
            if (isset($_FILES) && $_FILES['file_upload']['error'] == 0) {
                $uploadDir = './images/';
                $fileName = $username . "_" . $_FILES['file_upload']['name'];
                $uploadFile = $uploadDir . basename($fileName);
                console_log($fileName);
                console_log($uploadFile);
                console_log($_FILES["file_upload"]["tmp_name"]);
                if (copy($_FILES['file_upload']['tmp_name'], $uploadFile)) {
                    console_log("Файл успешно загружен на сервер");
                } else {
                    console_log("Ошибка! Не удалось загрузить файл на сервер!");
                    exit;
                }
//                $uploadFile = uploadFileToTheServer($username);
            }
            $query = "UPDATE users SET avatar='$uploadFile' WHERE id='$id'";
            $database->query($query);
        }
        if (!empty($password1)) {
            $password = md5($password1);
            $query = "UPDATE users SET password='$password' WHERE id='$id'";
            // todo
            $database->query($query);
        }
        $query = "UPDATE users SET username='$username', email='$email', realname='$name' WHERE id='$id'";
        $database->query($query);
        $database->close();
        $_SESSION['success'] = "Изменения прошли успешно";
        header("location: home.php");
        exit;
    }
}

// REGISTRATION - done
if (isset($_POST["register"])) {
    $database = new mysqli("localhost", "root", "", "web4");

    $username = $_POST["username"];
    $email = $_POST["email"];
    $name = $_POST["name"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];
    $avatar = $_FILES["file_upload"]["name"];

    //console_log($_POST["file_upload"]);

    if (empty($username)) {
        array_push($errors, "Требуется ввести логин");
    }
    if (empty($email)) {
        array_push($errors, "Требуется ввести E-mail");
    }
    if (empty($name)) {
        array_push($errors, "Требуется ввести ФИО");
    }
    if (empty($password1)) {
        array_push($errors, "Требуется ввести пароль");
    }
    if ($password1 != $password2) {
        array_push($errors, "Пароли не совпадают");
    }
    if (empty($avatar)) {
        array_push($errors, "Требуется загрузить изображение (аватар)");
    }

    if (count($errors) == 0) {
        console_log($_FILES);
        if (isset($_FILES) && $_FILES['file_upload']['error'] == 0) {
            $uploadDir = './images/';
            $fileName = $username . "_" . $_FILES['file_upload']['name'];
            $uploadFile = $uploadDir . basename($fileName);
            console_log($fileName);
            console_log($uploadFile);
            console_log($_FILES["file_upload"]["tmp_name"]);
            if (copy($_FILES['file_upload']['tmp_name'], $uploadFile)) {
                console_log("Файл успешно загружен на сервер");
            } else {
                console_log("Ошибка! Не удалось загрузить файл на сервер!");
                exit;
            }
        }
        $query = "SELECT * FROM users WHERE username='$username'";
        $result = $database->query($query)->num_rows;
        console_log($result);
        if ($result == 0) {
            $password = md5($password1);
            $query = "INSERT INTO users (username, password, realname, email, avatar) 
            values('$username', '$password', '$name', '$email', '$uploadFile')";
            console_log($query);
            if ($result = $database->query($query)) {
                console_log($result);
                $database->close();
                $_SESSION['success'] = "Регистрация прошла успешно";
                header("location: ./login.php");
                exit;
            } else {
                array_push($errors, "Что-то пошло нетак");
                $database->close();
            }
        } else {
            array_push($errors, "Такой пользователь уже существует");
        }
    }
}

// cancel edit settings - done
if (isset($_POST['cancel_edit'])) {
    header("location: home.php");
    exit;
}

// cancel restore password - done
if (isset($_POST['cancel_restore'])) {
    header("location: login.php");
    exit;
}

if (isset($_POST['cancel_restoration'])) {
    header("location: login.php");
    exit;
}

if (isset($_POST['next'])) {
    $username = $_POST['username'];
    $database = new mysqli("localhost", "root", "", "web4");
    if (empty($username)) {
        array_push($errors, "Требуется ввести логин");
    }
    if (count($errors) == 0) {
        $query = "SELECT * FROM users WHERE username='$username'";
        $result = $database->query($query);
        $arr = $result->fetch_assoc();
        if ($result->num_rows == 1) {

            // $password = md5($password1);
            // $query = "UPDATE users SET password='$password' WHERE username='$username'";
            // $result = $database->query($query);
            //if ($result) {
                $tok = gen_tok();
                $query = "UPDATE users SET token='$tok' WHERE username='$username'";
                $result = $database->query($query);
                if ($result) {
//                    $_SESSION['user_id'] = $arr['id'];
                    $_SESSION['token'] = $tok;
                    $_SESSION['link'] = $tok;
                } else {
                    array_push($errors, "Что-то пошло нетак");
                }
//                $_SESSION['success'] = "Password was restored";
//                header('location: login.php');
//                exit;
            // } else {
            //     array_push($errors, "Something went wrong");
            // }
        } else {
            array_push($errors, "Такой пользователь не найден");
        }
    }

}

// restore password - done
if (isset($_POST['restore'])) {
    $database = new mysqli("localhost", "root", "", "web4");
//    $username = $_POST["username"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];

//    if (empty($username)) {
//        array_push($errors, "Username is required");
//    }
    if (empty($password1)) {
        array_push($errors, "Требуется ввести пароль");
    }
    if ($password1 != $password2) {
        array_push($errors, "Пароли не совпадаются");
    }
    if (count($errors) == 0) {
        $tok = $_SESSION['token'];
        $query = "SELECT * FROM users WHERE token='$tok'";
        $result = $database->query($query);
        $arr = $result->fetch_assoc();
        if ($result->num_rows == 1) {
            $password = md5($password1);
            $query = "UPDATE users SET password='$password' WHERE token='$tok'";
            $result = $database->query($query);
            if ($result) {
                //  Удаляем пользователя, авторизованного с других устройств
                $id = $arr['id'];
                $query = "DELETE FROM authorization WHERE user_id='$id'";
                $database->query($query);

                $_SESSION['user_id'] = $arr['id'];
                $_SESSION['success'] = "Пароль восстановлен";
                unset($_SESSION['token']);
                header('location: login.php');
                exit;
            } else {
                array_push($errors, "Что-то пошло нетак");
            }
        } else {
            array_push($errors, "Пользователь не существует");
        }
    }
}
?>