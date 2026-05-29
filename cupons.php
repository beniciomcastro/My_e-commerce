<?php
include "conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = mysqli_real_escape_string($con, $_POST['codigo']);
    $tipo = mysqli_real_escape_string($con, $_POST['tipo']);
    $valor = (float) $_POST['valor'];
    $valor_minimo = (float) ($_POST['valor_minimo'] ?? 0);
    $ativo = mysqli_real_escape_string($con, $_POST['ativo']);

    mysqli_query($con, "
        INSERT INTO cupons (codigo, tipo, valor, valor_minimo, ativo)
        VALUES ('$codigo', '$tipo', '$valor', '$valor_minimo', '$ativo')
    ");

    header("Location: cupons.php");
    exit;
}

$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;

if ($pagina < 1) {
    $pagina = 1;
}

$limite = 10;
$offset = ($pagina - 1) * $limite;

$totalRes = mysqli_query($con, "SELECT COUNT(*) AS total FROM cupons");
$totalRow = mysqli_fetch_assoc($totalRes);
$totalRegistros = $totalRow['total'];

$totalPaginas = ceil($totalRegistros / $limite);

$res = mysqli_query($con, "
    SELECT * FROM cupons 
    ORDER BY criado_em DESC
    LIMIT $limite OFFSET $offset
");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cupons</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/x-icon" href="uploads/icon.png">
</head>

<body class="admin-body">

<div class="pedidos-topo">

    <a href="admin_home.php">
        Voltar ao painel
    </a>

</div>

<h1>Cupons</h1>

<form method="POST" class="form-container">

    <input 
        type="text" 
        name="codigo" 
        placeholder="Código do cupom" 
        required>

    <select name="tipo" id="tipoCupom" required>
        <option value="porcentagem">Porcentagem</option>
        <option value="fixo">Valor fixo</option>
    </select>

    <input 
        type="number" 
        name="valor" 
        step="0.01" 
        placeholder="Valor do desconto"
        required>

    <input 
        type="number" 
        name="valor_minimo" 
        step="0.01" 
        placeholder="Valor mínimo do carrinho">

    <select name="ativo">
        <option value="sim">Ativo</option>
        <option value="nao">Inativo</option>
    </select>

    <button type="submit">
        Criar cupom
    </button>

</form>

<table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Tipo</th>
            <th>Valor</th>
            <th>Valor mínimo</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>

        <?php while ($c = mysqli_fetch_assoc($res)) { ?>

        <tr>
            <td><?= $c['codigo'] ?></td>

            <td><?= $c['tipo'] ?></td>

            <td>
                <?php if ($c['tipo'] === 'porcentagem') { ?>

                    <?= number_format($c['valor'], 0, ',', '.') ?>%

                <?php } else { ?>

                    R$ <?= number_format($c['valor'], 2, ',', '.') ?>

                <?php } ?>
            </td>

            <td>
                R$ <?= number_format($c['valor_minimo'], 2, ',', '.') ?>
            </td>

            <td><?= $c['ativo'] ?></td>

            <td>
                <a 
                    href="editar_cupom.php?id=<?= $c['id'] ?>" 
                    class="btn-editar">
                    Editar
                </a>

                <a 
                    href="excluir_cupom.php?id=<?= $c['id'] ?>"
                    onclick="return confirm('Excluir cupom?')"
                    class="btn-excluir-cupom">
                    Excluir
                </a>
            </td>
        </tr>

        <?php } ?>

    </tbody>
</table>

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