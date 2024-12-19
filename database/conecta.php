<?php
$conn = mysqli_connect("localhost", "root", "") or die("Erro ao conectar com o MySQL.");
mysqli_select_db($conn, "projetofatec") or die("Erro ao selecionar o banco de dados.");
?>
