<?php
include_once '../database/conecta.php';

function criarTabelaProdutos() {
    global $conn; // Usando a variável global de conexão
    $sql = "CREATE TABLE IF NOT EXISTS produtos (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) DEFAULT NULL,
        preco DECIMAL(10, 2) DEFAULT NULL,
        descricao VARCHAR(50) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

    if (mysqli_query($conn, $sql)) {
        echo "Tabela 'produtos' criada com sucesso!<br>";
    } else {
        echo "Erro ao criar tabela 'produtos': " . mysqli_error($conn) . "<br>";
    }
}
?>
