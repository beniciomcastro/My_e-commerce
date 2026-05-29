<?php
session_start();

if (isset($_SESSION['ultimo_adicionado'])) {

    $id = (int) $_SESSION['ultimo_adicionado']['id'];
    $quantidade = (int) $_SESSION['ultimo_adicionado']['quantidade'];

    if (isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id] -= $quantidade;

        if ($_SESSION['carrinho'][$id] <= 0) {
            unset($_SESSION['carrinho'][$id]);
        }
    }

    unset($_SESSION['ultimo_adicionado']);
}

header("Location: loja.php?msg=desfeito");
exit;