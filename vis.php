<?php
session_start();
require_once("db.php");
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user'];
$error = "";
$user_name = $_SESSION['user_name'] ?? $_SESSION['user_login'] ?? 'Гость';
$sql = "SELECT * FROM `user_1` WHERE user_id = '$user_id'";
$result = $conn->query($sql);
$events = array();

if($result && $result->num_rows >0){
    while($row = $result->fetch_assoc()){
        $events[] =$row;
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
    <form action="" method="post">
        <table border =1>
            <thead>
                <tr>
                    <th>Адрес дома</th>
                    <th>Дата и время</th>
                    <th>Телефон</th>
                    <th>Услги</th>
                    <th>Оплата</th>
                    <th>Иная услга</th>
                    <th>Статус</th>
                    <th>Коментанрий</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($events)):?>
                <?php foreach($events as $event):?>
                <tr>
                    <td><?php echo htmlspecialchars($event['email_a'] ?? '');?></td>
                    <td><?php echo htmlspecialchars($event['datetime'] ?? '');?></td>
                    <td><?php echo htmlspecialchars($event['telephone'] ?? '');?></td>
                    <td><?php echo htmlspecialchars($event['type'] ?? '');?></td>
                    <td><?php echo htmlspecialchars($event['paym'] ?? '');?></td>
                    <td><?php echo htmlspecialchars($event['dlock'] ?? '');?></td>
                    <td><?php echo htmlspecialchars($event['status'] ?? '');?></td>
                    <td><?php echo htmlspecialchars($event['commit'] ?? '');?></td>
                </tr>
                <?php endforeach;?>
                <?php else:?>
                    <tr>
                        <td colspan ='8'>Нет заяки</td>
                    </tr>
                <?php endif;?>
            </tbody>
        </table>
    </form>
</body>
</html>