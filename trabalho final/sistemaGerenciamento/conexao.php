<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'trabalho_aps2';

// Conectar ao banco de dados
$conexao = new mysqli($host, $user, $password, $dbname);

// Verificar conexão
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}
?>
