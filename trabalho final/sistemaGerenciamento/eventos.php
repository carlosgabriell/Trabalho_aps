<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Conexão com o banco de dados
include('conexao.php');

// Definir a variável de erro
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['criar_evento'])) {
        // Criar Evento
        $nome = trim($_POST['nome']);
        $descricao = trim($_POST['descricao']);
        $data_evento = trim($_POST['data_evento']);
        $usuario_id = $_SESSION['usuario_id'];

        $sql = "INSERT INTO eventos (nome, descricao, data_evento, usuario_id) VALUES (?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sssi", $nome, $descricao, $data_evento, $usuario_id);

        if ($stmt->execute()) {
            $error = "Evento criado com sucesso!";
        } else {
            $error = "Erro ao criar o evento: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['editar_evento'])) {
        // Editar Evento
        $id_evento = $_POST['id_evento'];
        $nome = trim($_POST['nome']);
        $descricao = trim($_POST['descricao']);
        $data_evento = trim($_POST['data_evento']);

        $sql = "UPDATE eventos SET nome = ?, descricao = ?, data_evento = ? WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sssi", $nome, $descricao, $data_evento, $id_evento);

        if ($stmt->execute()) {
            $error = "Evento atualizado com sucesso!";
        } else {
            $error = "Erro ao atualizar o evento: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['logout'])) {
        // Logout
        session_destroy();
        header("Location: login.php");
        exit();
    }
}

// Lógica para Excluir Evento
if (isset($_GET['delete'])) {
    $evento_id = $_GET['delete'];

    $sql = "DELETE FROM eventos WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $evento_id);

    if ($stmt->execute()) {
        header("Location: eventos.php?success=Evento excluído com sucesso!");
        exit();
    } else {
        $error = "Erro ao excluir evento: " . $stmt->error;
    }

    $stmt->close();
}

// Listar Eventos
$sql = "SELECT * FROM eventos";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .event-form, .event-list {
            margin-bottom: 30px;
        }
        .event-form input, .event-form textarea, .event-form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .event-form button {
            background-color: #1e90ff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .event-form button:hover {
            background-color: #0054a8;
        }
        .event-list {
            display: flex;
            flex-direction: column;
        }
        .event-item {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .event-item a {
            text-decoration: none;
            color: #333;
        }
        .event-item a:hover {
            color: #007BFF;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
        .logout-button {
            color: white;
            background-color: #d9534f;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .logout-button:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gerenciamento de Eventos</h1>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Formulário de Criação de Evento -->
        <div class="event-form">
            <h2>Criar Evento</h2>
            <form method="POST">
                <input type="text" name="nome" placeholder="Nome do Evento" required>
                <textarea name="descricao" placeholder="Descrição do Evento" required></textarea>
                <input type="datetime-local" name="data_evento" required>
                <button type="submit" name="criar_evento">Criar Evento</button>
            </form>
        </div>

        <form method="POST" style="display: inline;">
            <button type="submit" name="logout" class="logout-button">Sair</button>
        </form>

        <!-- Listar Eventos -->
        <div class="event-list">
            <h2>Eventos Criados</h2>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($evento = $result->fetch_assoc()): ?>
                    <div class="event-item">
                        <h3><?php echo htmlspecialchars($evento['nome']); ?></h3>
                        <p><?php echo htmlspecialchars($evento['descricao']); ?></p>
                        <p><strong>Data do Evento:</strong> <?php echo htmlspecialchars($evento['data_evento']); ?></p>
                        <a href="eventos.php?editar=<?php echo $evento['id']; ?>">Editar</a> | 
                        <a href="eventos.php?delete=<?php echo $evento['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este evento?')">Excluir</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Nenhum evento encontrado.</p>
            <?php endif; ?>
        </div>

        <!-- Formulário de Edição de Evento -->
        <?php if (isset($_GET['editar'])): ?>
            <?php
            $id_evento = $_GET['editar'];
            $sql = "SELECT * FROM eventos WHERE id = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("i", $id_evento);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $evento = $resultado->fetch_assoc();
            $stmt->close();
            ?>
            <div class="event-form">
                <h2>Editar Evento</h2>
                <form method="POST">
                    <input type="hidden" name="id_evento" value="<?php echo $evento['id']; ?>">
                    <input type="text" name="nome" value="<?php echo htmlspecialchars($evento['nome']); ?>" required>
                    <textarea name="descricao" required><?php echo htmlspecialchars($evento['descricao']); ?></textarea>
                    <input type="datetime-local" name="data_evento" value="<?php echo htmlspecialchars($evento['data_evento']); ?>" required>
                    <button type="submit" name="editar_evento">Atualizar Evento</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
