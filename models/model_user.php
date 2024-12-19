<?php
include_once .'./database/conecta.php'; // Inclui o arquivo de conexão

function criarTabelaUsuarios() {
    global $conn; // Usando a variável global de conexão
    $sql = "CREATE TABLE IF NOT EXISTS usuarios (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) DEFAULT NULL,
        email VARCHAR(100) UNIQUE DEFAULT NULL,
        senha VARCHAR(255) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

    if (mysqli_query($conn, $sql)) {
        echo "Tabela 'usuarios' criada com sucesso!<br>";
    } else {
        echo "Erro ao criar tabela 'usuarios': " . mysqli_error($conn) . "<br>";
    }
}
?>
