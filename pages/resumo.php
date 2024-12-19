<?php
include '../database/conecta.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    die("Erro: Usuário não autenticado!");
}

// Recebe as datas de início e fim, caso existam
$data_inicio = $_GET['data_inicio'] ?? '';
$data_fim = $_GET['data_fim'] ?? '';

// Monta a query de filtro para vendas com base nas datas
$query = "SELECT v.id, c.nome AS cliente_nome, v.total, v.data_hora, u.nome AS usuario_nome
          FROM vendas v
          JOIN clientes c ON v.cliente_id = c.id
          JOIN usuarios u ON v.usuario_id = u.id
          WHERE 1";

// Se o filtro de data estiver definido, aplica a condição na consulta
if ($data_inicio && $data_fim) {
    $query .= " AND v.data_hora BETWEEN '$data_inicio' AND '$data_fim'";
}

$query .= " ORDER BY v.data_hora DESC"; // Ordena pela data de venda (mais recente primeiro)

// Executa a consulta
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumo de Vendas</title>
</head>
<body>
    <h1>Resumo de Vendas</h1>

    <!-- Formulário de filtro -->
    <form method="GET" action="resumo.php">
        <label for="data_inicio">Data Início:</label>
        <input type="date" name="data_inicio" id="data_inicio" value="<?= $data_inicio ?>">
        
        <label for="data_fim">Data Fim:</label>
        <input type="date" name="data_fim" id="data_fim" value="<?= $data_fim ?>">
        
        <button type="submit">Filtrar</button>
    </form>

    <!-- Tabela de vendas -->
    <table border="1">
        <thead>
            <tr>
                <th>ID Venda</th>
                <th>Cliente</th>
                <th>Valor Total</th>
                <th>Data e Hora</th>
                <th>Vendedor</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0) : ?>
                <?php while ($venda = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= $venda['id'] ?></td>
                        <td><?= $venda['cliente_nome'] ?></td>
                        <td>R$ <?= number_format($venda['total'], 2, ',', '.') ?></td>
                        <td><?= date('d/m/Y H:i:s', strtotime($venda['data_hora'])) ?></td>
                        <td><?= $venda['usuario_nome'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">Nenhuma venda encontrada para o período informado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
