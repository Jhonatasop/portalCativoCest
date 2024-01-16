<?php

// Inicia a sessão
session_start();

// Obtém os endereços MAC do ponto de acesso (AP) e do usuário da sessão
$mac = $_SESSION["id"];
$ap = $_SESSION["ap"];

// Carrega a biblioteca UniFi
require __DIR__ . '/vendor/autoload.php';

// Configurações para autorização no UniFi Controller
$duracao_autorizacao = 30; // Duração da autorização em minutos
$id_site = 'default'; // ID do site encontrado na URL 

$usuario_controller = 'marcos26184'; // Nome de usuário para acesso ao UniFi Controller
$senha_controller = '3Lynn32019@$@'; // Senha para acesso ao UniFi Controller
$url_controller = 'https://10.0.0.109:8443'; // URL completa para o UniFi Controller, por exemplo, 'https://22.22.11.11:8443'
$versao_controller = '7.1.68'; // Versão do software do Controller, por exemplo, '4.6.6' (deve ser pelo menos 4.0.0)
$depuracao = false;

// Cria uma instância da classe UniFi API Client
$unifi_conexao = new UniFi_API\Client($usuario_controller, $senha_controller, $url_controller, $id_site, $versao_controller);

// Define o modo de depuração
$definir_modo_debug = $unifi_conexao->set_debug($depuracao);

// Faz o login no UniFi Controller
$resultados_login = $unifi_conexao->login();

// Obtém os dados do formulário
$tipoUsuario = $_POST['tipoUsuario'];
$cpfMatricula = $_POST['cpfMatricula'];
$senha = $_POST['senha'];

// Inclui o arquivo de conexão
include 'conexao.php';

// Consulta no banco de dados para verificar o usuário
$sql = "SELECT * FROM usuarios WHERE ";

if ($tipoUsuario == 'aluno') {
    $sql .= "matricula = '$cpfMatricula'";
} elseif ($tipoUsuario == 'visitante') {
    $sql .= "cpf = '$cpfMatricula'";
} else {
    // Tipo de usuário não reconhecido
    echo "Tipo de usuário não reconhecido.";
    exit;
}

$result = $conn->query($sql);

// Verifica se o usuário foi encontrado no banco de dados
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verifica a senha hasheada
    if (password_verify($senha, $row['senha'])) {
        // Usuário autenticado com sucesso

        // Autoriza o acesso do usuário na rede Wi-Fi
        $resultado_autorizacao = $unifi_conexao->authorize_guest($mac, $duracao_autorizacao, $up = null, $down = null, $MBytes = null, $ap);

        // Exibe a mensagem de sucesso
        echo "<!doctype html>
                <html lang='pt-br'>
                    <head>
                        <meta charset='utf-8'>
                        <title>Portal Wi-Fi</title>
                        <meta name='viewport' content='width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no'>
                        <meta http-equiv='refresh' content='3;url=https://cest.edu.br/' />
                    </head>
                    <body>
                            <p>Você está online! <br>
                            </p>
                    </body>
                </html>";

    } else {
        // Senha incorreta
        echo "Senha incorreta. Por favor, tente novamente.";
    }

} else {
    // Usuário não encontrado
    echo "Usuário não encontrado. Por favor, verifique o CPF ou a Matrícula e a senha.";
}

// Fecha a conexão com o banco de dados
$conn->close();

?>
