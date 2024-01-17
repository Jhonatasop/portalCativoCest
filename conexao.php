<?php

$servername = "localhost";
$username = "usuariobanco";
$password = "senhabanco";
$dbname = "nomebanco";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para hashear a senha (use a que corresponde ao seu método de hash no banco de dados)
function hashSenha($senha) {
    return password_hash($senha, PASSWORD_BCRYPT);
}

// Função para verificar a senha
function verificarSenha($senha, $hash) {
    return password_verify($senha, $hash);
}

?>
