<?php
session_start();
include "conexao.php";

header("Content-Type: application/json");

$id = $_POST['id'] ?? null;
$qtd = $_POST['quantidade'] ?? 1;

$id = (int) $id;
$qtd = (int) $qtd;

if ($id <= 0) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "ID inválido."
    ]);
    exit;
}

if ($qtd < 1) {
    $qtd = 1;
}

$sql = "SELECT estoque FROM produtos WHERE id = $id";
$res = mysqli_query($con, $sql);

if (!$res) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Erro ao buscar produto."
    ]);
    exit;
}

$p = mysqli_fetch_assoc($res);

if (!$p) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Produto não encontrado."
    ]);
    exit;
}

$estoque = (int) $p['estoque'];

if ($estoque <= 0) {
    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Produto sem estoque."
    ]);
    exit;
}

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

$quantidadeAtual = $_SESSION['carrinho'][$id] ?? 0;
$novaQuantidade = $quantidadeAtual + $qtd;

if ($novaQuantidade > $estoque) {
    $novaQuantidade = $estoque;
}

$_SESSION['carrinho'][$id] = $novaQuantidade;

$_SESSION['ultimo_adicionado'] = [
    'id' => $id,
    'quantidade' => $qtd
];

unset($_SESSION['pedido_processado']);

echo json_encode([
    "sucesso" => true,
    "mensagem" => "Produto adicionado ao carrinho."
]);
exit;