<?php
session_start();

if (!isset($_SESSION['token']) || time() > $_SESSION['token_expiry']) {
    // Token não existe ou expirou
    session_unset();
    session_destroy();
    header("Location: ../pages/logar.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masterpage</title>
    <style>
        /* Estilos CSS (como mostrado anteriormente) */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        .menu {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        .menu a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-weight: bold;
        }
        .menu a:hover {
            text-decoration: underline;
        }
        .conteudo {
            padding: 20px;
            margin: 20px auto;
            max-width: 800px;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .rodape {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="menu">
        <?php include('menu.php'); ?> <!-- Incluindo o menu -->
    </div>
    <div class="conteudo">
        <?php 
        // Verifique se a variável $conteudo foi definida e não está vazia
        if(isset($conteudo) && !empty($conteudo)) {
            include($conteudo); // Inclui o conteúdo dinâmico
        } else {
            echo "<p>Selecione alguma função para continuar!</p>"; // Caso a variável não tenha valor
        }
        ?>
    </div>
    <div class="rodape">
        <?php include('rodape.php'); ?> <!-- Incluindo o rodapé -->
    </div>
</body>
</html>
