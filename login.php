<?php
session_start();
require_once("db.php");
$login =$_POST['login']??"";
$password =$_POST['password']??"";
$error = "";

if(empty($login) ||empty($password)){
    $error = "Заполне все";
}else{
    if($login == '2' || $password == '2'){
        $_SESSION['admin'] = TRUE;
        $_SESSION['admin_name'] = "Администратор";
        header("Location: index_admin.php");
        exit;
    }
    else{
        $sql = "SELECT * FROM `user` WHERE login = '$login'";
        $result = $conn->query($sql);

        if($result && $result->num_rows > 0){
            $user = $result->fetch_assoc();
            if(password_verify($password , $user['password'])){
                $_SESSION['user'] = $user['id'];
                $_SESSION['user_name'] = $user['fio_name'];
                $_SESSION['user_login'] = $user['login'];
                header("Location: index_name.php");
                exit;
            }else{
                $error ="Не правильный пароль";
            }
        }else{
            $error= "Ошибка" .$conn->error;
        }
    }
}
 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if(!empty($error)):?>
        <div class="error"><?php echo $error;?></div>
    <?php endif;?>
    <form action="" method="post">
        <input type="text" name="login" placeholder="Логин">
        <input type="password" name="password" placeholder="Пароль">
        <button type="submit">Загестрироваться</button>
    </form>
</body>
</html>