<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
include_once './Config/Config.php';
include_once './Classes/Usuario.php';
include_once './Classes/Noticias.php';

//Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$n = new Noticias($db);

//Processar exlusão da notícia
if (isset($_GET['deletarNot'])) {
    $idnot = $_GET['deletarNot'];
    $noticias->deletarNot($idnot);
    header('Location: crudnoticias.php');
    exit();
}

// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';

// Obter dados das noticias com filtros
$dados = $n->ler($search, $order_by);

//Obter dados das noticias
//$dados = $noticias->ler($search, $order_by);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="crudNoticias.css">
    <title>crudNotícias</title>
</head>

<body>

    <a href="login.php"><button class="botao">Logout</button></a>
    <a href="portal.php"><button class="botao">Voltar ao Portal</button></a>

    <div class="box">
        <div class="titulo">
            <h1>Portal de Notícias.</h1>
        </div>

        <form method="GET">
            <input type="text" name="search" placeholder="Pesquisar por nome ou título"
                value="<?php echo htmlspecialchars($search); ?>">
            <label>
                <input type="radio" name="order_by" value="" <?php if ($order_by == '')
                    echo 'checked'; ?>> Normal
            </label>
            <label>
                <input type="radio" name="order_by" value="nome" <?php if ($order_by == 'titulo')
                    echo 'checked'; ?>>
                Ordem Alfabética
            </label>
            <label>
                <input type="radio" name="order_by" value="sexo" <?php if ($order_by == 'data')
                    echo 'checked'; ?>>
                Por data
            </label>
            <button type="submit" class="botaoPesq">Pesquisar</button>
        </form>

        <table border="1">
            <tr>
                <th>Usuário</th>
                <th>Título</th>
                <th>Notícias</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo $row['usuario'] ?></td>
                    <td><?php echo $row['titulo'] ?></td>
                    <td><?php echo $row['noticia'] ?></td>
                    <td><?php echo $row['data'] ?></td>
                    <td class="acoes">
                       <a href="editarNot.php?idnot=<?php echo $row['idnot']; ?>">Editar</a>

                        <a href="deletarNot.php?idnot=<?php echo $row['idnot']; ?>">Deletar</a>

                    </td>
                </tr>

            <?php endwhile ?>
        </table>

        <a href="registrarNot.php"><button class="botao">Registre sua Notícia</button></a>

    </div>

</body>

</html>