<?php
session_start();

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$quantidade = isset($_POST['quantidade']) ? (int) $_POST['quantidade'] : 1;

if ($id > 0) {
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    if ($quantidade <= 0) {
        unset($_SESSION['carrinho'][$id]);
    } else {
        $_SESSION['carrinho'][$id] = $quantidade;
    }
}

echo "ok";