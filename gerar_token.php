<?php

$clientId = 'SEU_CLIENT_ID';
$clientSecret = 'SEU_CLIENT_SECRET';

$url = 'https://www.melhorenvio.com.br/oauth/token';

$dados = [
    'grant_type' => 'client_credentials',
    'client_id' => $clientId,
    'client_secret' => $clientSecret
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dados));

$resposta = curl_exec($ch);

curl_close($ch);

echo $resposta;