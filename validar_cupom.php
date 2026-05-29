<?php
include "conexao.php";

header('Content-Type: application/json');

$codigo = $_POST['codigo'] ?? '';
$total = isset($_POST['total']) ? (float) $_POST['total'] : 0;

$codigo = mysqli_real_escape_string($con, $codigo);

$sql = "SELECT * FROM cupons 
        WHERE codigo = '$codigo' 
        AND ativo = 'sim'
        LIMIT 1";

$res = mysqli_query($con, $sql);
$cupom = mysqli_fetch_assoc($res);

if (!$cupom) {
    echo json_encode([
        "valido" => false,
        "mensagem" => "Cupom inválido."
    ]);
    exit;
}

$valorMinimo = (float) $cupom['valor_minimo'];

if ($total < $valorMinimo) {
    echo json_encode([
        "valido" => false,
        "mensagem" => "Este cupom exige valor mínimo de R$ " . number_format($valorMinimo, 2, ',', '.')
    ]);
    exit;
}

$valorCupom = (float) $cupom['valor'];

if ($cupom['tipo'] === 'porcentagem') {
    $desconto = $total * ($valorCupom / 100);
} else {
    $desconto = $valorCupom;
}

if ($desconto > $total) {
    $desconto = $total;
}

echo json_encode([
    "valido" => true,
    "desconto" => $desconto,
    "mensagem" => "Cupom aplicado com sucesso!"
]);