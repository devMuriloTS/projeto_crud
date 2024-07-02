<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: crudnoticias.php');
    exit();
}

include_once './Config/Config.php';
include_once './Classes/Noticias.php';

$n = new Noticias($db);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idnot = $_POST['idnot'];
    $titulo = $_POST['titulo'];
    $noticia = $_POST['noticia'];
    $n->atualizarNot($idnot, $titulo, $noticia);
    header('Location: crudnoticias.php');
    exit();
}

if (isset($_GET['idnot'])) {
    $id = $_GET['idnot'];
    $row = $n->lerPorId($id);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="loginstyle.css" />
    <title>Editar Notícia</title>
</head>

<body>
    <div class="container">
        <form method="POST">
        <h1>Edite sua Notícia</h1>
            <input type="hidden" name="idnot" value="<?php echo $row['idnot']; ?>">
            <label for="titulo">Título: </label>
            <input type="text" name="titulo" value="<?php echo $row['titulo'] ?>" required><br><br>
            <label for="noticia">Notícia: </label>
            <input type="text" name="noticia" value="<?php echo $row['noticia'] ?>" required><br><br>

            <input type="submit" value="atualizar">
        </form>
    </div>
</body>

</html>