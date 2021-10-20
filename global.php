<?php

error_reporting(E_ALL);
session_start();
console_log($_SESSION);
//console_log($_COOKIE);
check_authorization();

$username = "";
$email = "";
$name = "";
$avatar = "";
$errors = array();

function console_log($data)
{
    echo '<script>';
    echo 'console.log(' . json_encode($data) . ')';
    echo '</script>';
}

function gen_key()
{
    $alf = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $len = strlen($alf);
    $rez = "";
    for ($i = 0; $i < 50; ++$i)
        $rez .= $alf[random_int(0, $len - 1)];
    return $rez;
}

function gen_tok() {
    $alf = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $len = strlen($alf);
    $rez = "";
    for ($i = 0; $i < 100; ++$i)
        $rez .= $alf[random_int(0, $len - 1)];
    return $rez;
}

function uploadFileToTheServer($username) {
    $uploadDir = '../images/';
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
    return $uploadFile;
}

function check_authorization()
{
    if (!isset($_SESSION["user_id"]) && isset($_COOKIE["key"])) {
        $key = $_COOKIE["key"];
        $database = new mysqli("localhost", "root", "", "web4");
        $query = "SELECT user_id FROM authorization WHERE auth_key ='$key'";
        if ($result = $database->query($query)) {
            if ($arr = $result->fetch_assoc()) {
                $_SESSION["user_id"] = $arr["user_id"];
            }
        }
        $database->close();
    }
}

?>
