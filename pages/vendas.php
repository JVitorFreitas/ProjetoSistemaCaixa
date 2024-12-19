<?php
include '../database/conecta.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['telefone']) && !empty($_POST['telefone'])) {
    $telefone = $_POST['telefone'];

    // Busca o cliente no banco de dados
    $query = "SELECT * FROM clientes WHERE telefone = '$telefone'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $cliente = mysqli_fetch_assoc($result);
        $_SESSION['cliente'] = $cliente; // Armazena na sessão
    } else {
        $erro = "Cliente não encontrado!";
    }
}

// Se já houver cliente na sessão, mantém os dados
$cliente = $_SESSION['cliente'] ?? null;

// Inicializa o carrinho de compras
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Adiciona produto ao carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar_produto'])) {
    $produtoId = $_POST['produto_id'];
    $nomeProduto = $_POST['produto_nome'];
    $precoProduto = $_POST['produto_preco'];

    if (!isset($_SESSION['carrinho'][$produtoId])) {
        $_SESSION['carrinho'][$produtoId] = [
            'nome' => $nomeProduto,
            'quantidade' => 1,
            'preco' => $precoProduto,
        ];
    } else {
        $_SESSION['carrinho'][$produtoId]['quantidade']++;
    }
}

// Remove produto do carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remover_produto'])) {
    $produtoId = $_POST['produto_id'];
    unset($_SESSION['carrinho'][$produtoId]);
}

// Busca cliente pelo telefone
$cliente = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buscar_cliente'])) {
    $telefone = $_POST['telefone'];
    $queryCliente = "SELECT * FROM clientes WHERE telefone = '$telefone'";
    $resultCliente = mysqli_query($conn, $queryCliente);

    if ($resultCliente && mysqli_num_rows($resultCliente) > 0) {
        $cliente = mysqli_fetch_assoc($resultCliente);
    } else {
        echo "<p>Cliente não encontrado.</p>";
    }
}

// Busca produtos
$queryProdutos = "SELECT * FROM produtos";
$resultProdutos = mysqli_query($conn, $queryProdutos);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Vendas</title>
    <style>
        .container { display: flex; flex-direction: row; gap: 20px; }
        .column { flex: 1; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        .table th { background-color: #f4f4f4; }
        .total { font-weight: bold; margin-top: 20px; }
        .btn-confirmar { margin-top: 20px; padding: 10px 20px; background-color: green; color: white; border: none; cursor: pointer; }
        .btn-confirmar:hover { background-color: darkgreen; }
    </style>
</head>
<body>
    <h1>Tela de Vendas</h1>

    <!-- Formulário de Busca de Cliente -->
    <form method="POST">
        <label for="telefone">Buscar Cliente (Telefone):</label>
        <input type="text" id="telefone" name="telefone" required>
        <button type="submit" name="buscar_cliente">Buscar</button>
    </form>

    <?php if ($cliente): ?>
        <p><strong>Cliente Selecionado:</strong></p>
        <p>Nome: <?= $cliente['nome'] ?></p>
        <p>Telefone: <?= $cliente['telefone'] ?></p>
    <?php endif; ?>

    <div class="container">
        <!-- Lista de Produtos -->
        <div class="column">
            <h2>Produtos</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($produto = mysqli_fetch_assoc($resultProdutos)): ?>
                        <tr>
                            <td><?= $produto['nome'] ?></td>
                            <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
                                    <input type="hidden" name="produto_nome" value="<?= $produto['nome'] ?>">
                                    <input type="hidden" name="produto_preco" value="<?= $produto['preco'] ?>">
                                    <button type="submit" name="adicionar_produto">Adicionar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Carrinho de Compras -->
        <div class="column">
            <h2>Carrinho de Compras</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Total</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalVenda = 0;
                    foreach ($_SESSION['carrinho'] as $produtoId => $item): 
                        $subtotal = $item['quantidade'] * $item['preco'];
                        $totalVenda += $subtotal;
                    ?>
                        <tr>
                            <td><?= $item['nome'] ?></td>
                            <td><?= $item['quantidade'] ?></td>
                            <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="produto_id" value="<?= $produtoId ?>">
                                    <button type="submit" name="remover_produto">Remover</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p class="total">Total: R$ <?= number_format($totalVenda, 2, ',', '.') ?></p>

            <!-- Botão Confirmar -->
            <form action="../controllers/add_venda.php" method="POST">
                <input type="hidden" name="telefone" value="<?= $cliente['telefone'] ?? '' ?>">
                <input type="hidden" name="total" value="<?= $totalVenda ?? 0 ?>">
                <button type="submit" class="btn btn-success">Confirmar Venda</button>
        </form>
        </div>
    </div>
</body>
</html>
