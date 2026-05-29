<?php
include "conexao.php";

$id = $_GET['id'];

$sql = "SELECT * FROM produtos WHERE id = $id";
$resultado = mysqli_query($con, $sql);
$produto = mysqli_fetch_assoc($resultado);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria'];
    $estoque = $_POST['estoque'];
    $status = $_POST['status'];

    // VERIFICA SE ENVIOU NOVA IMAGEM
    if (!empty($_FILES['imagem']['name'])) {
        $imagem = uniqid() . "_" . $_FILES['imagem']['name'];
        $tmp = $_FILES['imagem']['tmp_name'];

        move_uploaded_file($tmp, "uploads/" . $imagem);

        $sql = "UPDATE produtos SET 
            nome='$nome',
            descricao='$descricao',
            preco='$preco',
            categoria='$categoria',
            estoque='$estoque',
            status='$status',
            imagem='$imagem'
            WHERE id=$id";
    } else {
        $sql = "UPDATE produtos SET 
            nome='$nome',
            descricao='$descricao',
            preco='$preco',
            categoria='$categoria',
            estoque='$estoque',
            status='$status'
            WHERE id=$id";
    }

    mysqli_query($con, $sql);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar Produto</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/x-icon" href="uploads/icon.png">
</head>

<body class="admin-body">

<div class="form-container">
    <h2>Editar Produto</h2>

    <form method="POST" enctype="multipart/form-data">

        <input type="text" name="nome" value="<?= $produto['nome'] ?>" required>

        <textarea name="descricao" required><?= $produto['descricao'] ?></textarea>

        <input type="number" step="0.01" name="preco" value="<?= $produto['preco'] ?>" required>

        <input type="text" name="categoria" value="<?= $produto['categoria'] ?>" required>

        <input type="number" name="estoque" value="<?= $produto['estoque'] ?>" required>

        <!-- IMAGEM ATUAL -->
        <p>Imagem atual:</p>
        <img src="uploads/<?= $produto['imagem'] ?>" style="width:100%; max-height:150px; object-fit:contain;">

        <!-- NOVA IMAGEM -->
        <input type="file" name="imagem">

        <select name="status">
            <option value="ativo" <?= $produto['status']=='ativo'?'selected':'' ?>>Ativo</option>
            <option value="inativo" <?= $produto['status']=='inativo'?'selected':'' ?>>Inativo</option>
        </select>

        <button type="submit">Salvar Alterações</button>

    </form>

    <a href="index.php" class="voltar">Voltar</a>
</div>

</body>
</html>