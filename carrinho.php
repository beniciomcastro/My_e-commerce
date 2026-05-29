<?php
session_start();
include "conexao.php";

$carrinho = $_SESSION['carrinho'] ?? [];
$total = 0;
$total_itens = 0;

$resumoSalvo = $_SESSION['resumo_carrinho'] ?? [];

$freteSalvo = $resumoSalvo['frete'] ?? 0;
$descontoSalvo = $resumoSalvo['desconto'] ?? 0;
$totalSalvo = $resumoSalvo['total'] ?? 0;
$cepSalvo = $resumoSalvo['cep'] ?? '';
$cupomSalvo = $resumoSalvo['cupom'] ?? '';
$freteNomeSalvo = $resumoSalvo['frete_nome'] ?? '';
$fretePrazoSalvo = $resumoSalvo['frete_prazo'] ?? '';
$selecionadosSalvos = $resumoSalvo['selecionados'] ?? [];
$temSelecaoSalva = isset($resumoSalvo['selecionados']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Carrinho</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/x-icon" href="uploads/icon.png">
</head>

<body>

<div class="carrinho-topo">
    <a href="loja.php" class="voltar-loja">Continuar comprando</a>
    <h1>Meu Carrinho</h1>
</div>

<form action="finalizar.php" method="POST">
    <input 
        type="hidden" 
        name="total_com_frete" 
        id="inputTotalComFrete" 
        value="<?= $total ?>">
<div class="carrinho-layout">

    <section class="carrinho-lista">
        <div class="carrinho-lista-header">
            <h2>Produtos selecionados</h2>
            <a href="limpar_carrinho.php" class="limpar-carrinho">Limpar carrinho</a>
        </div>

        <?php if (empty($carrinho)): ?>
            <div class="carrinho-vazio">
                <p>Seu carrinho está vazio.</p>
                <a href="loja.php">Ver produtos</a>
            </div>
        <?php endif; ?>

        <?php foreach($carrinho as $id => $qtd):

        $sql = "SELECT * FROM produtos WHERE id = $id";
        $res = mysqli_query($con, $sql);
        $p = mysqli_fetch_assoc($res);

        if(!$p) continue;

        $subtotal = $p['preco'] * $qtd;
        $total += $subtotal;
        $total_itens += $qtd;

        $marcado = !$temSelecaoSalva || in_array((string) $id, array_map('strval', $selecionadosSalvos));
        ?>

        <div class="item-carrinho">

            <div class="item-check">
                <input 
                    type="checkbox" 
                    name="itens[]" 
                    value="<?= $id ?>" 
                    class="selecionar-item"
                    data-subtotal="<?= $subtotal ?>"
                    data-categoria="<?= strtolower($p['categoria']) ?>"
                    <?= $marcado ? 'checked' : '' ?>>
            </div>

            <img src="uploads/<?= $p['imagem'] ?>">

            <div class="item-info">
                <h3><?= $p['nome'] ?></h3>
                <p>Código: #<?= $p['id'] ?></p>
                <p>Estoque disponível: <?= $p['estoque'] ?></p>
            </div>

            <div class="item-preco">
                <span>Preço</span>
                <strong>R$ <?= number_format($p['preco'], 2, ',', '.') ?></strong>
            </div>

            <div class="item-quantidade">
                <span>Quantidade</span>

                <div class="controle-qtd">
                    <button type="button" class="btn-qtd" data-acao="menos">−</button>

                    <strong class="qtd-item"><?= $qtd ?></strong>

                    <button type="button" class="btn-qtd" data-acao="mais">+</button>
                </div>
            </div>

            <div class="item-subtotal">
                <span>Subtotal</span>
                <strong 
                    class="subtotal-item"
                    data-preco="<?= $p['preco'] ?>">
                    R$ <?= number_format($subtotal, 2, ',', '.') ?>
                </strong>

                <button type="button" class="remover-item btn-remover-js">
                    Remover
                </button>
            </div>

        </div>

        <?php endforeach; ?>

    </section>

    <aside class="resumo-pedido">
        <h2>Resumo do pedido</h2>

        <div>
            <span>Total de itens</span>
            <strong id="resumoTotalItens"><?= $total_itens ?></strong>
        </div>

        <div>
            <span>Subtotal</span>
            <strong id="resumoSubtotal">R$ <?= number_format($total, 2, ',', '.') ?></strong>
        </div>

        <div class="frete-box">
            <label for="cep_frete">Calcular frete</label>

            <div class="frete-input">
                <input 
                    type="text" 
                    id="cep_frete"
                    name="cep_frete" 
                    maxlength="9" 
                    placeholder="00000-000"
                    value="<?= $cepSalvo ?>">

                <button type="button" id="calcularFrete">
                    Calcular
                </button>
            </div>

            <p id="resultadoFrete">
                <?php if ((float) $freteSalvo > 0 && !empty($freteNomeSalvo)) { ?>
                    <strong><?= $freteNomeSalvo ?></strong><br>
                    Valor: R$ <?= number_format((float) $freteSalvo, 2, ',', '.') ?><br>
                    Prazo: <?= $fretePrazoSalvo ?> dias
                <?php } else { ?>
                    Frete: a calcular
                <?php } ?>
            </p>
        </div>

        <div class="cupom-box">

            <label for="cupom">Cupom de desconto</label>

            <div class="cupom-input">
                <input 
                    type="text" 
                    id="cupom" 
                    placeholder="Digite o cupom"
                    value="<?= $cupomSalvo ?>">

                <button type="button" id="aplicarCupom">
                    Aplicar
                </button>
            </div>

            <p id="mensagemCupom"></p>

        </div>

        <div>
            <span>Desconto</span>
            <strong id="valorDesconto">R$ 0,00</strong>
        </div>

        <hr>

        <div class="resumo-total">
            <span>Total</span>

            <div class="total-valores">

                <strong id="valorTotal" data-total="<?= $total ?>">
                    R$ <?= number_format($total, 2, ',', '.') ?>
                </strong>

                <small id="totalComFrete"></small>

            </div>
        </div>

        <?php if (!empty($carrinho)) { ?>
            <button type="submit" class="finalizar-btn" id="btnFinalizar">
                Finalizar compra
            </button>
        <?php } else { ?>
            <button type="button" class="finalizar-btn desabilitado" disabled>
                Carrinho vazio
            </button>
        <?php } ?>

        <p class="resumo-aviso">
            Confira os itens selecionados antes de finalizar.
        </p>
    </aside>

</div>

</form>

<script>
const cepFrete = document.getElementById("cep_frete");
const calcularFrete = document.getElementById("calcularFrete");
const resultadoFrete = document.getElementById("resultadoFrete");
const aplicarCupom = document.getElementById("aplicarCupom");
const cupomInput = document.getElementById("cupom");
const mensagemCupom = document.getElementById("mensagemCupom");
const valorDesconto = document.getElementById("valorDesconto");
const valorTotal = document.getElementById("valorTotal");
const totalComFrete = document.getElementById("totalComFrete");
const formCarrinho = document.querySelector("form");
const inputTotalComFrete = document.getElementById("inputTotalComFrete");

let descontoAtual = <?= (float) $descontoSalvo ?>;
let freteAtual = <?= (float) $freteSalvo ?>;
let freteNomeAtual = <?= json_encode($freteNomeSalvo) ?>;
let fretePrazoAtual = <?= json_encode($fretePrazoSalvo) ?>;

let cupomValido = false;
let descontoCupom = 0;

function formatarMoeda(valor) {
    return "R$ " + valor.toLocaleString("pt-BR", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function calcularSubtotalSelecionado() {
    let subtotal = 0;

    document.querySelectorAll(".selecionar-item:checked").forEach(function (item) {
        subtotal += parseFloat(item.dataset.subtotal || 0);
    });

    return subtotal;
}

function calcularQuantidadeSelecionada() {
    let quantidadeSelecionada = 0;

    document.querySelectorAll(".selecionar-item:checked").forEach(function (item) {
        const linha = item.closest(".item-carrinho");
        const qtd = parseInt(linha.querySelector(".qtd-item").textContent);
        quantidadeSelecionada += qtd;
    });

    return quantidadeSelecionada;
}

function salvarResumoCarrinho(totalFrete) {
    if (!cepFrete || !cupomInput) return;

    const selecionados = [];

    document.querySelectorAll(".selecionar-item:checked").forEach(function(item) {
        selecionados.push(item.value);
    });

    fetch("salvar_resumo_carrinho.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body:
            "frete=" + encodeURIComponent(freteAtual) +
            "&desconto=" + encodeURIComponent(descontoAtual) +
            "&total=" + encodeURIComponent(totalFrete) +
            "&cep=" + encodeURIComponent(cepFrete.value) +
            "&cupom=" + encodeURIComponent(cupomInput.value) +
            "&frete_nome=" + encodeURIComponent(freteNomeAtual) +
            "&frete_prazo=" + encodeURIComponent(fretePrazoAtual) +
            "&" +
            selecionados.map(function(id) {
                return "selecionados[]=" + encodeURIComponent(id);
            }).join("&")
    });
}

function atualizarTotais() {
    const totalSelecionado = calcularSubtotalSelecionado();

    descontoAtual = cupomValido ? descontoCupom : 0;

    if (totalSelecionado <= 0) {
        freteAtual = 0;
        freteNomeAtual = "";
        fretePrazoAtual = "";
        cupomValido = false;
        descontoCupom = 0;
        descontoAtual = 0;
    }

    const totalFinal = totalSelecionado - descontoAtual;
    const totalFrete = totalFinal + freteAtual;

    if (valorDesconto) {
        valorDesconto.textContent = formatarMoeda(descontoAtual);
    }

    if (valorTotal) {
        valorTotal.textContent = formatarMoeda(totalFinal);
    }

    if (totalComFrete) {
        if (freteAtual > 0 && totalSelecionado > 0) {
            totalComFrete.textContent = "Com frete: " + formatarMoeda(totalFrete);
        } else {
            totalComFrete.textContent = "";
        }
    }

    const resumoTotalItens = document.getElementById("resumoTotalItens");
    const resumoSubtotal = document.getElementById("resumoSubtotal");

    if (resumoTotalItens) {
        resumoTotalItens.textContent = calcularQuantidadeSelecionada();
    }

    if (resumoSubtotal) {
        resumoSubtotal.textContent = formatarMoeda(totalSelecionado);
    }

    const btnFinalizar = document.getElementById("btnFinalizar");

    if (btnFinalizar) {
        if (totalFinal <= 0) {
            btnFinalizar.disabled = true;
            btnFinalizar.classList.add("desabilitado");
            btnFinalizar.textContent = "Carrinho vazio";
        } else {
            btnFinalizar.disabled = false;
            btnFinalizar.classList.remove("desabilitado");
            btnFinalizar.textContent = "Finalizar compra";
        }
    }

    if (inputTotalComFrete) {
        inputTotalComFrete.value = totalFrete.toFixed(2);
    }
const itensRestantes = document.querySelectorAll(".item-carrinho");
    const carrinhoVazio = document.querySelector(".carrinho-vazio");

    if (itensRestantes.length === 0 && !carrinhoVazio) {
        document.querySelector(".carrinho-lista").insertAdjacentHTML(
            "beforeend",
            `
            <div class="carrinho-vazio">
                <p>Seu carrinho está vazio.</p>
                <a href="loja.php">Ver produtos</a>
            </div>
            `
        );
    }

    if (itensRestantes.length === 0) {
        if (resultadoFrete) {
            resultadoFrete.textContent = "Frete: a calcular";
        }

        if (mensagemCupom) {
            mensagemCupom.textContent = "";
        }
    }

    salvarResumoCarrinho(totalFrete);
}

function recalcularFreteSePossivel() {
    if (!cepFrete || !calcularFrete) return;

    const cep = cepFrete.value.replace(/\D/g, "");
    const itensSelecionados = document.querySelectorAll(".selecionar-item:checked").length;

    if (cep.length === 8 && itensSelecionados > 0) {
        resultadoFrete.textContent = "Recalculando frete...";
        calcularFrete.click();
    } else {
        freteAtual = 0;
        freteNomeAtual = "";
        fretePrazoAtual = "";

        if (resultadoFrete) {
            resultadoFrete.textContent = "Frete: a calcular";
        }

        atualizarTotais();
    }
}

if (cepFrete) {
    cepFrete.addEventListener("input", function () {
        let valor = cepFrete.value.replace(/\D/g, "").slice(0, 8);

        if (valor.length > 5) {
            valor = valor.slice(0, 5) + "-" + valor.slice(5);
        }

        cepFrete.value = valor;

        if (valor.length === 0) {
            freteAtual = 0;
            freteNomeAtual = "";
            fretePrazoAtual = "";

            if (resultadoFrete) {
                resultadoFrete.textContent = "Frete: a calcular";
            }

            if (totalComFrete) {
                totalComFrete.textContent = "";
            }

            atualizarTotais();
        }
    });
}

if (calcularFrete) {
    calcularFrete.addEventListener("click", function () {
        const cep = cepFrete.value.replace(/\D/g, "");

        if (cep.length !== 8) {
            resultadoFrete.textContent = "Digite um CEP válido.";
            return;
        }

        const itens = [];

        document.querySelectorAll(".selecionar-item:checked").forEach(function (item) {
            const linha = item.closest(".item-carrinho");
            const qtd = parseInt(linha.querySelector(".qtd-item").textContent);

            itens.push({
                categoria: item.dataset.categoria,
                quantidade: qtd
            });
        });

        if (itens.length === 0) {
            freteAtual = 0;
            freteNomeAtual = "";
            fretePrazoAtual = "";
            resultadoFrete.textContent = "Selecione pelo menos um item.";
            atualizarTotais();
            return;
        }

        resultadoFrete.textContent = "Calculando frete...";

        fetch("calcular_frete.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                cep: cep,
                itens: itens
            })
        })
        .then(res => res.json())
        .then(data => {
            if (!Array.isArray(data)) {
                resultadoFrete.textContent = "Erro ao calcular frete.";
                return;
            }

            const opcoes = data.filter(item =>
                !item.error &&
                item.price &&
                item.name.toLowerCase().includes("sedex")
            );

            if (opcoes.length === 0) {
                freteAtual = 0;
                freteNomeAtual = "";
                fretePrazoAtual = "";
                resultadoFrete.textContent = "SEDEX indisponível para este CEP.";
                atualizarTotais();
                return;
            }

            const melhor = opcoes[0];

            freteAtual = parseFloat(melhor.price.replace(",", "."));
            freteNomeAtual = melhor.name;
            fretePrazoAtual = melhor.delivery_time;

            resultadoFrete.innerHTML = `
                <strong>${melhor.name}</strong><br>
                Valor: ${formatarMoeda(freteAtual)}<br>
                Prazo: ${melhor.delivery_time} dias
            `;

            atualizarTotais();
        })
        .catch(() => {
            resultadoFrete.textContent = "Erro ao conectar com o frete.";
        });
    });
}

function validarCupomAtual() {
    const cupom = cupomInput.value.trim();
    const totalSelecionado = calcularSubtotalSelecionado();

    if (totalSelecionado <= 0) {
        cupomValido = false;
        descontoCupom = 0;

        valorDesconto.textContent = "R$ 0,00";
        mensagemCupom.textContent = "Selecione pelo menos um item.";
        mensagemCupom.style.color = "red";

        atualizarTotais();
        return;
    }

    if (cupom === "") {
        cupomValido = false;
        descontoCupom = 0;

        valorDesconto.textContent = "R$ 0,00";
        mensagemCupom.textContent = "";

        atualizarTotais();
        return;
    }

    fetch("validar_cupom.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body:
            "codigo=" + encodeURIComponent(cupom) +
            "&total=" + encodeURIComponent(totalSelecionado)
    })
    .then(res => res.json())
    .then(data => {
        if (data.valido) {
            cupomValido = true;
            descontoCupom = parseFloat(data.desconto);

            mensagemCupom.textContent = data.mensagem;
            mensagemCupom.style.color = "green";
        } else {
            cupomValido = false;
            descontoCupom = 0;

            mensagemCupom.textContent = data.mensagem;
            mensagemCupom.style.color = "red";
        }

        atualizarTotais();
    });
}

if (aplicarCupom) {
    aplicarCupom.addEventListener("click", validarCupomAtual);
}

if (formCarrinho && inputTotalComFrete) {
    formCarrinho.addEventListener("submit", function (event) {

        const itensSelecionados =
            document.querySelectorAll(".selecionar-item:checked").length;

        const cepDigitado =
            cepFrete ? cepFrete.value.replace(/\D/g, "") : "";

        if (itensSelecionados <= 0) {
            event.preventDefault();
            alert("Selecione pelo menos um item antes de finalizar a compra.");
            return;
        }

        if (cepDigitado.length !== 8 || freteAtual <= 0) {
            event.preventDefault();
            alert("Calcule o frete antes de finalizar a compra.");
            return;
        }

        const totalComFreteTexto = document.getElementById("totalComFrete");

        let valor = "";

        if (totalComFreteTexto && totalComFreteTexto.textContent.trim() !== "") {
            valor = totalComFreteTexto.textContent;
        }

        valor = valor
            .replace("Com frete:", "")
            .replace("R$", "")
            .replace(/\./g, "")
            .replace(",", ".")
            .trim();

        inputTotalComFrete.value = valor;
    });
}

document.querySelectorAll(".selecionar-item").forEach(function (checkbox) {
    checkbox.addEventListener("change", function () {
        atualizarTotais();
        recalcularFreteSePossivel();
        validarCupomAtual();
    });
});

document.querySelectorAll(".btn-qtd").forEach(function (botao) {
    botao.addEventListener("click", function () {
        const item = botao.closest(".item-carrinho");
        const qtdEl = item.querySelector(".qtd-item");
        const subtotalEl = item.querySelector(".subtotal-item");
        const checkbox = item.querySelector(".selecionar-item");

        let qtd = parseInt(qtdEl.textContent);
        const preco = parseFloat(subtotalEl.dataset.preco);

        if (botao.dataset.acao === "mais") {
            qtd++;
        }

        if (botao.dataset.acao === "menos") {
            if (qtd <= 1) {
                fetch("remover_carrinho.php?id=" + checkbox.value);

                item.remove();

                atualizarTotais();
                recalcularFreteSePossivel();
                validarCupomAtual();

                return;
            }

            qtd--;
        }

        const novoSubtotal = preco * qtd;

        qtdEl.textContent = qtd;
        subtotalEl.textContent = formatarMoeda(novoSubtotal);
        checkbox.dataset.subtotal = novoSubtotal;

        fetch("atualizar_carrinho_ajax.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id=" + checkbox.value + "&quantidade=" + qtd
        });

        atualizarTotais();
        recalcularFreteSePossivel();
        validarCupomAtual();
    });
});

document.querySelectorAll(".btn-remover-js").forEach(function (botao) {
    botao.addEventListener("click", function () {
        const item = botao.closest(".item-carrinho");
        const checkbox = item.querySelector(".selecionar-item");

        if (checkbox) {
            fetch("remover_carrinho.php?id=" + checkbox.value);
        }

        if (item) {
            item.remove();
        }

        atualizarTotais();
        recalcularFreteSePossivel();
        validarCupomAtual();
    });
});

atualizarTotais();
</script>

</body>
</html>
