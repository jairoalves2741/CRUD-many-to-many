<?php
$host = "localhost"; //servidor web
$user = "root"; //nome  de usuario
$pass = "123"; //password vazia 
$db = "escola"; //Nome do Banco

//Conexão a tabela SQL 
//$conn serve como uma ponte
//então estamos transformando a variavel $conn em uma chave de conexão   
$conn = mysqli_connect($host, $user, $pass, $db);
