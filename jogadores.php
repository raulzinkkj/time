<?php
include 'conexao/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_jogador = $_POST['nome_jogador'];
    $numero_jogador = $_POST['numero_jogador'];
    $id_time = $_POST['id_time'] ?? null;

    $sql = "INSERT INTO jogadores (nome_jogador, numero_jogador, id_time)
            VALUES (:nome_jogador, :numero_jogador, :id_time)";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam('nome_jogador', $nome_jogador);
    $stmt->bindParam('numero_jogador', $numero_jogador);
    $stmt->bindParam('id_time', $id_time);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Roboto";
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 300px;
            height: 300px;
            border: 1px solid black;
            border-radius: 8px;
            padding: 10px;
        }

        input,
        select {
            width: 100%;
            height: 35px;
            border: solid 1px black;
            border-radius: 5px;
        }

        button {
            width: 100%;
            height: 40px;
            background: black;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            margin-top: 10px;
        }

        label {
            margin-top: 10px;
        }

        h2 {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <form action="" method="post">
        <h2>Monte seu Time</h2>
        <label for="id_time">Time do Jogador:</label>
        <select name="id_time" id="">
            <?php
            $sql = "SELECT * FROM times";

            $stmt = $conexao->prepare($sql);
            $stmt->execute();

            while ($time = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$time['id_time']}'> {$time['nome_time']}</option>";
            }
            ?>
        </select>

        <label for="nome_jogador">Nome do Jogador:</label>
        <input type="text" name="nome_jogador" id="">

        <label for="numero_jogador">Número do Jogador:</label>
        <input type="text" name="numero_jogador" id="">

        <button type="submit">Salvar</button>
    </form>
</body>

</html>