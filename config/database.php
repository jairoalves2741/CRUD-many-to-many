<?php
$host = "localhost"; //servidor web
$user = "root"; //nome  de usuario
$pass = ""; //password vazia 
$db = "escola"; //Nome do Banco

//Conexão ao codigo  --  
//$conn serve como uma ponte
//então estamos transformando a variavel $conn em uma chave de conexão   
$conn = mysqli_connect($host, $user, $pass, $db);
?>