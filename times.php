<?php
include 'conexao/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_time = $_POST['nome_time'];

    if ($nome_time) {
        $sql = "INSERT INTO times (nome_time) VALUES (:nome_time)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':nome_time', $nome_time);
        $stmt->execute();
        
        header("Location: times.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Time</title>
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

        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input {
            width: 100%;
            height: 40px;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 0 10px;
        }

        button {
            width: 100%;
            height: 40px;
            background: #007bff;
            border: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 10px;
        }

        button:hover {
            background: #0056b3;
        }

        .nav-links {
            margin-top: 20px;
            text-align: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .list-times {
            margin-top: 30px;
            width: 100%;
        }

        .list-times ul {
            list-style: none;
            padding: 0;
        }

        .list-times li {
            padding: 10px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="" method="post">
            <h2>Nomeie seu Time</h2>
            <div class="form-group">
                <label for="nome_time">Nome do Time:</label>
                <input type="text" name="nome_time" id="nome_time" required placeholder="Ex: Real Madrid">
            </div>

            <button type="submit">Salvar Time</button>
        </form>

        <div class="nav-links">
            <a href="jogadores.php">Gerenciar Jogadores →</a>
        </div>

        <div class="list-times">
            <h3>Times Cadastrados</h3>
            <ul>
                <?php
                $sql = "SELECT * FROM times ORDER BY nome_time";
                $stmt = $conexao->prepare($sql);
                $stmt->execute();
                while ($time = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<li>{$time['nome_time']}</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</body>

</html>
