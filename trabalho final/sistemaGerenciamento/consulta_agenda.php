<?php
include('conexao.php');

// Buscar eventos na agenda
$sql = "SELECT * FROM agenda ORDER BY data_evento";
$eventos = $conexao->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agenda do Evento</title>
    <style>
        /* Utilize o mesmo estilo do CSS anterior para manter a consistência */
    </style>
</head>
<body>
    <header>
        <h1>Agenda do Evento</h1>
    </header>
    <nav>
        <a href="compra_ingressos.php">Compra de Ingressos</a>
        <a href="submissao_revisao.php">Submissão de Propostas</a>
        <a href="consulta_agenda.php">Consulta da Agenda</a>
    </nav>
    <main>
        <?php while ($evento = $eventos->fetch_assoc()): ?>
            <div>
                <h3><?php echo $evento['titulo']; ?></h3>
                <p><?php echo $evento['descricao']; ?></p>
                <p>Data: <?php echo $evento['data_evento']; ?></p>
            </div>
        <?php endwhile; ?>
    </main>
</body>
</html>
