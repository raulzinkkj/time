<?php
include 'conexao/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_jogador = $_POST['nome_jogador'];
    $numero_jogador = $_POST['numero_jogador'];
    $id_time = $_POST['id_time'] ?? null;

    if ($nome_jogador && $numero_jogador && $id_time) {
        $sql = "INSERT INTO jogadores (nome_jogador, numero_jogador, id_time)
                VALUES (:nome_jogador, :numero_jogador, :id_time)";

        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':nome_jogador', $nome_jogador);
        $stmt->bindParam(':numero_jogador', $numero_jogador);
        $stmt->bindParam(':id_time', $id_time);
        $stmt->execute();
        
        header("Location: jogadores.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Jogadores</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
            background-color: #f4f4f9;
            padding: 20px;
        }

        .form-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            margin-bottom: 30px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            height: 40px;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 0 10px;
        }

        .btn-salvar {
            width: 100%;
            height: 40px;
            background: #28a745;
            border: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-salvar:hover {
            background: #218838;
        }

        .list-container {
            width: 100%;
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
        }

        .acoes {
            display: flex;
            gap: 10px;
        }

        .btn-acao {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            padding: 5px;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .btn-edit:hover { background-color: #e7f3ff; }
        .btn-delete:hover { background-color: #ffe7e7; }

        .nav-links {
            margin-bottom: 20px;
        }
        
        .nav-links a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="nav-links">
        <a href="times.php">← Cadastrar Times</a>
    </div>

    <div class="form-container">
        <form action="" method="post">
            <h2>Monte seu Time</h2>
            <div class="form-group">
                <label for="id_time">Time do Jogador:</label>
                <select name="id_time" id="id_time" required>
                    <option value="">Selecione um time</option>
                    <?php
                    $sql = "SELECT * FROM times ORDER BY nome_time";
                    $stmt = $conexao->prepare($sql);
                    $stmt->execute();
                    while ($time = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$time['id_time']}'> {$time['nome_time']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="nome_jogador">Nome do Jogador:</label>
                <input type="text" name="nome_jogador" id="nome_jogador" required>
            </div>

            <div class="form-group">
                <label for="numero_jogador">Número do Jogador:</label>
                <input type="number" name="numero_jogador" id="numero_jogador" required>
            </div>

            <button type="submit" class="btn-salvar">Salvar Jogador</button>
        </form>
    </div>

    <div class="list-container">
        <h3>Lista de Jogadores</h3>
        <table>
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Jogador</th>
                    <th>Nº</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql_jogadores = "SELECT j.id_jogador, t.nome_time, j.nome_jogador, j.numero_jogador 
                                 FROM jogadores AS j 
                                 INNER JOIN times AS t ON t.id_time = j.id_time 
                                 ORDER BY t.nome_time, j.nome_jogador";
                $stmt_jogadores = $conexao->prepare($sql_jogadores);
                $stmt_jogadores->execute();

                while ($linha = $stmt_jogadores->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>{$linha['nome_time']}</td>";
                    echo "<td>{$linha['nome_jogador']}</td>";
                    echo "<td>{$linha['numero_jogador']}</td>";
                    echo "<td class='acoes'>";
                    
                    // Botão Editar
                    echo "<a href='api/editar.php?id_jogador={$linha['id_jogador']}' class='btn-acao btn-edit' title='Editar'>✏️</a>";
                    
                    // Botão Deletar
                    echo "<a href='api/deletar.php?id_jogador={$linha['id_jogador']}' class='btn-acao btn-delete' title='Excluir' onclick=\"return confirm('Tem certeza que deseja excluir este jogador?')\">🗑️</a>";
                    
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
