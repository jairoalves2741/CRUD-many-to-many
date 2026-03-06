<?php
include 'config/database.php';

// Pega o ID da URL. Ex: editar.php?id=2
$id = $_GET['id'];

// Busca o aluno
$sql_aluno = "SELECT * FROM alunos WHERE id = $id";
$query_aluno = mysqli_query($conn, $sql_aluno);
$aluno = mysqli_fetch_assoc($query_aluno);

// Busca quais cursos esse aluno já tem
$meus_cursos = [];
$sql_relacao = "SELECT curso_id FROM aluno_curso WHERE aluno_id = $id";
$query_relacao = mysqli_query($conn, $sql_relacao);

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
    ?>    <br>
    <button type="submit">Salvar no Banco</button>
</form>