<?php
include_once '../database/conecta.php'; // Inclui o arquivo de conexão

function criarTabelaClientes() {
    global $conn; // Usando a variável global de conexão
    $sql = "CREATE TABLE IF NOT EXISTS clientes (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) DEFAULT NULL,
        email VARCHAR(100) UNIQUE DEFAULT NULL,
        telefone VARCHAR(15) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

    if (mysqli_query($conn, $sql)) {
        echo "Tabela 'clientes' criada com sucesso!<br>";
    } else {
        echo "Erro ao criar tabela 'clientes': " . mysqli_error($conn) . "<br>";
    }
}
?>

