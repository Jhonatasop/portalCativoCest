<?php
session_start();

// Obter os endereços MAC do ponto de acesso (AP) e do usuário
$_SESSION["id"] = $_GET["id"];
$_SESSION["ap"] = $_GET["ap"];
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Portal Wi-Fi</title>
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        
        <div class="logo-container">
        <img src="cest.png" alt="Logo do cest" class="logo">
        </div>
         
        <form method="post" action="connecting.php">
            <div class="radio-group">
                <input type="radio" id="aluno" name="tipoUsuario" value="aluno" required>
                <label for="aluno">Aluno</label>
                
                <input type="radio" id="visitante" name="tipoUsuario" value="visitante" required>
                <label for="visitante">Visitante</label>
            </div>
            
            <div id="inputContainer">
                <!-- Input inicial (será substituído dinamicamente) -->
                <input type="text" name="cpfMatricula" placeholder="Inserir CPF ou Matrícula" required>
            </div>
            Senha
            <input type="password" name="senha" placeholder="Inserir Senha" required>
            <br>
            <input type="submit" value="Entrar">
        </form>
        <br><br>
        <!-- Botão de redirecionamento para a página de cadastro.php -->
        <button class="signup-button" onclick="window.location.href='cadastro/cadastro.php'">Cadastrar</button><br>

        <script>
            // Adiciona um ouvinte de evento aos radio buttons para alterar o tipo de entrada
            var radioAluno = document.getElementById('aluno');
            var radioVisitante = document.getElementById('visitante');
            var inputContainer = document.getElementById('inputContainer');
            var radioGroup = document.querySelector('.radio-group');
            
            radioAluno.addEventListener('change', function () {
                if (radioAluno.checked) {
                    inputContainer.innerHTML = '<input type="text" name="cpfMatricula" placeholder="Inserir Matrícula" required>';
                }
            });
            
            radioVisitante.addEventListener('change', function () {
                if (radioVisitante.checked) {
                    inputContainer.innerHTML = '<input type="text" name="cpfMatricula" placeholder="Inserir CPF" required>';
                }
            });
        </script>
    </body>
</html>
