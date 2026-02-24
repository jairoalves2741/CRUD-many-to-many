<?php
require 'config/database.php';

// 1. Pega todos os cursos para mostrar no formulário
$cursos = $pdo->query("SELECT * FROM cursos")->fetchAll(PDO::FETCH_ASSOC);

// 2. Pega todos os alunos e seus cursos (usando um JOIN)
$sql = "SELECT alunos.id, alunos.nome, GROUP_CONCAT(cursos.nome) as nomes_cursos
        FROM alunos
        LEFT JOIN aluno_curso ON alunos.id = aluno_curso.aluno_id
        LEFT JOIN cursos ON aluno_curso.curso_id = cursos.id
        GROUP BY alunos.id";
$lista = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Sistema de Alunos e Cursos</h1>

<form action="actions/create.php" method="POST">
    <input type="text" name="nome_aluno" placeholder="Nome do Aluno" required>
    <br><br>
    <strong>Escolha os Cursos:</strong><br>

    <?php foreach ($cursos as $c): ?>
        <input type="checkbox" name="meus_cursos[]" value="<?= $c['id'] ?>"> <?= $c['nome'] ?> <br>

    <?php endforeach; ?>

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
    <?php foreach ($lista as $item): ?>
        <tr>
            <td><?= $item['nome'] ?></td>
            <td><?= $item['nomes_cursos'] ?></td>
            <td>
                <a href="editar.php?id=<?= $item['id'] ?>">Editar</a> |
                <a href="actions/delete.php?id=<?= $item['id'] ?>">Excluir</a>
            </td>
        </tr>

    <?php endforeach; ?>

</table>


// LINHA DE CODIGO PARA O BANCO DE DADOS

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