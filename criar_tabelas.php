<?php
include_once 'database/conecta.php';
include_once 'models/model_user.php';
include_once 'models/model_cliente.php';
include_once 'models/model_produto.php'; 
//include_once 'models/model_venda.php';

criarTabelaUsuarios();
criarTabelaClientes();
criarTabelaProdutos();
//criarTabelasVendas()

?>