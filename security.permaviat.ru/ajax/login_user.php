<?php
include("../settings/connect_datebase.php");

$login = $_POST['login'];
$password = $_POST['password'];

// ищем пользователя
$query_user = $mysqli->query("SELECT * FROM `users` WHERE `login`='".$login."' AND `password`= '".$password."';");

$id = -1;
while($user_read = $query_user->fetch_row()) {
    $id = $user_read[0];
}

if($id != -1) {
    // генерируем безопасный токен
    $token = bin2hex(random_bytes(32));
    
    // сохраняем в куки (httponly, samesite)
    setcookie("auth_token", $token, [
        'expires' => time() + 3600,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    
    // сохраняем токен в БД
    $mysqli->query("UPDATE `users` SET `auth_token` = '$token' WHERE `id` = $id");
}

echo md5(md5($id));
?>