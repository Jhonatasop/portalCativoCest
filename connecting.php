<?php
// Inicia a sessão
session_start();

// Obtém os endereços MAC do ponto de acesso (AP) e do usuário da sessão
$mac = $_SESSION["id"];
$ap = $_SESSION["ap"];

// Carrega a biblioteca UniFi
require __DIR__ . '/vendor/autoload.php';

// Configurações para autorização no UniFi Controller
$duracao_autorizacao = 20; // Duração da autorização em minutos
$id_site = 'default'; // ID do site encontrado na URL 

$usuario_controller = 'marcos26184'; // Nome de usuário do UniFi Controller
$senha_controller = '3Lynn32019@$@'; // Senha para acesso ao UniFi Controller
$url_controller = 'https://10.0.0.103:8443'; // URL do UniFi Controller
$versao_controller = '7.1.68'; // Versão do software do Controller
$depuracao = false;

// Cria uma instância da classe UniFi API Client
$unifi_conexao = new UniFi_API\Client($usuario_controller, $senha_controller, $url_controller, $id_site, $versao_controller);

// Define o modo de depuração
$definir_modo_debug = $unifi_conexao->set_debug($depuracao);

// Faz o login no UniFi Controller
$resultados_login = $unifi_conexao->login();

// Obtém os dados do formulário se é aluno ou visitante
$tipoUsuario = $_POST['tipoUsuario'];
$cpfMatricula = $_POST['cpfMatricula'];
$senha = $_POST['senha'];

// Inclui o arquivo de conexão
include 'conexao.php';

// Consulta no banco de dados para verificar o usuário cadastrado (quando for visitante)
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

        // Registra os dados na tabela "usuarios_log"
        $nome = $row['nome'];
        $cpf = $row['cpf'];
        $telefone = $row['telefone'];
        $ip = $_SERVER['REMOTE_ADDR']; // Obtém o IP do cliente
        $hora_login = date('Y-m-d H:i:s');

        // Insere os dados na tabela "usuarios_log"
        $sql_insert_log = "INSERT INTO usuarios_log (nome, cpf, telefone, ip, mac, hora_login, hora_logout) VALUES ('$nome', '$cpf', '$telefone', '$ip', '$mac', '$hora_login', NULL)";
        $conn->query($sql_insert_log);

        // Redireciona para a página desejada
        header('Location: https://www.google.com.br');
        exit(); // Certifica-se de que o script não continua a ser executado após o redirecionamento
    } else {
        // Senha incorreta
        $mensagem = "Senha incorreta. Por favor, tente novamente.";
        echo "<script>
            alert('$mensagem');
            window.location.href = 'index.php'; // redireciona para a página desejada
            </script>";
    }
} else {
    // Usuário não encontrado
    $mensagem = "Usuário não encontrado. Por favor, verifique o CPF ou a Matrícula e a senha.";
    echo "<script>
        alert('$mensagem');
        window.location.href = 'index.php'; // redireciona para a página desejada
        </script>";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
