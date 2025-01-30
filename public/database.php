<?php
$server = "MySQL-8.2";
$username = "root";
$password = "";
$dbname = "testbd";

$conn = mysqli_connect($server, $username, $password,$dbname);

if(!$conn){
    die("Ошибка подключения". mysqli_connect_error());
}

?> 