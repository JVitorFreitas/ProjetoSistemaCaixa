<?php
include '../database/conecta.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Excluir o cliente no banco de dados
    $query = "DELETE FROM clientes WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        header('Location: ../pages/index.php?page=clientes.php');
        exit;
    } else {
        echo "Erro ao excluir cliente: " . mysqli_error($conn);
    }
}
?>
