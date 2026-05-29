<?php
include "conexao.php";

$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;

if ($pagina < 1) {
    $pagina = 1;
}

$limite = 10;
$offset = ($pagina - 1) * $limite;

$totalRes = mysqli_query($con, "SELECT COUNT(*) AS total FROM pedidos");
$totalRow = mysqli_fetch_assoc($totalRes);
$totalRegistros = $totalRow['total'];

$totalPaginas = ceil($totalRegistros / $limite);

$res = mysqli_query($con, "
    SELECT * FROM pedidos 
    ORDER BY criado_em DESC
    LIMIT $limite OFFSET $offset
");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Pedidos</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/x-icon" href="uploads/icon.png">
</head>

<body class="admin-body">

<div class="pedidos-wrapper">

    <div class="pedidos-topo">

        <h1>Pedidos</h1>

        <a href="admin_home.php">
            Voltar ao painel
        </a>

    </div>

    <?php if(mysqli_num_rows($res) > 0) { ?>

    <table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Pagamento</th>
                <th>Prazo</th>
                <th>Status</th>
                <th>Data</th>
            </tr>
        </thead>

        <tbody>

            <?php while ($p = mysqli_fetch_assoc($res)) { ?>

            <tr>

                <td>
                    #<?= $p['id'] ?>
                </td>

                <td>
                    <?= $p['cliente_nome'] ?>
                </td>

                <td class="pedido-total">
                    R$ <?= number_format($p['total'], 2, ',', '.') ?>
                </td>

                <td class="pedido-pagamento">
                    <?= $p['forma_pagamento'] ?>
                </td>

                <td>
                    <?= $p['prazo_entrega'] ?> dias úteis
                </td>

                <td>
                    <span class="status-pedido aprovado">
                        <?= $p['status'] ?>
                    </span>
                </td>

                <td class="pedido-data">
                    <?= date('d/m/Y H:i', strtotime($p['criado_em'])) ?>
                </td>

            </tr>

            <?php } ?>

        </tbody>

    </table>
    

    <?php } else { ?>

    <div class="sem-pedidos">

        <h2>Nenhum pedido encontrado</h2>

        <p>
            Os pedidos aprovados aparecerão aqui.
        </p>

    </div>

    <?php } ?>

</div>

<div class="paginacao">
    <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
        <a 
            href="?pagina=<?= $i ?>"
            class="<?= $i == $pagina ? 'ativo' : '' ?>">
            <?= $i ?>
        </a>
    <?php } ?>
</div>

</body>
</html>