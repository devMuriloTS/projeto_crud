<?php
session_start();
include_once './Config/Config.php';
include_once './Classes/Usuario.php';

//verificar se o usuário está logado
if(!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

$usuario = new Usuario($db);

//obter dados do usuario logado
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_usuario['nome'];
// obter dados dos usuários
$dados = $usuario->ler();
// função para determinar a saudação
function saudacao(){
    $hora = date('H');
    if ($hora >= 6 && $hora < 12) {
        return "Bom dia";
    }else if($hora >= 12 && $hora < 18) {
        return "Boa tarde";
    }else{
        return "Boa noite";
    }
}

// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';
// Obter dados dos usuários com filtros
$dados = $usuario->lerPesquisar($search, $order_by);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="portalstyle.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal</title>
</head>
<body>
    <div class="container">
        <h1> <?php echo saudacao() . ", " . $nome_usuario ?>!</h1>
        <div class="botoes">
        <a href="crudusuario.php"><button class="usuarios">Usuários</button></a>
        <a href="crudnoticias.php"><button class="noticias">Noticias</button></a>
        <a href="logout.php"><button class="logout">Logout</button></a>
        </div>
    </div>

    
</body>
</html>