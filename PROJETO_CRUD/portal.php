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
        return "Bom dia!";
    }else if($hora >= 12 && $hora < 18) {
        return "Boa tarde!";
    }else{
        return "Boa noite!";
    }
}

// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';
// Obter dados dos usuários com filtros
$dados = $usuario->ler($search, $order_by);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal</title>
</head>
<body>
    <h1> <?php echo saudacao() . ", " . $nome_usuario ?>!</h1>
    <a href="logout.php"><button>Logout</button></a>
    <br>

    <form method="GET">
        <input type="text" name="search" placeholder="Pesquisar por nome ou email" value="<?php echo htmlspecialchars($search); ?>">
        <label>
            <input type="radio" name="order_by" value="" <?php if($order_by == '') echo 'checked'; ?>> Normal
        </label>
        <label>
            <input type="radio" name="order_bu" value="nome" <?php if($order_by == 'nome') echo 'checked'; ?>> Ordem Alfabetica
        </label>
        <label>
            <input type="radio" name="order_by" value="sexo" <?php if($order_by == 'sexo') echo 'checked'; ?>> Sexo
        </label>
        <button type="submit">Pesquisar</button>
        </form>
        

    </form>

    <br>

    <a href="crudusuario.php"><button>Usuários</button></a>
    <a href="crudnoticias.php"><button>Noticias</button></a>

    
</body>
</html>