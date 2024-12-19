<?php
include '../database/conecta.php';


// Criação das tabelas 'vendas' e 'itens_venda'
function criarTabelasVendas()
{
    $queryVendas = "
        CREATE TABLE IF NOT EXISTS vendas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            cliente_id INT NOT NULL,
            usuario_id INT NOT NULL,
            total DECIMAL(10, 2) NOT NULL,
            data_hora DATETIME NOT NULL,
            FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ";

    $queryItensVenda = "
        CREATE TABLE IF NOT EXISTS itens_venda (
            id INT AUTO_INCREMENT PRIMARY KEY,
            venda_id INT NOT NULL,
            produto_id INT NOT NULL,
            quantidade INT NOT NULL,
            FOREIGN KEY (venda_id) REFERENCES vendas(id) ON DELETE CASCADE,
            FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ";

    if (mysqli_query($conn, $queryVendas)) {
        echo "Tabela 'vendas' criada com sucesso!<br>";
    } else {
        echo "Erro ao criar tabela 'vendas': " . mysqli_error($conn) . "<br>";
    }

    if (mysqli_query($conn, $queryItensVenda)) {
        echo "Tabela 'itens_venda' criada com sucesso!<br>";
    } else {
        echo "Erro ao criar tabela 'itens_venda': " . mysqli_error($conn) . "<br>";
    }
}

// Verifica se as tabelas referenciadas existem
function verificarTabelasExistentes($conn)
{
    $tabelas = ['clientes', 'usuarios', 'produtos'];
    foreach ($tabelas as $tabela) {
        $query = "SHOW TABLES LIKE '$tabela'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) === 0) {
            die("Erro: A tabela '$tabela' não existe no banco de dados.<br>");
        }
    }
}

// Verifica tabelas e cria tabelas de vendas
verificarTabelasExistentes($conn);
criarTabelasVendas($conn);
?>
