<?php
require '../config/database.php';

$nome = $_POST['nome_aluno'];
$cursos_selecionados = $_POST['meus_cursos'] ?? []; // Se não marcar nada, vem vazio

// 1. Salva o Aluno
$sql = $pdo->prepare("INSERT INTO alunos (nome) VALUES (?)");
$sql->execute([$nome]);
$id_aluno = $pdo->lastInsertId(); // Pega o ID que acabou de ser criado

// 2. Salva as ligações na tabela intermediária
foreach($cursos_selecionados as $id_curso) {
    $sql_link = $pdo->prepare("INSERT INTO aluno_curso (aluno_id, curso_id) VALUES (?, ?)");
    $sql_link->execute([$id_aluno, $id_curso]);
}

// Volta para a página inicial
header("Location: ../index.php");