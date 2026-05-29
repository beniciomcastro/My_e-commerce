<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Sobre Nós - Clutch One</title>

<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/x-icon" href="uploads/icon.png">
</head>

<body>

<!-- MENU -->
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

<!-- HEADER -->
<div class="header sobre-header">

    <div class="header-left">
        <button id="toggleMenu">☰</button>

        <img 
            src="uploads/logo.png" 
            alt="Clutch One" 
            class="logo-header">
    </div>

</div>

<!-- CONTEÚDO -->
<main class="sobre-page">

    <section class="sobre-intro">

        <span class="sobre-etiqueta">
            Basquete • performance • atitude
        </span>

        <h1>
            Feita para quem vive o jogo.
        </h1>

        <p>
            A Clutch One é uma loja fictícia especializada em produtos de basquete,
            criada para simular uma experiência moderna de e-commerce esportivo,
            unindo estilo, praticidade e paixão pelo jogo.
        </p>

    </section>

    <section class="sobre-blocos">

        <div class="sobre-card-pro">

            <span>01</span>

            <h2>Quem somos</h2>

            <p>
                Nascemos com uma proposta simples: reunir produtos ligados ao universo
                do basquete em uma loja visualmente forte, organizada e fácil de usar.
                Trabalhamos com bolas, tênis, regatas, chinelos e acessórios para quem
                joga, acompanha ou se identifica com a cultura do esporte.
            </p>

        </div>

        <div class="sobre-card-pro">

            <span>02</span>

            <h2>Nossa proposta</h2>

            <p>
                Criar uma jornada de compra completa, com vitrine de produtos, carrinho,
                cálculo de frete, cupons, pagamento simulado, controle de estoque e
                acompanhamento de pedidos. Tudo pensado para parecer uma loja real.
            </p>

        </div>

        <div class="sobre-card-pro">

            <span>03</span>

            <h2>Missão</h2>

            <p>
                Oferecer uma experiência de compra prática, segura e visualmente
                profissional para quem procura produtos de basquete com personalidade,
                qualidade e conexão com o esporte.
            </p>

        </div>

        <div class="sobre-card-pro">

            <span>04</span>

            <h2>Visão</h2>

            <p>
                Ser reconhecida como uma loja digital referência no segmento de basquete,
                transmitindo confiança, identidade esportiva e uma navegação objetiva
                desde a escolha do produto até a finalização do pedido.
            </p>

        </div>

    </section>

    <section class="sobre-valores">

        <div>
            <h2>O que valorizamos</h2>

            <p>
                A Clutch One foi pensada para representar mais do que uma loja:
                ela traduz a energia do basquete em uma experiência digital direta,
                bonita e funcional.
            </p>
        </div>

        <ul>
            <li>Produtos com identidade esportiva;</li>
            <li>Experiência de compra simples e objetiva;</li>
            <li>Visual moderno e profissional;</li>
            <li>Organização no carrinho, frete e pedidos;</li>
            <li>Foco em praticidade para o cliente.</li>
        </ul>

    </section>

    <section class="sobre-contato-pro">

        <h2>Contato</h2>

        <div class="contato-grid">

            <div>
                <strong>Email</strong>
                <p>contato@clutchone.com.br</p>
            </div>

            <div>
                <strong>Telefone</strong>
                <p>(42) 99999-9999</p>
            </div>

            <div>
                <strong>Localização</strong>
                <p>Guarapuava - PR</p>
            </div>

        </div>

    </section>

    <a href="loja.php" class="voltar sobre-voltar">
        Voltar para loja
    </a>

</main>

<script>
const botao = document.getElementById("toggleMenu");
const menu = document.getElementById("menuLateral");
const fechar = document.getElementById("fecharMenu");

// abrir menu
botao.addEventListener("click", () => {
    menu.classList.add("ativo");
});

// fechar menu
fechar.addEventListener("click", () => {
    menu.classList.remove("ativo");
});
</script>

</body>
</html>
