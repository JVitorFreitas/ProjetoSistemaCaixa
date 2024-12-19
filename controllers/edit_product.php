<?php
include '../database/conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    // Atualizar o produto no banco de dados
    $query = "UPDATE produtos SET nome='$nome', descricao='$descricao', preco='$preco' WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        header('Location: ../pages/index.php?page=produtos.php');
        exit;
    } else {
        echo "Erro ao atualizar produto: " . mysqli_error($conn);
    }
} else {
    $id = $_GET['id'];
    $query = "SELECT * FROM produtos WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    $produto = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<style>
        /* Resetando margens e padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Estilo básico para o corpo da página */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Cabeçalho */
        header {
            background-color: #007bff;
            color: white;
            padding: 20px 0;
            text-align: center;
            width: 100%;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2rem;
            text-align: center;
        }

        /* Container principal */
        .content {
            max-width: 600px;
            width: 100%;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        /* Formulário */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 1rem;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"] {
            padding: 12px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            background-color: #f9f9f9;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="email"]:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 12px;
            font-size: 1.1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Links */
        p {
            text-align: center;
            font-size: 1rem;
            margin-top: 20px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .content {
                padding: 20px;
            }

            button {
                font-size: 1rem;
            }
        }
    </style>
<body>
    <main class="content">
        <h1>Editar Produto</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $produto['nome']; ?>" required><br>

            <label for="descricao">Descrição:</label>
            <input type="text" id="descricao" name="descricao" value="<?php echo $produto['descricao']; ?>" required><br>

            <label for="preco">Preço:</label>
            <input type="number" id="preco" name="preco" value="<?php echo $produto['preco']; ?>" step="0.01" required><br>

            <button type="submit" class="btn-add-product">Atualizar Produto</button>
        </form>
    </main>
</body>
</html>
