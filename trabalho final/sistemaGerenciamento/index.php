<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gerenciamento de Eventos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main>
        <section>
            <h1>Bem-vindo ao Sistema de Gerenciamento de Eventos</h1>
            <p>Faça login para acessar o sistema.</p>
            <a href="auth/login.php" class="btn">Login</a>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
