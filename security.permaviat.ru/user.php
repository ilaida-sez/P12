<?php
include("./settings/connect_datebase.php");

// проверяем куки вместо сессии
if (isset($_COOKIE['auth_token'])) {
    $token = $_COOKIE['auth_token'];
    $user_query = $mysqli->query("SELECT * FROM `users` WHERE `auth_token` = '$token'");
    
    if ($user_query->num_rows == 0) {
        header("Location: login.php");
        exit();
    }
    
    $user = $user_query->fetch_row();
    
    if($user[3] == 1) {
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE HTML>
<html>
    <head> 
        <script src="https://code.jquery.com/jquery-1.8.3.js"></script>
        <meta charset="utf-8">
        <title> Личный кабинет </title>
        
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="top-menu">
            <a href=# class = "singin"><img src = "img/ic-login.png"/></a>
        
            <a href=#><img src = "img/logo1.png"/></a>
            <div class="name">
                <a href="index.php">
                    <div class="subname">БЗОПАСНОСТЬ  ВЕБ-ПРИЛОЖЕНИЙ</div>
                    Пермский авиационный техникум им. А. Д. Швецова
                </a>
            </div>
        </div>
        <div class="space"> </div>
        <div class="main">
            <div class="content">
                <input type="button" class="button" value="Выйти" onclick="logout()"/>
                <div class="name" style="padding-bottom: 0px;">Личный кабинет</div>
                <div class="description">Добро пожаловать: 
                    <?php
                        echo $user[1];
                    ?>
                    <br>Ваш идентификатор:
                    <?php
                        echo $user[0];
                    ?>
                </div>
            
                <div class="footer">
                    © КГАПОУ "Авиатехникум", 2020
                    <a href=#>Конфиденциальность</a>
                    <a href=#>Условия</a>
                </div>
            </div>
        </div>
        
        <script>
            var id_statement = -1;
            function DeleteStatementt(id_statement) {
                if(id_statement != -1) {
                    
                    var data = new FormData();
                    data.append("id_statement", id_statement);
                    
                    $.ajax({
                        url         : 'ajax/delete_statement.php',
                        type        : 'POST',
                        data        : data,
                        cache       : false,
                        dataType    : 'html',
                        processData : false,
                        contentType : false, 
                        success: function (_data) {
                            console.log(_data);
                            location.reload();
                        },
                        error: function(){
                            console.log('Системная ошибка!');
                        }
                    });
                }
            }
            
            function logout() {
                $.ajax({
                    url         : 'ajax/logout.php',
                    type        : 'POST',
                    data        : null,
                    cache       : false,
                    dataType    : 'html',
                    processData : false,
                    contentType : false, 
                    success: function (_data) {
                        location.reload();
                    },
                    error: function( ){
                        console.log('Системная ошибка!');
                    }
                });
            }
        </script>
    </body>
</html>