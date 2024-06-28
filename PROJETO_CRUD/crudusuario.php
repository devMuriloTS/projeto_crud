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

// processar exclusao de usuário
if (isset($_GET['deletar'])){
    $id = $_GET['deletar'];
    $usuario->deletar($id);
    header('Location: portal.php');
    exit();
}

//obter dados do usuario logado
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_usuario['nome'];
// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';
// Obter dados dos usuários com filtros
$dados = $usuario->lerPesquisar($search, $order_by);
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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="crudusuariostyle.css" />
    <title>Crud Usuario</title>
</head>
<body>
    <div class="container">
    <h1> <?php echo saudacao() . ", " . $nome_usuario; ?>!</h1>
    <a href="adicionar.php"><button>Adicionar usuário</button></a>
    <a href="logout.php"><button>Logout</button></a>
    <br> <br>

    <form method="GET">
        <input type="text" name="search" placeholder="Pesquisar por nome ou email" value="<?php echo htmlspecialchars($search); ?>">
        <label>
            <input type="radio" name="order_by" value="" <?php if($order_by == '') echo 'checked'; ?>> ID
        </label>
        <label>
            <input type="radio" name="order_by" value="nome" <?php if($order_by == 'nome') echo 'checked'; ?>> Ordem Alfabetica
        </label>
        <label>
            <input type="radio" name="order_by" value="sexo" <?php if($order_by == 'sexo') echo 'checked'; ?>> Sexo
        </label>
        <button type="submit">Pesquisar</button>
    </form>
    <br>
    <a href="portal.php"><button>Voltar</button></a>
    <br> <br>
        
        

        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Sexo</th>
                <th>Fone</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        <?php foreach ($dados as $row) : ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo ($row['sexo'] === 'M') ? 'Masculino' : 'Feminino'; ?></td>
                <td><?php echo $row['fone']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                <a class="acao" href="editar.php?id=<?php echo $row['id']; ?>">Editar</a>
                <a class="acao" href="crudusuario.php?deletar=<?php echo $row['id']; ?>">Deletar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </table>
    </div>
</body>
</html>