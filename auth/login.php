<?php
session_start();
include '../database/conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consulta para verificar o usuário
    $query = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $usuario = mysqli_fetch_assoc($result);

        // Verifica se a senha é válida
        if (password_verify($senha, $usuario['senha'])) { // Verifica a senha criptografada
            // Gera um token seguro
            $token = bin2hex(random_bytes(32));
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['token'] = $token;
            $_SESSION['token_expiry'] = time() + 1800; // Token expira em 30 minutos

            // Redireciona para a página index
            header("Location: ../pages/masterpage.php");
            exit();
        } else {
            echo "Senha inválida!";
        }
    } else {
        echo "Usuário não encontrado!";
    }
} else {
    header('Location:  ../pages/logar.php');
    exit();
}
?>
