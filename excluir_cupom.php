<?php
include "conexao.php";

$id = (int) ($_GET['id'] ?? 0);

if ($id > 0) {
    mysqli_query($con, "DELETE FROM cupons WHERE id = $id");
}

header("Location: cupons.php");
exit;