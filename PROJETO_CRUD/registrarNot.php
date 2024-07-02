<?php
session_start();
include_once './Config/Config.php';
include_once './Classes/Noticias.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $n = new Noticias($db);
    $idusu =  $_SESSION['usuario_id'];
    $titulo = $_POST['titulo'];
    $noticia = $_POST['noticia'];
    $data = date('Y-m-d');
  
    $n->registrar($idusu, $data, $titulo, $noticia);
    header('Location: crudnoticias.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="loginstyle.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Notícia</title>
</head>

<body>
    <a href="crudnoticias.php"><button class="voltar">Voltar</button></a>



        <div class="container">
        <div>
            <form method="POST">
            <div>
                <h1>Registre sua Notícia</h1>
                <label for="titulo">Título: </label>
                <input type="text" class="campText" name="titulo" required><br><br>
                <label for="noticia">Notícia: </label>
                <input type="text" class="campText" name="noticia" required><br><br>

                <input class="botao" type="submit" value="Adicionar Notícia">
            </form>
        </div>
    </div>
</body>

</html>