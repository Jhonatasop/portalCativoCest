<?php
// Conectar ao banco de dados
include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $novaSenha = password_hash($_POST['novaSenha'], PASSWORD_DEFAULT);

    // Atualizar a senha no banco de dados
    $sql = "UPDATE usuarios SET senha = '$novaSenha' WHERE cpf = '$cpf'";
    if ($conn->query($sql) === TRUE) {
        // Senha atualizada com sucesso, redirecionar para a página de login
        header("Location: ../index.php");
        exit();
    } else {
        // Erro ao atualizar senha, exibir mensagem de erro
        $error_message = "Erro ao atualizar a senha: " . $conn->error;
    }
}

// Obter CPF da URL
$cpf = $_GET['cpf'];

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atualizar Senha</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<div class="logo-container">
    <img src="../cest.png" alt="Logo do cest" class="logo">
</div>
<div class="form-container">
  
    <?php if (isset($error_message)) echo "<p class='error'>$error_message</p>"; ?>
    <form method="post" action="">
        <input type="hidden" name="cpf" value="<?php echo $cpf; ?>">
        <label for="novaSenha">Nova Senha:</label>
        <input type="password" name="novaSenha" required>
        <label for="confirmarSenha">Confirmar Senha:</label>
        <input type="password" name="confirmarSenha" required>
        <input type="submit" value="Atualizar">
    </form>
    
     <a href="../esqueceu_senha.php"><button>Voltar</button></a>
  

    
</div>

</body>
</html>
