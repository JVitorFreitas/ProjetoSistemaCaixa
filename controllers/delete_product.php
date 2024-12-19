<?php
include '../database/conecta.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Excluir o produto no banco de dados
    $query = "DELETE FROM produtos WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        header('Location: ../pages/index.php?page=produtos.php');
        exit;
    } else {
        echo "Erro ao excluir produto: " . mysqli_error($conn);
    }
}
?>
