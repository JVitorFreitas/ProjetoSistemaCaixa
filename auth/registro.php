<?php
include '../database/conecta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT); // Criptografa a senha

    // Verifica se o e-mail já existe
    $verificaEmail = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conn, $verificaEmail);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "E-mail já cadastrado! Tente outro.";
    } else {
        // Insere o novo usuário no banco
        $query = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
        if (mysqli_query($conn, $query)) {
            header('Location: ../pages/logar.php');
        } else {
            echo "Erro ao registrar usuário: " . mysqli_error($conn);
        }
    }
} else {
    header('Location: ../pages/register.php');
    exit();
}
?>
