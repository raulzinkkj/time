<?php
include 'conexao/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_time = $_POST['nome_time'];

    $sql = "INSERT INTO times (nome_time)
            VALUES (:nome_time)";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam('nome_time', $nome_time);
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

        input {
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
        <h2>Nomeie seu Time</h2>
        <label for="nome_time">Nome do Time:</label>
        <input type="text" name="nome_time" id="">

        <button type="submit">Salvar</button>
    </form>
</body>

</html>