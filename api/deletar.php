<?php
include '../conexao/conexao.php';

if (isset($_GET['id_jogador'])) {
    $id_jogador = $_GET['id_jogador'];

    try {
        $sql = "DELETE FROM jogadores WHERE id_jogador = :id_jogador";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id_jogador', $id_jogador, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        // Em caso de erro, poderíamos logar ou mostrar uma mensagem
    }
}

header("Location: ../jogadores.php");
exit;
?>
