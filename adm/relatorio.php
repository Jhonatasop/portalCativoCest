<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Relatórios</title>
    <link rel="stylesheet" type="text/css" href="rel.style.css">
</head>
<body>



    <div class="container">

         <h1>RELATÓRIO DE ACESSOS</h1>
       

       <!-- Formulário de pesquisa -->
<form method="post" action="" class="search-form">
    <div class="form-group">
        <label for="data">Pesquisar por Data:</label>
        <input type="date" id="data" name="data">
    </div>
    
    <div class="form-group">
        <label for="cpf">Pesquisar por CPF:</label>
        <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF">
    </div>
        
    <div class="form-group">
        <label for="mac">Pesquisar por MAC:</label>
        <input type="text" id="mac" name="mac" placeholder="Digite o MAC">
    </div>
    
    <div class="form-group">
        <label for="nome">Pesquisar por Nome:</label>
        <input type="text" id="nome" name="nome" placeholder="Digite o Nome">
    </div>
    
    <div class="form-group">
        <input type="submit" value="Pesquisar">
    </div>
</form>


        <?php
        include '../conexao.php';

        // Processar os filtros
        $filtro_data = isset($_POST['data']) ? $_POST['data'] : '';
        $filtro_cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
        $filtro_mac = isset($_POST['mac']) ? $_POST['mac'] : '';
        $filtro_nome = isset($_POST['nome']) ? $_POST['nome'] : '';

        // Montar a consulta SQL com base nos filtros
        $sql = "SELECT nome, cpf, ip, mac, hora_login, hora_logout FROM usuarios_log WHERE 1";

        if (!empty($filtro_data)) {
            $sql .= " AND DATE(hora_login) = '$filtro_data'";
        }

        if (!empty($filtro_cpf)) {
            $sql .= " AND cpf LIKE '%$filtro_cpf%'";
        }

        
        if (!empty($filtro_mac)) {
            $sql .= " AND mac LIKE '%$filtro_mac%'";
        }

        if (!empty($filtro_nome)) {
            $sql .= " AND nome LIKE '%$filtro_nome%'";
        }

        $result = $conn->query($sql);

        if (!$result) {
            die("Erro na consulta: " . $conn->error);
        }

        if ($result->num_rows > 0) {
            // Exibir os resultados
            echo '<table>';
            echo '<tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>IP</th>
                    <th>MAC</th>
                    <th>Hora de Login</th>
                    <th>Hora de Logout</th>
                </tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['nome'] . '</td>';
                echo '<td>' . $row['cpf'] . '</td>';
                echo '<td>' . $row['ip'] . '</td>';
                echo '<td>' . $row['mac'] . '</td>';
                echo '<td>' . $row['hora_login'] . '</td>';
                echo '<td>' . $row['hora_logout'] . '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo 'Nenhum registro encontrado com os filtros aplicados.';
        }
        ?>
    </div>

</body>
</html>
