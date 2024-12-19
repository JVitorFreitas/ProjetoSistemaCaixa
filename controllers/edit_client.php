<?php
include '../database/conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    // Atualizar o cliente no banco de dados
    $query = "UPDATE clientes SET nome='$nome', email='$email', telefone='$telefone' WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        header('Location: ../pages/index.php?page=clientes.php');
        exit;
    } else {
        echo "Erro ao atualizar cliente: " . mysqli_error($conn);
    }
} else {
    $id = $_GET['id'];
    $query = "SELECT * FROM clientes WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    $cliente = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
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
        input[type="email"] {
            padding: 12px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            background-color: #f9f9f9;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
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
        <h1>Editar Cliente</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $cliente['nome']; ?>" required><br>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="<?php echo $cliente['email']; ?>" required><br>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="<?php echo $cliente['telefone']; ?>" required><br>

            <button type="submit" class="btn-add-client">Atualizar Cliente</button>
        </form>
    </main>
</body>
</html>
