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

<style>
        body {
            background: linear-gradient(to bottom, #3498db, #2980b9);
            color: #fff;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .logo-container {
            margin-bottom: 20px;
        }

        .logo {
            max-width: 100%;
            height: auto;
        }

        form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        form p {
            margin-bottom: 20px;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        form input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .error-message {
            color: #e74c3c;
            margin-top: 10px;
        }
    </style>



    </head>
    <body>

<div class="logo-container">
    <img src="cest.png" alt="Logo da Empresa" class="logo">
</div>


		<form method="post" action="connecting.php">
			CPF
			<input type="text" name="cpf" placeholder="Inserir CPF"><br>
			Senha
			<input type="password" name="senha" placeholder="Inserir Senha"><br>
			<input type="submit" value="Entrar">
		</form>
    </body>
</html>
