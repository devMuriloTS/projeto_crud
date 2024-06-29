<?php 
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit();
    }

    include_once './Config/Config.php';
    include_once './Classes/Noticias.php';

    $noticia = new Noticias($db);
    if(isset($_GET['idnot'])){
        $idnot = $_GET['idnot'];
        $noticia->deletarNot($idnot);
        header('Location: crudnoticias.php');
        exit();
    }
?>