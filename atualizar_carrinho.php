<?php
session_start();
include "conexao.php";

$id = $_GET['id'];
$acao = $_GET['acao'];

if (!isset($_SESSION['carrinho'][$id])) {
    header("Location: carrinho.php");
    exit;
}

// busca estoque no banco
$sql = "SELECT estoque FROM produtos WHERE id = $id";
$res = mysqli_query($con, $sql);
$p = mysqli_fetch_assoc($res);

$qtd = $_SESSION['carrinho'][$id];

if ($acao == "mais") {
    if ($qtd < $p['estoque']) {
        $_SESSION['carrinho'][$id]++;
    }
}

if ($acao == "menos") {
    if ($qtd > 1) {
        $_SESSION['carrinho'][$id]--;
    }
}

// se quiser remover quando chegar em 0 (opcional)
// if ($qtd <= 1 && $acao == "menos") {
//     unset($_SESSION['carrinho'][$id]);
// }

header("Location: carrinho.php");
exit;