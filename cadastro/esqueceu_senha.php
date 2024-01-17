<?php
// Conectar ao banco de dados
include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];

    // Verificar se o CPF e o telefone existem no banco de dados
    $sql = "SELECT * FROM usuarios WHERE cpf = '$cpf' AND telefone = '$telefone'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // CPF e telefone correspondem, redirecionar para a página de atualização de senha
        header("Location: atualizarsenha.php?cpf=$cpf");
        exit();
    } else {
        // CPF ou telefone incorretos, exibir mensagem de erro
        $error_message = "CPF e/ou telefone incorretos. Por favor, tente novamente.";
    }
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Esqueceu a Senha</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

<div class="form-container">

    <div class="logo-container">
    <img src="../cest.png" alt="Logo do cest" class="logo">
</div>
   
    <?php if (isset($error_message)) echo "<p class='error'>$error_message</p>"; ?>
    <form method="post" action="">
        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" required>
        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" required>
        <input type="submit" value="Próximo">
        <!-- Adicionando botão de voltar -->    
    </form>
    <a href="../index.php"><button>Voltar</button></a>
</div>

</body>
</html>
