<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "conexao.php";

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$qtd = isset($_POST['quantidade']) ? (int) $_POST['quantidade'] : 1;

if ($id <= 0) {
    die("ID inválido");
}

if ($qtd < 1) {
    $qtd = 1;
}

// buscar estoque real
$sql = "SELECT estoque FROM produtos WHERE id = $id";
$res = mysqli_query($con, $sql);

if (!$res) {
    die("Erro SQL: " . mysqli_error($con));
}

$p = mysqli_fetch_assoc($res);

if (!$p) {
    die("Produto não encontrado");
}

$estoque = (int) $p['estoque'];

// criar carrinho
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// quantidade já existente no carrinho
$qtdAtual = isset($_SESSION['carrinho'][$id]) ? (int) $_SESSION['carrinho'][$id] : 0;

// não deixar passar do estoque
$qtdPermitida = $estoque - $qtdAtual;

if ($qtdPermitida <= 0) {
    header("Location: loja.php?msg=estoque_limite");
    exit;
}

if ($qtd > $qtdPermitida) {
    $qtd = $qtdPermitida;
}

// adicionar ao carrinho
$_SESSION['carrinho'][$id] = $qtdAtual + $qtd;

// salvar último item adicionado para permitir desfazer
$_SESSION['ultimo_adicionado'] = [
    'id' => $id,
    'quantidade' => $qtd
];

unset($_SESSION['pedido_processado']);

header("Location: loja.php?msg=adicionado");
exit;