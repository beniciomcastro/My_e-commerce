<?php
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria = strtolower(trim($_POST['categoria']));
    $estoque = $_POST['estoque'];
    $status = $_POST['status'];

    // upload imagem
    $imagem = uniqid() . "_" . $_FILES['imagem']['name'];
    $tmp = $_FILES['imagem']['tmp_name'];

    move_uploaded_file($tmp, "uploads/" . $imagem);

    $sql = "INSERT INTO produtos 
    (nome, descricao, preco, categoria, estoque, imagem, status)
    VALUES ('$nome','$descricao','$preco','$categoria','$estoque','$imagem','$status')";

    mysqli_query($con, $sql);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cadastrar Produto</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/x-icon" href="uploads/icon.png">
</head>

<body class="admin-body">

<div class="form-container">
    <h2>Cadastrar Produto</h2>

    <form method="POST" enctype="multipart/form-data">

        <input type="text" name="nome" placeholder="Nome do produto" required>

        <textarea name="descricao" placeholder="Descrição" required></textarea>

        <input type="number" step="0.01" name="preco" placeholder="Preço" required>

        <input type="text" name="categoria" placeholder="Categoria" required>

        <input type="number" name="estoque" placeholder="Estoque" required>

        <input type="file" name="imagem">

        <select name="status">
            <option value="ativo">Ativo</option>
            <option value="inativo">Inativo</option>
        </select>

        <button type="submit">Cadastrar</button>

    </form>

    <a href="index.php" class="voltar">Voltar</a>
</div>
<style>
body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    flex-direction: column;
    background: #f4f6f8;
    font-family: Arial, Helvetica, sans-serif;
}

.form-container {
    width: min(900px, 94%);
    max-width: 900px;
    margin: 0 auto;
    background: white;
    padding: 28px;
    border-radius: 18px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
}

.form-container form {
    display: grid;
    grid-template-columns: 1fr;
    gap: 10px;
}

.form-container input,
.form-container textarea,
.form-container select {
    width: 100%;
    padding: 13px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    font-size: 16px;
    outline: none;
}

.form-container textarea {
    min-height: 150px;
    resize: none;
}

.form-container button {
    background: #2563eb;
    color: white;
    border: none;
    padding: 13px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 700;
    font-size: 16px;
}

.form-container button:hover {
    background: #1d4ed8;
}

@media (min-width: 760px) {
    .form-container form {
        grid-template-columns: 1fr 1fr;
        column-gap: 18px;
    }

    .form-container h2,
    .form-container h3,
    .form-container textarea,
    .form-container button,
    .form-container .voltar {
        grid-column: 1 / -1;
    }
}
</style>

</body>
</html>