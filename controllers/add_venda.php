<?php
session_start(); // Inicia ou continua a sessão
include '../database/conecta.php';

// Verifica se os dados necessários estão disponíveis
if (!isset($_SESSION['cliente']) || !isset($_POST['total'])) {
    die("Dados incompletos para salvar a venda.");
}

if (!isset($_SESSION['usuario_id'])) {
    die("Erro: Usuário não autenticado!");
}

$usuario_id = $_SESSION['usuario_id'];


// Obtém os dados do cliente da sessão
$cliente = $_SESSION['cliente'];
$cliente_id = $cliente['id'];
$total = $_POST['total'];
$data_hora = date('Y-m-d H:i:s');
$usuario_id = $_SESSION['usuario_id']; // ID do usuário logado

// Insere a venda na tabela 'vendas'
$queryVenda = "
    INSERT INTO vendas (cliente_id, usuario_id, total, data_hora)
    VALUES ($cliente_id, $usuario_id, $total, '$data_hora')
";

if (mysqli_query($conn, $queryVenda)) {
    header('Location: ../pages/index.php?page=resumo.php');
} else {
    echo "Erro ao registrar a venda: " . mysqli_error($conn);
}
?>