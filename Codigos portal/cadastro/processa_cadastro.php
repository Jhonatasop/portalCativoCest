<?php
// Conectar ao banco de dados
include '../conexao.php';

// Receber os dados do formulário
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

// Obter data e hora atuais
$dataHoraCadastro = date("Y-m-d H:i:s");

// Obter endereço IP do cliente
$ip = $_SERVER['REMOTE_ADDR'];

// Função para obter o endereço MAC
function getMACAddress(){
    exec("ipconfig /all", $output);
    foreach($output as $line){
        if (preg_match('/Physical.*: (.*)/', $line, $mac)){
            return $mac[1];
        }
    }
    return null;
}

// Obter endereço MAC
$mac = getMACAddress();

// Verificar se o CPF já foi cadastrado
$sql_cpf = "SELECT * FROM usuarios WHERE cpf = '$cpf'";
$result_cpf = $conn->query($sql_cpf);

if ($result_cpf->num_rows > 0) {
    // CPF já cadastrado, exibir mensagem de alerta
    echo '<script>alert("CPF já cadastrado. Por favor, escolha outro.");</script>';
    echo '<script>window.location.href="cadastro.php";</script>';
    $conn->close();
    exit();
}

// Verificar se o e-mail já foi cadastrado
$sql_email = "SELECT * FROM usuarios WHERE email = '$email'";
$result_email = $conn->query($sql_email);

if ($result_email->num_rows > 0) {
    // E-mail já cadastrado, exibir mensagem de alerta
    echo '<script>alert("E-mail já cadastrado. Por favor, escolha outro.");</script>';
    echo '<script>window.location.href="cadastro.php";</script>';
    $conn->close();
    exit();
}

// Inserir os dados no banco de dados
$sql = "INSERT INTO usuarios (nome, cpf, telefone, email, senha, data_hora_cadastro, ip, mac) 
        VALUES ('$nome', '$cpf', '$telefone', '$email', '$senha', '$dataHoraCadastro', '$ip', '$mac')";

if ($conn->query($sql) === TRUE) {
    // Cadastro bem-sucedido, exibir mensagem de alerta e redirecionar
    echo '<script>alert("Cadastro bem-sucedido!");</script>';
    echo '<script>window.location.href="index.php";</script>';
    $conn->close();
    exit(); // Certifique-se de parar a execução do script após o redirecionamento
} else {
    // Erro ao cadastrar, exibir mensagem de alerta com detalhes do erro
    echo '<script>alert("Erro ao cadastrar: ' . $conn->error . '");</script>';
}

// Fechar a conexão
$conn->close();
?>
