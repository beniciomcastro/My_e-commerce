<?php
session_start();

$totalComFrete =
    isset($_POST['total_com_frete']) &&
    $_POST['total_com_frete'] !== ''
    ? (float) $_POST['total_com_frete']
    : 0;

$cepRecebido = $_POST['cep_frete'] ?? '';

$codigoPix = "PIX-MOCKADO-LOJA";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Finalizar Compra</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/x-icon" href="uploads/icon.png">
</head>

<body>

<div class="resumo-finalizacao">

    <p class="titulo-resumo" id="tituloResumoFinal">
        Total da compra com frete
    </p>

    <h2 class="valor-finalizacao" id="valorFinalizacao">
        R$ <?= number_format($totalComFrete, 2, ',', '.') ?>
    </h2>

</div>

<h1>Finalizar Compra</h1>

<div class="form-container">

<form action="pagamento_sucesso.php" method="POST" id="formPagamento">

<input 
    type="hidden" 
    name="total_com_frete" 
    id="totalComFreteFinal"
    value="<?= number_format($totalComFrete, 2, '.', '') ?>">

<h3>Endereço</h3>

<input 
    type="text" 
    name="nome" 
    placeholder="Nome completo" 
    minlength="3"
    required>

<input 
    type="text" 
    name="cep" 
    id="cep"
    placeholder="00000-000" 
    maxlength="9"
    pattern="[0-9]{5}-[0-9]{3}"
    inputmode="numeric"
    value="<?= $cepRecebido ?>"
    required>

<input 
    type="text" 
    name="endereco" 
    id="endereco"
    placeholder="Endereço" 
    required>

<input 
    type="text" 
    name="cidade" 
    id="cidade"
    placeholder="Cidade" 
    required>

<input 
    type="text" 
    name="numero" 
    id="numero"
    placeholder="Número" 
    required>

<input 
    type="text" 
    name="complemento" 
    id="complemento"
    placeholder="Complemento">

<h3>Pagamento</h3>

<input type="hidden" name="forma_pagamento" id="forma_pagamento">

<div class="opcoes-pagamento">

    <button type="button" id="btnPix" class="btn-pagamento-opcao pix">

        <img src="https://upload.wikimedia.org/wikipedia/commons/d/de/Logo_-_pix_powered_by_Banco_Central_%28Brazil%2C_2020%29.png">

        <span>Pix</span>

    </button>

    <button type="button" id="btnCartao" class="btn-pagamento-opcao cartao">

        <img src="https://cdn-icons-png.flaticon.com/512/179/179457.png">

        <span>Cartão</span>

    </button>

</div>

<div class="area-pagamento-centralizada">

    <div id="pagamentoPix"
    class="pagamento-opcao"
    style="display:none;">

        <p>Escaneie o QR Code Pix</p>

        <div class="qrcode-pix qrcode-verificacao">

            <img
            src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=<?= urlencode($codigoPix) ?>"
            alt="QR Code Pix">

        </div>

        <button type="button" id="btnVerificarPix" class="btn-aprovar pix">
            Verificar pagamento
        </button>

        <input 
            type="hidden" 
            id="pix_verificado" 
            value="nao">

    </div>

</div>

<div class="area-pagamento-centralizada">

    <div id="pagamentoCartao"
    class="pagamento-opcao"
    style="display:none;">

        <input 
            type="text" 
            name="cartao" 
            id="cartao"
            placeholder="Número do cartão" 
            maxlength="16"
            pattern="[0-9]{16}"
            inputmode="numeric">

        <input 
            type="text" 
            name="validade" 
            id="validade"
            placeholder="Validade (MM/AA)" 
            maxlength="5"
            pattern="(0[1-9]|1[0-2])\/[0-9]{2}">

        <input 
            type="text" 
            name="cvv" 
            id="cvv"
            placeholder="CVV" 
            maxlength="3"
            pattern="[0-9]{3}"
            inputmode="numeric">

    </div>

    <input 
        type="hidden" 
        name="prazo_entrega" 
        value="<?= $_SESSION['resumo_carrinho']['frete_prazo'] ?? '' ?>">

</div>

<button type="submit" id="btnAprovarPagamento">
    Aprovar pagamento
</button>

<a href="carrinho.php" class="voltar">Voltar</a>

</div>

<script>
function somenteNumeros(id, limite) {
    const campo = document.getElementById(id);

    if (campo) {
        campo.addEventListener("input", function () {
            campo.value = campo.value.replace(/\D/g, "").slice(0, limite);
        });
    }
}

function mascaraCEP(id) {
    const campo = document.getElementById(id);

    if (campo) {
        campo.addEventListener("input", function () {
            let valor = campo.value.replace(/\D/g, "").slice(0, 8);

            if (valor.length > 5) {
                valor = valor.slice(0, 5) + "-" + valor.slice(5);
            }

            campo.value = valor;
        });
    }
}

mascaraCEP("cep");
somenteNumeros("cartao", 16);
somenteNumeros("cvv", 3);

const validade = document.getElementById("validade");

if (validade) {
    validade.addEventListener("input", function () {
        let valor = validade.value.replace(/\D/g, "").slice(0, 4);

        if (valor.length >= 3) {
            valor = valor.slice(0, 2) + "/" + valor.slice(2);
        }

        validade.value = valor;
    });
}

const formPagamento = document.getElementById("formPagamento");
const btnPix = document.getElementById("btnPix");
const btnCartao = document.getElementById("btnCartao");
const pagamentoPix = document.getElementById("pagamentoPix");
const pagamentoCartao = document.getElementById("pagamentoCartao");
const formaPagamento = document.getElementById("forma_pagamento");
const btnVerificarPix = document.getElementById("btnVerificarPix");
const pixVerificado = document.getElementById("pix_verificado");
const checkPix = document.getElementById("checkPix");

btnPix.addEventListener("click", function () {
    pagamentoPix.style.display = "block";
    pagamentoCartao.style.display = "none";

    formaPagamento.value = "pix";

    btnPix.classList.add("ativo");
    btnCartao.classList.remove("ativo");

    document.getElementById("cartao").required = false;
    document.getElementById("validade").required = false;
    document.getElementById("cvv").required = false;
});

btnCartao.addEventListener("click", function () {
    pagamentoPix.style.display = "none";
    pagamentoCartao.style.display = "block";

    formaPagamento.value = "cartao";

    btnCartao.classList.add("ativo");
    btnPix.classList.remove("ativo");

    pixVerificado.value = "nao";

    if (checkPix) {
        checkPix.classList.remove("ativo");
    }

    btnVerificarPix.textContent = "Verificar pagamento";

    document.getElementById("cartao").required = true;
    document.getElementById("validade").required = true;
    document.getElementById("cvv").required = true;
});

btnVerificarPix.addEventListener("click", function () {
    pixVerificado.value = "sim";

    btnVerificarPix.textContent = "Pagamento verificado";

    if (checkPix) {
        checkPix.classList.add("ativo");
    }
});

formPagamento.addEventListener("submit", function (e) {

    if (formaPagamento.value === "") {
        e.preventDefault();
        alert("Escolha uma forma de pagamento.");
        return;
    }

    if (formaPagamento.value === "pix" && pixVerificado.value !== "sim") {
        e.preventDefault();
        alert("Clique em verificar pagamento antes de aprovar.");
        return;
    }
});

function buscarEnderecoPorCEP() {
    const cepCampo = document.getElementById("cep");
    const enderecoCampo = document.getElementById("endereco");
    const cidadeCampo = document.getElementById("cidade");

    if (!cepCampo || !enderecoCampo || !cidadeCampo) return;

    const cep = cepCampo.value.replace(/\D/g, "");

    if (cep.length !== 8) return;

    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(res => res.json())
        .then(data => {
            if (data.erro) return;

            enderecoCampo.value = data.logradouro || "";
            cidadeCampo.value = data.localidade || "";
        });
}

buscarEnderecoPorCEP();

document.getElementById("cep").addEventListener("blur", buscarEnderecoPorCEP);

document.getElementById("cep").addEventListener("input", function () {
    const cep = this.value.replace(/\D/g, "");

    if (cep.length === 8) {
        buscarEnderecoPorCEP();
    }
});
</script>

</body>
</html>