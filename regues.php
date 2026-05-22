<?php
require_once("db.php");
$login =$_POST['login']??"";
$fio_name =$_POST['fio_name']??"";
$telphone =$_POST['telphone']??"";
$email =$_POST['email']??"";
$password =$_POST['password']??"";
$error = "";
if(empty($login) ||empty($fio_name) ||empty($telphone) ||empty($email) ||empty($password)){
    $error = "Заполне все";
}
elseif(!preg_match('/^[А-Яа-яЁё\s\-]+$/u', $fio_name)){
    $error="ФИО должен быть в кирилицу и пробел";
}
elseif(!preg_match('/^\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}$/', $telphone)){
    $error="Телефон в формате +7(XXX)-XXX-XX-XX";
}
elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $error="Адерс не коректный";
}
elseif(strlen($password) < 6){
    $error="Пароль должен быть от 6 символов";
}else{
        $sql = "SELECT * FROM `user` WHERE login = '$login'";
        $result = $conn->query($sql);

        if($result && $result->num_rows > 0){
            $error ="Такой уже $login. Выберете другой логин.";
        }
        else{
        $sql = "SELECT * FROM `user` WHERE email = '$email'";
        $result = $conn->query($sql);

        if($result && $result->num_rows > 0){
            $error ="Такой уже $login. Выберете другой логин.";
        }
            else{
                $password= password_hash($password , PASSWORD_DEFAULT);
                $sql = "INSERT INTO user (login,fio_name,telphone,email,password) VALUES ('$login','$fio_name','$telphone','$email','$password')";
                if($conn->query($sql) == TRUE){
                    header("Location: login.php");
                }else{
                    $error= "Ошибка" .$conn->error;
                }
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
        <input type="text" name="fio_name" placeholder="ФИО">
        <input type="telphone" name="telphone" placeholder="Телефон">
        <input type="email" name="email" placeholder="Адрес эл.пч">
        <input type="password" name="password" placeholder="Пароль">
        <button type="submit">Загестрироваться</button>
    </form>
</body>
</html>