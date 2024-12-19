<?php
include '../database/conecta.php';
$query = "SELECT * FROM clientes";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <style>
        /* Estilo geral */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            width: 90%;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .table th {
            background-color: #f4f4f4;
        }

        .table tr:hover {
            background-color: #f1f1f1;
        }

        .btn-confirmar {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 5px;
            font-size: 14px;
        }

        .btn-confirmar:hover {
            background-color: darkgreen;
        }

        .add-button {
            display: inline-block;
            padding: 12px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .add-button:hover {
            background-color: #45a049;
        }

        .actions {
            display: flex;
            justify-content: space-between;
        }

        .actions .btn-confirmar {
            margin: 5px;
        }

        /* Restrições para telas menores */
        @media (max-width: 768px) {
            .table th, .table td {
                padding: 8px;
            }

            .add-button {
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Clientes</h1>
    </header>

    <main class="content">
        <a href="../controllers/add_client.php" class="add-button">Adicionar Cliente</a>

        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['nome']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['telefone']; ?></td>
                        <td class="actions">
                            <a href="../controllers/edit_client.php?id=<?php echo $row['id']; ?>" class="btn-confirmar">Editar</a>
                            <a href="../controllers/delete_client.php?id=<?php echo $row['id']; ?>" class="btn-confirmar">Excluir</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
