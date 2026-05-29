<?php
include "conexao.php";

session_start();

if (!isset($_SESSION['seed'])) {
    $_SESSION['seed'] = rand();
}

$seed = $_SESSION['seed'];

$categoria = $_GET['categoria'] ?? '';

$sql_base = "FROM produtos WHERE status = 'ativo' AND estoque > 0";

if (!empty($categoria)) {
    $sql_base .= " AND LOWER(categoria) LIKE '%$categoria%'";
}

$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

if ($pagina < 1) {
    $pagina = 1;
}

$limite = 15;
$offset = ($pagina - 1) * $limite;

$total_sql = "SELECT COUNT(*) as total $sql_base";
$total_res = mysqli_query($con, $total_sql);
$total_row = mysqli_fetch_assoc($total_res);
$total_produtos = $total_row['total'];

$total_paginas = ceil($total_produtos / $limite);

if ($pagina > $total_paginas && $total_paginas > 0) {
    $pagina = $total_paginas;
    $offset = ($pagina - 1) * $limite;
}

$sql = "SELECT * $sql_base ORDER BY RAND($seed) LIMIT $limite OFFSET $offset";
$resultado = mysqli_query($con, $sql);  
?>

<!DOCTYPE html>
<html lang="pt-br"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - ClutchOne</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="uploads/icon.png">
</head>

<body>

<aside id="menuLateral" class="fechado">

    <button id="fecharMenu">✖</button>

    <h2>Menu</h2>

    <a href="loja.php">Home</a>

    <h3>Categorias</h3>

    <a href="loja.php?categoria=bolas">Bolas</a>
    <a href="loja.php?categoria=tenis">Tênis</a>
    <a href="loja.php?categoria=regatas">Regatas</a>
    <a href="loja.php?categoria=chinelo">Chinelos</a>

    <h3>Institucional</h3>

    <a href="sobre.php">Sobre Nós</a>

</aside>

<div class="header">
    
    <div class="header-left">
        <button id="toggleMenu">☰</button>

        <img 
            src="uploads/logo.png" 
            alt="Clutch One"
            class="logo-header">
    </div>

    <a href="carrinho.php" class="carrinho-btn">Carrinho</a>

</div>

<input type="text" id="busca" placeholder="Buscar produto...">

<div class="container">

<?php while($p = mysqli_fetch_assoc($resultado)) { ?>
    
    <div class="card" data-nome="<?= strtolower($p['nome']) ?>">
        
        <?php if($p['imagem']) { ?>
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

</div>

<div class="paginacao">

    <?php if ($pagina > 1): ?>
        <a href="?pagina=<?= $pagina - 1 ?>&categoria=<?= $categoria ?>">Anterior</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
        <a href="?pagina=<?= $i ?>&categoria=<?= $categoria ?>"
           class="<?= $i == $pagina ? 'ativo' : '' ?>">
           <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($pagina < $total_paginas): ?>
        <a href="?pagina=<?= $pagina + 1 ?>&categoria=<?= $categoria ?>">Próximo</a>
    <?php endif; ?>

</div>

<script>
const busca = document.getElementById("busca");

function carregarProdutos(termo = "") {
    fetch(
        "buscar_produtos.php?q=" + encodeURIComponent(termo) + 
        "&t=" + new Date().getTime()
    )
    .then(res => res.text())
    .then(html => {
        document.querySelector(".container").innerHTML = html;
    });
}

if (busca) {
    busca.addEventListener("input", function () {
        carregarProdutos(this.value.trim());
    });
}
const botao = document.getElementById("toggleMenu");
const menu = document.getElementById("menuLateral");
const fechar = document.getElementById("fecharMenu");

if (botao && menu) {
    botao.addEventListener("click", () => {
        menu.classList.add("ativo");
    });
}

if (fechar && menu) {
    fechar.addEventListener("click", () => {
        menu.classList.remove("ativo");
    });
}

function mostrarPopupCarrinho() {
    const popup = document.createElement("div");

    popup.className = "popup";
    popup.innerHTML = `
        <p>✅ Produto adicionado ao carrinho!</p>
        <a href="carrinho.php">Ver Carrinho</a>
    `;

    document.body.appendChild(popup);

    setTimeout(() => {
        popup.remove();
    }, 3000);
}

document.addEventListener("click", function (e) {

    if (e.target.classList.contains("ver-mais")) {
        e.preventDefault();

        const card = e.target.closest(".card");
        const modal = card.querySelector(".descricao-modal");

        if (modal) {
            modal.classList.add("ativo");
        }
    }

    if (e.target.classList.contains("fechar-descricao")) {
        e.preventDefault();

        const modal = e.target.closest(".descricao-modal");

        if (modal) {
            modal.classList.remove("ativo");
        }
    }

    if (e.target.classList.contains("descricao-modal")) {
        e.target.classList.remove("ativo");
    }

    if (e.target.classList.contains("btn-adicionar-card")) {
        e.preventDefault();

        const form = e.target.closest("form");

        if (!form) return;

        const formData = new FormData(form);

        fetch("adicionar_carrinho_ajax.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.sucesso) {
                mostrarPopupCarrinho();
            } else {
                alert(data.mensagem || "Erro ao adicionar produto.");
            }
        })
        .catch(() => {
            alert("Erro ao adicionar produto.");
        });
    }
});
</script>

</body>
</html>