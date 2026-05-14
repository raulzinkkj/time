<?php
include '../conexao/conexao.php';

// PEGA O ID DO JOGADOR
if (!isset($_GET['id_jogador'])) {
    header('Location: ../jogadores.php');
    exit;
}

$id_jogador = $_GET['id_jogador'];

// BUSCA OS DADOS DO JOGADOR
$sql_jogador = "SELECT * FROM jogadores WHERE id_jogador = :id_jogador";
$stmt_jogador = $conexao->prepare($sql_jogador);
$stmt_jogador->bindParam(':id_jogador', $id_jogador, PDO::PARAM_INT);
$stmt_jogador->execute();
$jogador = $stmt_jogador->fetch(PDO::FETCH_ASSOC);

if (!$jogador) {
    header('Location: ../jogadores.php');
    exit;
}

// ATUALIZA O JOGADOR
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_jogador = $_POST['nome_jogador'];
    $numero_jogador = $_POST['numero_jogador'];
    $id_time = $_POST['id_time'];

    $sql_update = "
        UPDATE jogadores
        SET
            nome_jogador = :nome_jogador,
            numero_jogador = :numero_jogador,
            id_time = :id_time
        WHERE id_jogador = :id_jogador
    ";

    $stmt_update = $conexao->prepare($sql_update);
    $stmt_update->bindParam(':nome_jogador', $nome_jogador);
    $stmt_update->bindParam(':numero_jogador', $numero_jogador);
    $stmt_update->bindParam(':id_time', $id_time, PDO::PARAM_INT);
    $stmt_update->bindParam(':id_jogador', $id_jogador, PDO::PARAM_INT);

    $stmt_update->execute();

    header('Location: ../jogadores.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Jogador</title>
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
            height: 100vh;
            background: #f4f4f9;
        }

        .form-container {
            width: 350px;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        label {
            margin-top: 10px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            height: 40px;
            padding: 0 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn-salvar {
            margin-top: 20px;
            height: 40px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn-salvar:hover {
            background: #0056b3;
        }

        .btn-cancelar {
            margin-top: 10px;
            text-align: center;
            text-decoration: none;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <form action="" method="post">
            <h2>Editar Jogador</h2>

            <label for="id_time">Time</label>
            <select name="id_time" id="id_time" required>
                <?php
                $sql_times = "SELECT * FROM times ORDER BY nome_time";
                $stmt_times = $conexao->query($sql_times);
                while ($time = $stmt_times->fetch(PDO::FETCH_ASSOC)) {
                    $selected = ($time['id_time'] == $jogador['id_time']) ? 'selected' : '';
                    echo "<option value='{$time['id_time']}' $selected>{$time['nome_time']}</option>";
                }
                ?>
            </select>

            <label for="nome_jogador">Nome do Jogador</label>
            <input type="text" name="nome_jogador" id="nome_jogador" value="<?= htmlspecialchars($jogador['nome_jogador']) ?>" required>

            <label for="numero_jogador">Número do Jogador</label>
            <input type="number" name="numero_jogador" id="numero_jogador" value="<?= htmlspecialchars($jogador['numero_jogador']) ?>" required>

            <button type="submit" class="btn-salvar">Salvar Alterações</button>
            <a href="../jogadores.php" class="btn-cancelar">Cancelar</a>
        </form>
    </div>
</body>

</html>
