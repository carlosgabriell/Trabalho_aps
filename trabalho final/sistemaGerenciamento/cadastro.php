<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #333;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        h1 {
            text-align: center;
            color: #fff;
            margin-bottom: 20px;
        }
        form {
            width: 100%;
            max-width: 400px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-size: 14px;
            font-weight: bold;
            color: #555;
        }
        input, select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }
        input:focus, select:focus {
            border-color: #007bff;
            outline: none;
        }
        button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background: #0056b3;
        }
        a {
            text-decoration: none;
            color: #007bff;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #0056b3;
        }
        p {
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
            text-align: center;
        }
        .success {
            color: green;
            font-size: 14px;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div>
        <h1>Criar Conta</h1>
        <?php
        if (isset($_GET['error'])) {
            echo '<div class="error">' . htmlspecialchars($_GET['error']) . '</div>';
        }
        if (isset($_GET['success'])) {
            echo '<div class="success">' . htmlspecialchars($_GET['success']) . '</div>';
        }
        ?>
        <form method="POST" action="processar_cadastro.php">
            <label for="nome">Nome Completo:</label>
            <input type="text" id="nome" name="nome" required>
            
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
            
            <label for="tipo_usuario">Você é:</label>
            <select id="tipo_usuario" name="tipo_usuario" required>
                <option value="">Selecione</option>
                <option value="comprador">Comprador</option>
                <option value="organizador">Organizador</option>
            </select>
            
            <button type="submit">Criar Conta</button>
            
            <p>
                Já tem uma conta? <a href="login.php">Faça login</a>
            </p>
        </form>
    </div>
</body>
</html>
