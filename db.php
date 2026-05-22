<?php
$servername = "MYSQL-8.0";
$dbname ="1.3";
$username = "root";
$passname = "";

$conn = mysqli_connect($servername,$username,$passname,$dbname);

if(!$conn){
    die("Ошибка" .$conn->error);
}else{
    echo "";
}
?>