<?php
// Definindo qual conteúdo será carregado dinamicamente
$conteudo = isset($_GET['page']) ? $_GET['page'] : 'clientes.php'; // Define 'clientes.php' como padrão
include('masterpage.php');
?>
