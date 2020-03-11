<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Tarefas pendentes</title>
</head>
<body>
    <div class="main">
        <?php require_once "db_process.php"; ?>
        
        <?php if (isset($_SESSION["mensagem"])) { ?>
            <div class="mensagem_<?= $_SESSION["tipo_msg"] ?>">
                <?php
                    echo $_SESSION["mensagem"];
                    unset($_SESSION["mensagem"]);
                ?>
            </div><!--mensagem_sucesso ou excluida-->
        <?php }; ?>

        <?php
            $servidor = "localhost"; $usuario = "root"; $senha = ""; $bancodados = "todo_list";
            $conec = new mysqli($servidor, $usuario, $senha, $bancodados) or die(mysqli_error($conec));
            $resultado = $conec->query("SELECT * FROM todo") or die($conec->error);
        ?>
        
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $id ?>">

            <div class="input_field">
                <input type="text" name="tarefa" id="tarefa" value="<?php echo $nome; ?>" placeholder="coloque a tarefa">
            </div><!--input_field-->

            <div class="input_field">
                <?php
                    if ($atualizar == true) {
                ?>
                    <input type="submit" name="atualizar" value="Atualizar tarefa">
                <?php
                    } else {
                ?>
                    <input type="submit" name="adicionar" value="Adicionar nova tarefa">
                <?php
                    }
                ?>
            </div><!--input_field-->

        </form>

        <div class="tabela-resultado">
            <table class="conteudo-tabela">

                <thead>
                    <tr>
                        <th>Tarefa</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>

                <?php while ($row = $resultado->fetch_assoc()) { ?>
                    <tbody>
                        <tr>
                            <td><?php echo $row["t_nome"]; ?></td>
                            <td>
                                <a href="index.php?edit=<?php echo $row["t_id"]; ?>" class="editar">Editar</a>
                            </td>
                            <td>
                                <a href="db_process.php?delete=<?php echo $row["t_id"]; ?>" class="excluir">Excluir</a>
                            </td>
                        </tr>
                    </tbody>
                <?php }; ?>

            </table>
        </div><!--tabela-resultado-->

    </div><!--main-->
</body>
</html>