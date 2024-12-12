<?php
session_start();

// Conexão com o banco de dados
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificando se os campos estão preenchidos
    if (empty($email) || empty($senha)) {
        header('Location: login.php?error=Por favor, preencha todos os campos');
        exit();
    }

    // Preparando a consulta para verificar o e-mail e a senha
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    // Verificando se o usuário existe e a senha está correta
    if (mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);

        // Verificando a senha
        if (password_verify($senha, $usuario['senha'])) {
            // Se a senha for correta, cria a sessão
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_nome'] = $usuario['nome'];
            $_SESSION['user_tipo'] = $usuario['tipo_usuario']; // Tipo de usuário (comprador ou organizador)

            // Redirecionando para a página correta com base no tipo de usuário
            if ($_SESSION['user_tipo'] == 'organizador') {
                header('Location: organizador_home.php');
            } else {
                header('Location: comprador_home.php');
            }
            exit();
        } else {
            header('Location: login.php?error=Senha incorreta');
            exit();
        }
    } else {
        header('Location: login.php?error=Usuário não encontrado');
        exit();
    }
}
?>
