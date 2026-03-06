<?php
// 1. Conecta ao banco usando o arquivo que criamos
require 'config/database.php';

// 2. Pega todos os cursos (Usando mysqli_query em vez de PDO)
$query_cursos = mysqli_query($conn, "SELECT * FROM cursos");



//LINHA DE CODIGO PARA O BANCO DE DADOS



/*  CREATE DATABASE IF NOT EXISTS escola;

USE escola;



CREATE TABLE IF NOT EXISTS alunos (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL

);



CREATE TABLE IF NOT EXISTS cursos (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL

);



CREATE TABLE IF NOT EXISTS aluno_curso (

    aluno_id INT,

    curso_id INT,

    FOREIGN KEY (aluno_id) REFERENCES alunos(id) ON DELETE CASCADE,

    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE

);



INSERT INTO cursos (nome) VALUES

('PHP do Zero ao Hero'),

('Banco de Dados MySQL'),

('HTML5 e CSS3'),

('JavaScript Moderno'),

('Lógica de Programação'); */



//Pega alunos e seus cursos, o GROUP_CONCAT Junta os nomes dos cursos em um texto só
//e se parelos por virgulas

$sql = "SELECT alunos.id, alunos.nome, GROUP_CONCAT(cursos.nome SEPARATOR ', ') as nomes_cursos
        FROM alunos
        INNER JOIN aluno_curso ON alunos.id = aluno_curso.aluno_id
        INNER JOIN cursos ON aluno_curso.curso_id = cursos.id
        GROUP BY alunos.id";
$lista = mysqli_query($conn, $sql);
?>

<h1>Sistema de Alunos e Cursos</h1>

<form action="actions/create.php" method="POST">
    <input type="text" name="nome_aluno" placeholder="Nome do Aluno" required>
    <br><br>
    <strong>Escolha os Cursos:</strong><br>

    <?php while ($c = mysqli_fetch_assoc($query_cursos)): ?>
        <input type="checkbox" name="lista_cursos[]" value="<?= $c['id'] ?>"> <?= $c['nome'] ?> <br>
    <?php endwhile; ?>

    <br>
    <button type="submit">Cadastrar Aluno</button>
</form>

<hr>

<table>
    <tr>
        <th>Aluno</th>
        <th>Cursos</th>
        <th>Ações</th>
    </tr>
    <?php while ($item = mysqli_fetch_assoc($lista)): ?>
        <tr>
            <td><?= $item['nome'] ?></td>
            <td><?= $item['nomes_cursos'] ?? 'Nenhum curso' ?></td>
            <td>
                <a href="editar.php?id=<?= $item['id'] ?>">Editar</a> |
                <a href="actions/delete.php?id=<?= $item['id'] ?>">Excluir</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>