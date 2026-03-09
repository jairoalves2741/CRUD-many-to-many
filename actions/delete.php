<?php

include '../config/database.php';

//quando tem uma requisição de excluir a requisição vem pra ca 
//informando qual é o ID do aluno por meio da funçaõ $listar (index.php linha 89 )
$id = $_GET['id'];

//As duas funções rodam sequencialmente, preferi primeiro excluir as foreing key as chaves dependentes
//para depois excluir as colunas,mas deixei dentro de um try catch 
// para previnir do aluno ficar orfão dentro do BD, sem curso. 
try {
    mysqli_query($conn, "DELETE FROM aluno_curso WHERE aluno_id = $id");

    mysqli_query($conn, "DELETE FROM alunos WHERE id = $id");

    mysqli_commit($conn);
} catch (Exception $e) {
    // Se algo deu errado, desfaz a operação e mostra o erro na variavel .
    // E ISSO é chamado de rollback "voltar atrás"
    mysqli_rollback($conn);
    echo "Erro ao deletar: " . $e->getMessage();
}

//Redireciona de volta para a lista na pgina inicial e o exit finaliza o script
header("Location: ../index.php");
exit();