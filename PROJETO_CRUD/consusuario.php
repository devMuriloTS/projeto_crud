<?php
session_start();
include_once './Config/Config.php';
include_once './Classes/Usuario.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$usuario = new Usuario($db);

if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];
    // Verifica se o usuário tem permissão para deletar o usuário
    if ($id == $_SESSION['usuario_id']) {
        $usuario->deletar($id);
        session_destroy(); // Destroi a sessão após deletar o usuário
        header('Location: login.php');
        exit();
    } else {
        echo 'Você não tem permissão para deletar este usuário.';
        exit();
    }
}

$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
if (!$dados_usuario) {
    echo 'Usuário não encontrado.';
    exit();
}

$nome_usuario = $dados_usuario['nome'];
$fone_usuario = $dados_usuario['fone'];
$email_usuario = $dados_usuario['email'];
$senha_usuario = $dados_usuario['senha'];

$sexo = ($dados_usuario['sexo'] == 'F') ? 'Feminino' : 'Masculino';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="loginstyle.css" />
    <title>Editar perfil</title>
</head>
<body>
    <div class="container">
        <a href="portal.php"><button>Voltar</button></a>
        <form method="POST">
            <label>Nome:</label>
            <label><?php echo htmlspecialchars($nome_usuario, ENT_QUOTES, 'UTF-8'); ?></label>
            <br><br>
            <label>Sexo:</label>
            <label><?php echo htmlspecialchars($sexo, ENT_QUOTES, 'UTF-8'); ?></label>
            <br><br>
            <label>Fone:</label>
            <label><?php echo htmlspecialchars($fone_usuario, ENT_QUOTES, 'UTF-8'); ?></label>
            <br><br>
            <label>E-mail:</label>
            <label><?php echo htmlspecialchars($email_usuario, ENT_QUOTES, 'UTF-8'); ?></label>
        </form>
        <a href="editar.php"><button>Editar</button></a>
    </div>
</body>
</html>
