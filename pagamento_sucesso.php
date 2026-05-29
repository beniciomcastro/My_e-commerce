<?php
session_start();
include "conexao.php";

if (isset($_SESSION['pedido_processado'])) {
    header("Location: loja.php");
    exit;
}

$_SESSION['pedido_processado'] = true;

$nome = $_POST['nome'] ?? '';
$cep = $_POST['cep'] ?? '';
$endereco = $_POST['endereco'] ?? '';
$cidade = $_POST['cidade'] ?? '';
$numero = $_POST['numero'] ?? '';
$complemento = $_POST['complemento'] ?? '';
$formaPagamento = $_POST['forma_pagamento'] ?? '';
$totalPago = isset($_POST['total_com_frete'])
    ? (float) $_POST['total_com_frete']
    : 0;
$prazoEntrega = $_POST['prazo_entrega'] ?? '';

$sqlPedido = "INSERT INTO pedidos 
(cliente_nome, cep, endereco, cidade, numero, complemento, forma_pagamento, total, prazo_entrega)
VALUES
('$nome', '$cep', '$endereco', '$cidade', '$numero', '$complemento', '$formaPagamento', '$totalPago', '$prazoEntrega')";

mysqli_query($con, $sqlPedido);

$prazoEntrega = $_POST['prazo_entrega'] ?? '';

if (isset($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $id => $qtd) {
        $id = (int) $id;
        $qtd = (int) $qtd;

        if ($id > 0 && $qtd > 0) {
            mysqli_query(
                $con,
                "UPDATE produtos 
                 SET estoque = estoque - $qtd 
                 WHERE id = $id 
                 AND estoque >= $qtd"
            );
        }
    }
}

unset($_SESSION['carrinho']);
unset($_SESSION['resumo_carrinho']);
unset($_SESSION['ultimo_adicionado']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pagamento</title>

<style>
body {
    margin: 0;
    height: 100vh;
    background: #0f172a;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: Arial, Helvetica, sans-serif;
    transition: 0.6s;
}

.caixa {
    text-align: center;
}

.loader {
    width: 55px;
    height: 55px;
    border: 6px solid rgba(255,255,255,0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: girar 1s linear infinite;
    margin: 0 auto 20px;
}

.check {
    display: none;
    font-size: 70px;
    margin-bottom: 20px;
}

body.aprovado {
    background: #16a34a;
}

body.aprovado .loader {
    display: none;
}

body.aprovado .check {
    display: block;
}

@keyframes girar {
    to {
        transform: rotate(360deg);
    }
}

a {
    display: none;
    margin-top: 20px;
    color: white;
    font-weight: bold;
}
body.aprovado a {
    display: inline-block;
}
.prazo-entrega {
    display: none;
    font-size: 18px;
    margin-top: 12px;
}

body.aprovado .prazo-entrega {
    display: block;
}
</style>
  <link rel="icon" type="image/x-icon" href="uploads/icon.png">

<body>

<div class="caixa">
    <div class="loader"></div>
    <div class="check">✓</div>

   <h1 id="mensagem">
    Processando pagamento...
</h1>

<p id="prazoEntrega" class="prazo-entrega">
    <?php if (!empty($prazoEntrega)) { ?>
        Seu pedido chegará em até <?= $prazoEntrega ?> dias úteis.
    <?php } ?>
</p>

    <a href="loja.php">Voltar para a loja</a>
</div>

<script>
setTimeout(function () {
    document.body.classList.add("aprovado");
    document.getElementById("mensagem").textContent = "Pagamento aprovado!";
}, 2500);
</script>

</body>
</html>