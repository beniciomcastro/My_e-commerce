<?php

header('Content-Type: application/json');

$entrada = json_decode(file_get_contents("php://input"), true);

$cepDestino = preg_replace('/\D/', '', $entrada['cep'] ?? '');
$itens = $entrada['itens'] ?? [];

if (strlen($cepDestino) !== 8 || empty($itens)) {
    echo json_encode(["erro" => "CEP ou itens inválidos"]);
    exit;
}

$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYWU4ZWZiNzFmZmUyMjk3ZjZmZDllNjZhZDRlMTMzM2Y3ZGEzODZiZGI2M2EwYTM4NGRlNmRiY2Q2ODhlNTcyZmZmMjMzNWY0NzRmMjU3MDkiLCJpYXQiOjE3NzkxNDAwNTAuNTYxMzA0LCJuYmYiOjE3NzkxNDAwNTAuNTYxMzA2LCJleHAiOjE4MTA2NzYwNTAuNTQ5NjkxLCJzdWIiOiJhMWNmOTYxMC1hZjA2LTQzYzAtOTU0NS05YWI3ZTEzMWUxNmUiLCJzY29wZXMiOlsic2hpcHBpbmctY2FsY3VsYXRlIl19.AMhol2yHhLvtc9sh7PZ5-2vsIig2scoiHQhf4SKSGTi6TJqFdHOAGt4GON9Plux2-vL1JyGxBKGCh5ebt_oUEExiWHGFOMIsXAs4rub3ou60cAxZmwUfmxfCSiu4CedIprRuccmrpNFpl-TL7d6Jjv77Nv9w-SR30MmKnkKfPmK0Zl4gS-xASE6BIIS2I0zjw5qCs9UynGfqzodpVUnk_3IM-zZ1F9zVjvcG-vWhr0CT8ZY62wGp545NvA59ze9LFyV7np2k8jAOnzT6aTRbyJcHzHi3-nb-YNmcWSzjVSUBEvbOn_EERgOAat-zY9zG8OxKsYhs7CZfy7GJdF5v1CS1g-ieepkm9T_rGTU1cwAa31qQwioVPwnHGuanlL56atGGM_h7YxNRRc1lbzyekZ_SkwRMGVWnenPlBhK5hdESxHm8wO3wSu73wV2m5aQTejMZlG1IIDDTCzwn1V82KvsN3vnEFyuQYx7Isolw6Bu872hFywnNs2UOqN54xH9DDR5RtMOm2wdsWhe8FEJ96ZPxqsxga09x_FZfCUIxkMnEZNeeNLP7jkaYmD-WPlDufMYmBXVB42C_dYKQkd-6naUqIjTF0EmtCcbvjw7NZqXE9uMvJBQQzM397l_9g7ITMjTvRfD3HcBSyJONymgnl55X0gDe_40Ux4z38abpn4Y';

$produtos = [];

foreach ($itens as $index => $item) {
    $categoria = strtolower($item['categoria']);
    $quantidade = (int) $item['quantidade'];

    if ($quantidade < 1) {
        continue;
    }

    if ($categoria === 'bolas') {
        $largura = 25;
        $altura = 25;
        $comprimento = 25;
        $peso = 0.7;
        $valorSeguro = 150;
    } elseif ($categoria === 'tenis') {
        $largura = 25;
        $altura = 15;
        $comprimento = 35;
        $peso = 1.2;
        $valorSeguro = 300;
    } elseif ($categoria === 'regatas') {
        $largura = 20;
        $altura = 5;
        $comprimento = 30;
        $peso = 0.3;
        $valorSeguro = 100;
    } elseif ($categoria === 'chinelo') {
        $largura = 20;
        $altura = 8;
        $comprimento = 30;
        $peso = 0.6;
        $valorSeguro = 120;
    } else {
        $largura = 20;
        $altura = 10;
        $comprimento = 30;
        $peso = 1;
        $valorSeguro = 100;
    }

    $produtos[] = [
        "id" => (string) ($index + 1),
        "width" => $largura,
        "height" => $altura,
        "length" => $comprimento,
        "weight" => $peso,
        "insurance_value" => $valorSeguro,
        "quantity" => $quantidade
    ];
}

$dados = [
    "from" => [
        "postal_code" => "85010000"
    ],
    "to" => [
        "postal_code" => $cepDestino
    ],
    "products" => $produtos
];

$ch = curl_init("https://www.melhorenvio.com.br/api/v2/me/shipment/calculate");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Accept: application/json",
    "Content-Type: application/json",
    "Authorization: Bearer " . $token,
    "User-Agent: Loja Basquete (seuemail@email.com)"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));

$resposta = curl_exec($ch);
$erro = curl_error($ch);

curl_close($ch);

if ($erro) {
    echo json_encode(["erro" => $erro]);
    exit;
}

echo $resposta;