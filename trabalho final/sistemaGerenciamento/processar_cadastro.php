<?php
// Conexão com o banco de dados
require_once 'conexao.php'; 

// Verificando se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $tipo_usuario = $_POST['tipo_usuario'];

    // Verificando se todos os campos estão preenchidos
    if (empty($nome) || empty($email) || empty($senha) || empty($tipo_usuario)) {
        header('Location: cadastro.php?error=Todos os campos são obrigatórios');
        exit();
    }

    // Verificando se o e-mail já existe
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) > 0) {
        // E-mail já registrado
        header('Location: cadastro.php?error=Este e-mail já está registrado.');
        exit();
    }

    // Gerando o hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserindo os dados no banco de dados
    $sql_insert = "INSERT INTO usuarios (nome, email, senha, tipo_usuario) VALUES (?, ?, ?, ?)";
    $stmt_insert = mysqli_prepare($conexao, $sql_insert);
    mysqli_stmt_bind_param($stmt_insert, 'ssss', $nome, $email, $senha_hash, $tipo_usuario);

    if (mysqli_stmt_execute($stmt_insert)) {
        // Cadastro realizado com sucesso
        header('Location: login.php?success=Cadastro realizado com sucesso! Faça login.');
        exit();
    } else {
        // Erro ao cadastrar
        header('Location: cadastro.php?error=Erro ao cadastrar, tente novamente.');
        exit();
    }
} else {
    header('Location: cadastro.php?error=Método de requisição inválido.');
    exit();
}
?>
