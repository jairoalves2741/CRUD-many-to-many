<?php
// Dados do banco
$host = "localhost";
$banco = "escola";
$usuario = "root";
$senha = "";

try {
    // Cria a conexão PDO
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
} catch (Exception $e) {
    echo "Erro ao conectar: " . $e->getMessage();
}           