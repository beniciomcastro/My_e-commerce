<?php
$host = "db";
$user = "root";
$pass = "root";
$db = "produtos";

$con = mysqli_connect($host, $user, $pass, $db);

if (!$con) {
    die("Erro de conexão: " . mysqli_connect_error());
}
?>