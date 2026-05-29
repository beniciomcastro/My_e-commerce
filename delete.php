<?php
include "conexao.php";

$id = $_GET['id'];

$sql = "DELETE FROM produtos WHERE id = $id";
mysqli_query($con, $sql);

header("Location: index.php");
?>