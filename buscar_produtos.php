<?php
include "conexao.php";

session_start();

if (!isset($_SESSION['seed'])) {
    $_SESSION['seed'] = rand();
}

$seed = $_SESSION['seed'];

$termo = $_GET['q'] ?? '';
$termo = strtolower($termo);
$termo = mysqli_real_escape_string($con, $termo);

$sql = "SELECT * FROM produtos 
        WHERE status = 'ativo' 
        AND estoque > 0";

if ($termo !== '') {
    $sql .= " AND (
        LOWER(nome) LIKE '%$termo%' 
        OR LOWER(descricao) LIKE '%$termo%'
        OR LOWER(categoria) LIKE '%$termo%'
    )";
}

$sql .= " ORDER BY RAND($seed) LIMIT 20";

$result = mysqli_query($con, $sql);

while ($p = mysqli_fetch_assoc($result)) {
?>

<div class="card" data-nome="<?= strtolower($p['nome']) ?>">

    <?php if ($p['imagem']) { ?>
        <img src="uploads/<?= $p['imagem'] ?>">
    <?php } ?>

    <h2><?= $p['nome'] ?></h2>

    <div class="descricao-produto">
        <p><?= $p['descricao'] ?></p>
        <button type="button" class="ver-mais">ver mais</button>
    </div>

    <div class="descricao-modal">
        <div class="descricao-caixa">
            <button type="button" class="fechar-descricao">×</button>
            <h3><?= $p['nome'] ?></h3>
            <p><?= $p['descricao'] ?></p>
        </div>
    </div>

    <span class="preco">
        R$ <?= number_format($p['preco'], 2, ',', '.') ?>
    </span>

    <p>Estoque: <?= $p['estoque'] ?></p>

    <form action="adicionar_carrinho.php" method="POST">
        <input type="hidden" name="id" value="<?= $p['id'] ?>">

        <input 
            type="number"
            name="quantidade"
            value="1"
            min="1"
            max="<?= $p['estoque'] ?>">

        <button 
            type="button"
            class="btn-adicionar-card">
            Adicionar
        </button>
    </form>

</div>

<?php } ?>