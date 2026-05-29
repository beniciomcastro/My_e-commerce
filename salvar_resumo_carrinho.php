<?php
session_start();

$frete = $_POST['frete'] ?? 0;
$desconto = $_POST['desconto'] ?? 0;
$total = $_POST['total'] ?? 0;
$cep = $_POST['cep'] ?? '';
$cupom = $_POST['cupom'] ?? '';
$freteNome = $_POST['frete_nome'] ?? '';
$fretePrazo = $_POST['frete_prazo'] ?? '';
$selecionados = $_POST['selecionados'] ?? [];

if (!is_array($selecionados)) {
    $selecionados = [];
}

$_SESSION['resumo_carrinho'] = [
    'frete' => $frete,
    'desconto' => $desconto,
    'total' => $total,
    'cep' => $cep,
    'cupom' => $cupom,
    'frete_nome' => $freteNome,
    'frete_prazo' => $fretePrazo,
    'selecionados' => $selecionados
];

echo "ok";
