<?php
session_start();

// Verifica se o usuário está logado e se é um organizador
if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] != 'organizador') {
    header('Location: login.php');
    exit();
}

// Conexão com o banco de dados (ajuste os dados conforme sua configuração)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eventos_db"; // Nome do banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para adicionar um evento
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_event'])) {
    $evento_nome = $_POST['evento_nome'];
    $evento_data = $_POST['evento_data'];
    $evento_local = $_POST['evento_local'];
    $inteira_preco = $_POST['inteira_preco'];
    $meia_preco = $_POST['meia_preco'];
    $vip_preco = $_POST['vip_preco'];

    $sql = "INSERT INTO eventos (nome, data, local, inteira_preco, meia_preco, vip_preco) VALUES ('$evento_nome', '$evento_data', '$evento_local', '$inteira_preco', '$meia_preco', '$vip_preco')";
    if ($conn->query($sql) === TRUE) {
        echo "Novo evento adicionado com sucesso!";
    } else {
        echo "Erro ao adicionar evento: " . $conn->error;
    }
}

// Função para excluir um evento
if (isset($_GET['delete_event'])) {
    $event_id = $_GET['delete_event'];
    $sql = "DELETE FROM eventos WHERE id = $event_id";
    if ($conn->query($sql) === TRUE) {
        echo "Evento excluído com sucesso!";
    } else {
        echo "Erro ao excluir evento: " . $conn->error;
    }
}

// Recupera os eventos cadastrados
$sql = "SELECT * FROM eventos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Organizador</title>
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

        .event-form {
            margin-top: 30px;
        }

        .event-form input,
        .event-form button {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            font-size: 16px;
            border-radius: 5px;
        }

        .event-form button {
            background-color: #28a745;
            color: white;
            border: none;
        }

        .event-form button:hover {
            background-color: #218838;
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
        <h1>Página do Organizador</h1>
    </header>

    <div class="container">
        <p class="welcome-message">Bem-vindo, <strong><?php echo $_SESSION['user_nome']; ?></strong>!<br>Você está logado como organizador.</p>

        <div class="event-form">
            <h3>Adicionar Evento</h3>
            <form method="POST" action="">
                <input type="text" name="evento_nome" placeholder="Nome do evento" required>
                <input type="date" name="evento_data" placeholder="Data do evento" required>
                <input type="text" name="evento_local" placeholder="Local do evento" required>
                <input type="number" name="inteira_preco" placeholder="Preço Inteira" required>
                <input type="number" name="meia_preco" placeholder="Preço Meia" required>
                <input type="number" name="vip_preco" placeholder="Preço VIP" required>
                <button type="submit" name="add_event">Adicionar Evento</button>
            </form>
        </div>

        <div class="events-section">
            <h3>Eventos Cadastrados</h3>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="event-card">
                        <div class="event-info">
                            <h2><?php echo $row['nome']; ?></h2>
                            <p>Data: <?php echo $row['data']; ?></p>
                            <p>Local: <?php echo $row['local']; ?></p>
                            <p>Inteira: R$ <?php echo $row['inteira_preco']; ?></p>
                            <p>Meia: R$ <?php echo $row['meia_preco']; ?></p>
                            <p>VIP: R$ <?php echo $row['vip_preco']; ?></p>
                        </div>
                        <div class="event-actions">
                            <a href="?delete_event=<?php echo $row['id']; ?>" class="btn-logout">Excluir</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Não há eventos cadastrados.</p>
            <?php endif; ?>
        </div>

        <!-- Botão de logout -->
        <a href="logout.php" class="btn-logout">Sair</a>
    </div>

    <footer>
        <p>&copy; 2024 Sua Loja. Todos os direitos reservados.</p>
    </footer>

</body>
</html>

<?php
// Fechar a conexão com o banco de dados
$conn->close();
?>
