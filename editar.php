<?php
require 'config/database.php';

$id = $_GET['id'];

// 1. Pega os dados do aluno
$sql_aluno = $pdo->prepare("SELECT * FROM alunos WHERE id = ?");
$sql_aluno->execute([$id]);
$aluno = $sql_aluno->fetch(PDO::FETCH_ASSOC);

// 2. Pega todos os cursos disponíveis
$cursos = $pdo->query("SELECT * FROM cursos")->fetchAll(PDO::FETCH_ASSOC);

// 3. Pega quais cursos ESSE aluno já tem (para marcar o checkbox)
$sql_check = $pdo->prepare("SELECT curso_id FROM aluno_curso WHERE aluno_id = ?");
$sql_check->execute([$id]);
$cursos_do_aluno = $sql_check->fetchAll(PDO::FETCH_COLUMN); // Cria um array só com os IDs
?>

<h2>Editar Aluno</h2>
<form action="editar.php?id=<?= $id ?>" method="POST">
    <input type="text" name="nome" value="<?= $aluno['nome'] ?>">
    <br><br>

    <?php foreach ($cursos as $c): ?>
        <input type="checkbox" name="cursos[]" value="<?= $c['id'] ?>" <?= in_array($c['id'], $cursos_do_aluno) ? 'checked' : '' ?>>
        <?= $c['nome'] ?> <br>

    <?php endforeach; ?>

    <br>
    <button type="submit">Atualizar</button>
</form>

<?php
// Lógica de Salvar a Edição
if ($_POST) {
    // Atualiza nome
    $up = $pdo->prepare("UPDATE alunos SET nome = ? WHERE id = ?");
    $up->execute([$_POST['nome'], $id]);

    // Atualiza Cursos: O jeito mais fácil é deletar todos e inserir os novos
    $del = $pdo->prepare("DELETE FROM aluno_curso WHERE aluno_id = ?");
    $del->execute([$id]);

    foreach ($_POST['cursos'] as $id_c) {
        $ins = $pdo->prepare("INSERT INTO aluno_curso (aluno_id, curso_id) VALUES (?, ?)");
        $ins->execute([$id, $id_c]);
    }
    header("Location: index.php");
}
?>