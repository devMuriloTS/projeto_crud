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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal</title>
</head>
<body>
    <h1> <?php echo saudacao() . ", " . $nome_usuario; ?>!</h1>
    <a href="registrar.php">Adicionar usuário</a>
    <a href="logout.php">Logout</a>
    <br>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Sexo</th>
            <th>Fone</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo ($row['sexo'] === 'M') ? 'Mascculino' : 'Feminino'; ?></td>
                <td><?php echo $row['fone']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <a href="editar.php?id=<?php echo $row['id'];?>">Editar</a>
                    <a href="deletar.php?id=<?php echo $row['id'];?>">Deletar</a>
                </td>
            </tr>
        <?php  endwhile; ?>
    </table>
</body>
</html>