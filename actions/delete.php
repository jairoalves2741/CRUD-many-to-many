<?php

include '../config/database.php';

// 2. Pega o ID que veio pelo link ?id=...
$id = $_GET['id'];

// 3. PASSO 1: Apagar as ligações do aluno com os cursos primeiro
// Se não fizer isso, o banco de dados trava por segurança (Chave Estrangeira)
mysqli_query($conn, "DELETE FROM aluno_curso WHERE aluno_id = $id");

// 4. PASSO 2: Agora sim, apaga o aluno da tabela principal
mysqli_query($conn, "DELETE FROM alunos WHERE id = $id");

// 5. Redireciona de volta para a lista
header("Location: ../index.php");
exit();
?>