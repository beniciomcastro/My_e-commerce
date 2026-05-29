<?php
include "conexao.php";

$id = (int) ($_GET['id'] ?? 0);

$res = mysqli_query($con, "SELECT * FROM cupons WHERE id = $id");
$cupom = mysqli_fetch_assoc($res);

if (!$cupom) {
    die("Cupom não encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = mysqli_real_escape_string($con, $_POST['codigo']);
    $tipo = mysqli_real_escape_string($con, $_POST['tipo']);
    $valor = (float) $_POST['valor'];
    $valor_minimo = (float) $_POST['valor_minimo'];
    $ativo = mysqli_real_escape_string($con, $_POST['ativo']);

    mysqli_query($con, "
        UPDATE cupons SET
            codigo = '$codigo',
            tipo = '$tipo',
            valor = '$valor',
            valor_minimo = '$valor_minimo',
            ativo = '$ativo'
        WHERE id = $id
    ");

    header("Location: cupons.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar Cupom</title>
<link rel="stylesheet" href="style.css">
</head>

<body class="admin-body">

<h1>Editar Cupom</h1>

<form method="POST" class="form-container">

    <input 
        type="text" 
        name="codigo" 
        value="<?= $cupom['codigo'] ?>" 
        required>

    <select name="tipo" required>
        <option value="porcentagem" <?= $cupom['tipo'] === 'porcentagem' ? 'selected' : '' ?>>
            Porcentagem
        </option>

        <option value="fixo" <?= $cupom['tipo'] === 'fixo' ? 'selected' : '' ?>>
            Valor fixo
        </option>
    </select>

    <input 
        type="number" 
        name="valor" 
        step="0.01" 
        value="<?= $cupom['valor'] ?>" 
        required>

    <input 
        type="number" 
        name="valor_minimo" 
        step="0.01" 
        value="<?= $cupom['valor_minimo'] ?>" 
        placeholder="Valor mínimo do carrinho">

    <select name="ativo">
        <option value="sim" <?= $cupom['ativo'] === 'sim' ? 'selected' : '' ?>>
            Ativo
        </option>

        <option value="nao" <?= $cupom['ativo'] === 'nao' ? 'selected' : '' ?>>
            Inativo
        </option>
    </select>

    <button type="submit">Salvar alterações</button>

</form>

<a href="cupons.php" class="voltar">Voltar</a>

</body>
</html>