<?php
include '../config/database.php';

//Pegando os dados do formulário (POST)
$nome_aluno = $_POST['nome_aluno'];
$cursos_novos = $_POST['lista_cursos'] ?? []; // Se não marcar nada, vira array vazio

//Criar o aluno novo na tabela 'alunos'
$sql_aluno = "INSERT INTO alunos (nome) VALUES ('$nome_aluno')";
mysqli_query($conn, $sql_aluno);

// 4. PASSO 2: Pegar o ID que o banco acabou de gerar para esse aluno
$id_gerado = mysqli_insert_id($conn);

// 5. PASSO 3: Cadastrar os cursos marcados para esse novo ID
foreach ($cursos_novos as $id_curso) {
    $sql_relacao = "INSERT INTO aluno_curso (aluno_id, curso_id) VALUES ($id_gerado, $id_curso)";
    mysqli_query($conn, $sql_relacao);
}

// 6. Voltar para a página inicial
header("Location: ../index.php");
exit();
?>