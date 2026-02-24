<?php
require '../config/database.php';

$id = $_GET['id'];

// Deleta o aluno (O MySQL vai deletar a ligação se você usou ON DELETE CASCADE)
$sql = $pdo->prepare("DELETE FROM alunos WHERE id = ?");
$sql->execute([$id]);

header("Location: ../index.php");