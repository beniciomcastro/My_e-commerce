<?php
include "conexao.php";

// página atual
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// não permite página menor que 1
if ($pagina < 1) {
    $pagina = 1;
}

$limite = 20;
$offset = ($pagina - 1) * $limite;

// total de produtos
$total_sql = "SELECT COUNT(*) as total FROM produtos";
$total_res = mysqli_query($con, $total_sql);
$total_row = mysqli_fetch_assoc($total_res);
$total_produtos = $total_row['total'];

// total de páginas
$total_paginas = ceil($total_produtos / $limite);

// evita página maior que o total
if ($pagina > $total_paginas && $total_paginas > 0) {
    $pagina = $total_paginas;
    $offset = ($pagina - 1) * $limite;
}

// busca produtos com limite
$sql = "SELECT * FROM produtos LIMIT $limite OFFSET $offset";
$resultado = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Admin Produtos</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/x-icon" href="uploads/icon.png">
</head>

<body class="admin-body">

<div class="pedidos-topo">

    <a href="admin_home.php">
        Voltar ao painel
    </a>

</div>


<h1 class="h1index">Gerenciar Produtos</h1>

<a href="create.php" class="novo-btn">+ Novo Produto</a>

<table>
<tr>
    <th>Nome</th>
    <th>Preço</th>
    <th>Estoque</th>
    <th>Status</th>
    <th>Ações</th>
</tr>

<?php while($p = mysqli_fetch_assoc($resultado)) { ?>
<tr>
    <td><?= $p['nome'] ?></td>
    <td>R$ <?= $p['preco'] ?></td>
    <td><?= $p['estoque'] ?></td>
    <td><?= $p['status'] ?></td>
    <td>
        <a href="edit.php?id=<?= $p['id'] ?>">Editar</a>
        <a href="delete.php?id=<?= $p['id'] ?>" 
   onclick="return confirm('Tem certeza que deseja excluir este produto?')">
   Excluir
</a>
    </td>
</tr>
<?php } ?>

</table>
<div style="text-align:center; margin:20px;">

    <!-- ANTERIOR -->
    <?php if ($pagina > 1): ?>
        <a href="?pagina=<?= $pagina - 1 ?>">Anterior</a>
    <?php endif; ?>

    <!-- NÚMEROS -->
    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
        <a href="?pagina=<?= $i ?>" 
           style="<?= $i == $pagina ? 'font-weight:bold; text-decoration:underline;' : '' ?>">
           <?= $i ?>
        </a>
    <?php endfor; ?>

    <!-- PRÓXIMO -->
    <?php if ($pagina < $total_paginas): ?>
        <a href="?pagina=<?= $pagina + 1 ?>">Próximo</a>
    <?php endif; ?>

</div>

</body>
</html>