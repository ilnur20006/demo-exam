<?php
session_start();
require_once("db.php");
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user'];
$error=  "";
$succes = "";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email_a =$_POST['email_a']??"";
    $datetime =$_POST['datetime']??"";
    $telephone =$_POST['telephone']??"";
    $type =$_POST['type']??"";
    $paym =$_POST['paym']??"";
    $dlock =$_POST['block']??"";

    if(empty($email_a) ||empty($datetime) ||empty($telephone) ||empty($type) ||empty($paym) ){

    }elseif(!preg_match('/^\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}$/', $telephone)){
        $error="Телефон в формате +7(XXX)-XXX-XX-XX";
    }else{
        $sql = "INSERT INTO user_1 (user_id,email_a,datetime,telephone,paym,type,dlock,status,commit,at) VALUES ('$user_id','$email_a','$datetime','$telephone','$paym','$type','$dlock','Ожидается','',NOW())";
        if($conn->query($sql) == TRUE){
            $succes ="Заявления на рамотрений";
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
    <link rel="stylesheet" href="css/stype.css">
    <title>Document</title>
</head>
<body>
    <?php if(!empty($succes)):?>
        <div class="succes"><?php echo $succes;?></div>
    <?php endif;?>
    <?php if(!empty($error)):?>
        <div class="error"><?php echo $error;?></div>
    <?php endif;?>
    <form action="" method="post">
        <input type="text" name="email_a" placeholder="Адрес дома">
        <input type="datetime-local" name="datetime">
        <input type="telephone" name="telephone" placeholder="Телефон">
        <select name="type" id="">
            <option value="">Вид услуг</option>
            <option value="общий клининг">общий клининг</option>
            <option value="генеральная уборка">генеральная уборка</option>
            <option value="послестроительная уборка">послестроительная уборка</option>
            <option value="химчистка ковров и мебели">химчистка ковров и мебели</option>
        </select>
        <select name="paym" id="">
            <option value="">Оплата</option>
            <option value="наличные">наличные</option>
            <option value="банковская карта">банковская карта</option>

        </select>
            <input type="checkbox" id="other_checkbox">Иная услга
            <textarea class="block" name="dlock"  id="other_blokc"></textarea>
            <button type="submit">Отправить заявку</button>
    </form>
    <script src="js/stype.js"></script>
</body>
</html>