<?php
include('conexao.php');

// Processar compra
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo_ingresso'];
    $quantidade = (int) $_POST['quantidade'];

    $sql = "SELECT * FROM ingressos WHERE tipo = '$tipo'";
    $result = $conexao->query($sql);
    $ingresso = $result->fetch_assoc();

    if ($ingresso && $ingresso['quantidade'] >= $quantidade) {
        $novo_estoque = $ingresso['quantidade'] - $quantidade;
        $conexao->query("UPDATE ingressos SET quantidade = $novo_estoque WHERE tipo = '$tipo'");
        $error = "Compra realizada com sucesso!";
    } else {
        $error = "Estoque insuficiente para este tipo de ingresso!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Compra de Ingressos</title>
</head>
<body>
    <h1>Compra de Ingressos</h1>
    <?php if ($error): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="tipo_ingresso">Tipo de Ingresso:</label>
        <select name="tipo_ingresso" id="tipo_ingresso">
            <option value="Inteira">Inteira</option>
            <option value="Meia">Meia-Entrada</option>
            <option value="VIP">Área VIP</option>
        </select>
        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" id="quantidade" required>
        <button type="submit">Comprar</button>
    </form>
</body>
</html>
