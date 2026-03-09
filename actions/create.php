<?php
include '../config/database.php'; 
//importa o host, o usuario e a senha (que não temos)
// para ter acesso a variavel $conn que é nossa chave de conexão

//Pegando os dados do formulário em index.php linha: 69
$nome_aluno = $_POST['nome_aluno'];
$cursos_novos = $_POST['lista_cursos'] ?? []; // Se não marcar nada, vira array vazio

//O PHP cria uma variavel armazenando um comando SQL 
// "armazene na tabela Nome o valor aplicado na variavel $nome_aluno." 
$sql_aluno = "INSERT INTO alunos (nome) VALUES ('$nome_aluno')";

//função que envia o comando, ja tendo acesso pela conexão "$conn", ao banco  
//e executando a variavel $sql_aluno 
mysqli_query($conn, $sql_aluno);

//é criadpa função para retornar o ID criado automaicamente pelo Banco em AUTO_INCREMENT
$id_gerado = mysqli_insert_id($conn);

// a função foreach serve para percorrer um arraay que no caso é o $cursos_novos no index linha:74
//ele pede para que a cada curso escolhido, coloque o ID do curso junto 
foreach ($cursos_novos as $id_curso) {

    //criamos uma variavel para armazenar a função de inserir o ID do aluno e do curso que ele escolheu
    // na tabela aluno_curso, nas colunas aluno_id e curso_id
    $sql_relacao = "INSERT INTO aluno_curso (aluno_id, curso_id) VALUES ($id_gerado, $id_curso)";

    //faz a mesma função acima de abrir a conexão e enviar a função
    mysqli_query($conn, $sql_relacao);
}

//o header redireciona a pagina de volta para o index 
//e o exit é necessario para a finalização do script, nada mais roda
header("Location: ../index.php");
exit();
