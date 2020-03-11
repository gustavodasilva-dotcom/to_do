<?php

session_start();

$servidor = "localhost";
$usuario = "root";
$senha = "";
$bancodados = "todo_list";

$conec = new mysqli($servidor, $usuario, $senha, $bancodados);

// Default values (valores 'padrões' de nome e atualizar quando não sendo usados)
$nome = ""; $atualizar = false; $id = 0;

if ($conec->connect_error) {
    die("Connection failed: " . $conec->connect_error);
}

if (isset($_POST["adicionar"])) {
    $tarefa = $_POST["tarefa"];

    $conec->query("INSERT INTO todo (t_nome) VALUES ('$tarefa')") or die($conec->error);

    $_SESSION["mensagem"] = "Tarefa adicionada!";
    $_SESSION["tipo_msg"] = "sucesso";

    header("location: index.php"); // ao atualizar, retornando ao 'index'
}

if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $conec->query("DELETE FROM todo WHERE t_id=$id") or die($conec->error());

    $_SESSION["mensagem"] = "Tarefa excluída!";
    $_SESSION["tipo_msg"] = "excluida"; // ao excluir, retornando ao 'index'

    header("location: index.php"); // ao atualizar, retornando ao 'index'
}

if (isset($_GET["edit"])) {
    $id = $_GET["edit"];
    $atualizar = true;
    $resultado = $conec->query("SELECT * FROM todo WHERE t_id=$id") or die($conec->error());

    $row = $resultado->fetch_array();
    $nome = $row["t_nome"];
}

if (isset($_POST["atualizar"])) {
    $id = $_POST["id"];
    $nome = $_POST["tarefa"];

    $conec->query("UPDATE todo SET t_nome='$nome' WHERE t_id=$id") or die($conec->error);

    $_SESSION["mensagem"] = "Tarefa atualizada!";
    $_SESSION["tipo_msg"] = "sucesso";

    header("location: index.php");
}

$conec->close(); // encerrar conecção ao final