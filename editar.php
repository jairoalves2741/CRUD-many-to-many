<?php
include 'config/database.php';

// assim como no delete, o editar tanbem recebe uma requisiçaõ
//informando qual é o ID do aluno por meio da funçaõ $listar (index.php linha 89 )
$id = $_GET['id'];

//busc o aluno no BD pelo ID 
$sql_aluno = "SELECT * FROM alunos WHERE id = $id";

//a função da variavel esta dizendo "preciso que entre no BD pela chave $conn
// pegue e armazene esse derterminado ID em mim"
$query_aluno = mysqli_query($conn, $sql_aluno);

//essa viaravel tem a função mysqli_fetch_assoc
//capaz de decifrar a mensagn que o BD mandou para a variel $query_aluno
$aluno = mysqli_fetch_assoc($query_aluno);

//deixo um array vazio para armazenar os cursos que o aluno tem
$meus_cursos = [];

//novamente, crio uma variavel que armazena uma função de execução
$sql_relacao = "SELECT curso_id FROM aluno_curso WHERE aluno_id = $id";


//atraves da funçaõ mysqli_query que o BD faz a analise e armazena informação em $query_relacao
$query_relacao = mysqli_query($conn, $sql_relacao);

//a funçaõ mysqli_fetch_assoc vai ler uma linha por vez do resultado da requisição que fizemos 
//temos que usar o while porqwe assim executamos a função mysqli_fetch_assoc quantas vezes forem necessararias
//ate aparecer todos os cursos do alunom, e armazenar no array que criamos acima, linha - 20 
while ($linha = mysqli_fetch_assoc($query_relacao)) {
    $meus_cursos[] = $linha['curso_id'];
}
?>

<h2>Editar Aluno</h2>
<form action="actions/create.php?id=<?php echo $id; ?>" method="POST">
    Nome: <input type="text" name="nome_aluno" value="<?php echo $aluno['nome']; ?>">
    <br><br>

    <strong>Cursos:</strong><br>
    <?php
    $query_todos = mysqli_query($conn, "SELECT * FROM cursos");
    while ($curso = mysqli_fetch_assoc($query_todos)) {
        // Verifica se o ID do curso está na lista do aluno
        $checado = in_array($curso['id'], $meus_cursos) ? "checked" : "";

        echo "<input type='checkbox' name='lista_cursos[]' value='{$curso['id']}' $checado>";
        echo $curso['nome'] . "<br>";
    }
    ?> <br>
    <button type="submit">Salvar no Banco</button>
</form>