<?php

include '../config/database.php';

//quando tem uma requisição de excluir a requisição vem pra ca 
//informando qual é o ID do aluno por meio da funçaõ $listar (index.php linha 89 )
$id = $_GET['id'];

//a função roda sequencialmente 
mysqli_query($conn, "DELETE FROM aluno_curso WHERE aluno_id = $id");

// 4. PASSO 2: Agora sim, apaga o aluno da tabela principal
mysqli_query($conn, "DELETE FROM alunos WHERE id = $id");

// 5. Redireciona de volta para a lista
header("Location: ../index.php");
exit();
?>