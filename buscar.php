<?php
include "conexao.php";

$termo = $_GET['q'] ?? '';
$termo = strtolower($termo);

$sql = "SELECT nome FROM produtos 
        WHERE status = 'ativo' 
        AND estoque > 0
        AND (
            LOWER(nome) LIKE '%$termo%' 
            OR LOWER(descricao) LIKE '%$termo%'
            OR LOWER(categoria) LIKE '%$termo%'
        )
        LIMIT 10";
$result = mysqli_query($con, $sql);

$produtos = [];

while ($row = mysqli_fetch_assoc($result)) {
    $produtos[] = $row['nome'];
}

echo json_encode($produtos);