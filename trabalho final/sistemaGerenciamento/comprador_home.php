<?php
session_start();

// Verifica se o usuário está logado e se é um comprador
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] != 'comprador') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Comprador</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .welcome-message {
            font-size: 1.2em;
            color: #333;
            margin-bottom: 20px;
        }

        .btn-logout {
            display: inline-block;
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn-logout:hover {
            background-color: #d32f2f;
        }

        .events-section {
            margin-top: 30px;
        }

        .event-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .event-card h2 {
            font-size: 1.5em;
            color: #007bff;
        }

        .event-card p {
            color: #555;
            font-size: 1.1em;
            margin: 10px 0;
        }

        .event-btns {
            display: flex;
            gap: 10px;
        }

        .event-btn {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-inteira {
            background-color: #28a745;
            color: white;
        }

        .btn-meia {
            background-color: #ffc107;
            color: white;
        }

        .btn-vip {
            background-color: #dc3545;
            color: white;
        }

        .btn-inteira:hover {
            background-color: #218838;
        }

        .btn-meia:hover {
            background-color: #e0a800;
        }

        .btn-vip:hover {
            background-color: #c82333;
        }

        footer {
            text-align: center;
            background-color: #333;
            color: white;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Página do Comprador</h1>
    </header>

    <div class="container">
        <p class="welcome-message">Bem-vindo, <strong><?php echo $_SESSION['user_nome']; ?></strong>!<br>Você está logado como comprador.</p>

        <p>Aqui você pode visualizar os eventos disponíveis e escolher o tipo de ingresso para compra.</p>

        <div class="events-section">
            <!-- Evento 1 -->
            <div class="event-card">
                <div class="event-info">
                    <h2>Show de Música</h2>
                    <p>Data: 25 de Dezembro de 2024</p>
                    <p>Local: Arena X</p>
                </div>
                <div class="event-btns">
                    <button class="event-btn btn-inteira">Inteira - R$ 100</button>
                    <button class="event-btn btn-meia">Meia - R$ 50</button>
                    <button class="event-btn btn-vip">VIP - R$ 200</button>
                </div>
            </div>

            <!-- Evento 2 -->
            <div class="event-card">
                <div class="event-info">
                    <h2>Teatro Musical</h2>
                    <p>Data: 15 de Janeiro de 2025</p>
                    <p>Local: Teatro Y</p>
                </div>
                <div class="event-btns">
                    <button class="event-btn btn-inteira">Inteira - R$ 80</button>
                    <button class="event-btn btn-meia">Meia - R$ 40</button>
                    <button class="event-btn btn-vip">VIP - R$ 150</button>
                </div>
            </div>

            <!-- Evento 3 -->
            <div class="event-card">
                <div class="event-info">
                    <h2>Festival de Música Eletrônica</h2>
                    <p>Data: 10 de Fevereiro de 2025</p>
                    <p>Local: Parque Z</p>
                </div>
                <div class="event-btns">
                    <button class="event-btn btn-inteira">Inteira - R$ 120</button>
                    <button class="event-btn btn-meia">Meia - R$ 60</button>
                    <button class="event-btn btn-vip">VIP - R$ 250</button>
                </div>
            </div>
        </div>

        <!-- Botão de logout -->
        <a href="logout.php" class="btn-logout">Sair</a>
    </div>

    <footer>
        <p>&copy; 2024 Sua Loja. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
