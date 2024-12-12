<?php
include('conexao.php');

// Processar submissão
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];

    $sql = "INSERT INTO propostas (titulo, descricao) VALUES ('$titulo', '$descricao')";
    if ($conexao->query($sql)) {
        $message = "Proposta enviada para revisão!";
    } else {
        $message = "Erro ao enviar proposta.";
    }
}

// Listar propostas
$sql = "SELECT * FROM propostas";
$propostas = $conexao->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submissão e Revisão</title>
    <style>
        /* Utilize o mesmo estilo do CSS anterior para manter a consistência */
    </style>
</head>
<body>
    <header>
        <h1>Submissão de Propostas</h1>
    </header>
    <nav>
        <a href="compra_ingressos.php">Compra de Ingressos</a>
        <a href="submissao_revisao.php">Submissão de Propostas</a>
        <a href="consulta_agenda.php">Consulta da Agenda</a>
    </nav>
    <main>
        <h2>Enviar Proposta</h2>
        <?php if (!empty($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="titulo" placeholder="Título da Proposta" required>
            <textarea name="descricao" placeholder="Descrição" required></textarea>
            <button type="submit">Enviar</button>
        </form>
        <h2>Propostas Submetidas</h2>
        <?php while ($proposta = $propostas->fetch_assoc()): ?>
            <div>
                <h3><?php echo $proposta['titulo']; ?></h3>
                <p><?php echo $proposta['descricao']; ?></p>
                <p>Status: <?php echo $proposta['status']; ?></p>
            </div>
        <?php endwhile; ?>
    </main>
</body>
</html>
