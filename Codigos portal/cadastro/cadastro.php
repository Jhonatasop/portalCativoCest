<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" type="text/css" href="../css/cad.style.css">
    <title>Cadastro</title>
   
</head>
<body>

 
<div class="logo-container">
    <img src="../cest.png" alt="Logo do cest" class="logo">
</div>

<form action="processa_cadastro.php" method="post" onsubmit="return validarCPF()">
    <label for="nome">NOME COMPLETO</label>
    <input type="text" name="nome" maxlength="50" required>

    <label for="cpf">CPF:</label>
    <input type="text" name="cpf" id="cpf" maxlength="11" oninput="validarNumero(this)" required>

    <label for="telefone">TELEFONE</label>
    <input type="text" name="telefone" maxlength="11" required>

    <label for="email">EMAIL</label>
    <input type="email" name="email" required>

    <label for="senha">SENHA</label>
    <input type="password" name="senha" required>

    <input type="submit" value="CADASTRAR">

    <button onclick="window.location.href='../index.php'">VOLTAR</button>
</form>

<script>
    function validarCPF() {
        // Recupera o valor do CPF
        var cpf = document.getElementById('cpf').value;

        // Remove caracteres não numéricos
        cpf = cpf.replace(/\D/g, '');

        // Verifica se o CPF tem 11 dígitos
        if (cpf.length !== 11) {
            alert('CPF inválido. Certifique-se de inserir 11 dígitos.');
            return false;
        }

        // Validação do CPF
        var soma = 0;
        for (var i = 0; i < 9; i++) {
            soma += parseInt(cpf.charAt(i)) * (10 - i);
        }
        var resto = 11 - (soma % 11);
        var digitoVerificador1 = (resto >= 10) ? 0 : resto;

        soma = 0;
        for (var i = 0; i < 10; i++) {
            soma += parseInt(cpf.charAt(i)) * (11 - i);
        }
        resto = 11 - (soma % 11);
        var digitoVerificador2 = (resto >= 10) ? 0 : resto;

        if (digitoVerificador1 !== parseInt(cpf.charAt(9)) || digitoVerificador2 !== parseInt(cpf.charAt(10))) {
            alert('CPF inválido. Verifique os dígitos verificadores.');
            document.getElementById('cpf').value = '';  // Limpa o campo CPF
            return false;
        }

        // Se passou nas validações, retorna true para permitir o envio do formulário
        return true;
    }


        function validarNumero(input) {
        // Remove caracteres não numéricos do campo
        input.value = input.value.replace(/\D/g, '');
    }

</script>

</body>
</html>