<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
include_once './Config/Config.php';
include_once './Classes/Usuario.php';

$usuario = new Usuario($db);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $usuario->atualizar($id, $nome, $sexo, $email, $fone);
    header('Location: crudusuario.php');
    exit();
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $row = $usuario->lerPorId($id);
    if (!$row) {
        $mensagem_erro = 'Usuário não encontrado.';
    }
} else {
    $mensagem_erro = 'ID não fornecido.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="loginstyle.css" />
    <title>Editar Usuário</title>
</head>
<body>

    <form method="POST">
        <h1>Editar Usuário</h1>
        <?php if (isset($row)): ?>
            <input type="hidden" name="id" value="<?php echo $row['id']?>">

            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="<?php echo $row['nome']; ?>" required>
            <br> <br>
            <div>
                <label>Sexo:</label>
                <label for="feminino_editar"> 
                    <input type="radio" id="feminino_editar" name="sexo" value="M" <?php echo ($row['sexo'] === 'M') ? 'checked' : ''; ?> required>
                    <span>Masculino</span>
                </label>
                <br><br>

                <label for="masculino_editar">
                    <input type="radio" id="masculino_editar" name="sexo" value="F" <?php echo ($row['sexo'] === 'F') ? 'checked' : ''; ?> required>
                    <span>Feminino</span>
                </label>
            </div>

            <label for="fone">Fone:</label>
            <input required class="form-control" name="fone" id="fone" type="text" maxlength="15" placeholder="(00) 00000-0000" value="<?php echo $row['fone']; ?>"> 
            <br> <br>

            <label for="email">E-mail:</label>
            <input required class="form-control" name="email" id="email" type="email" value="<?php echo $row['email']; ?>">

            <input type="submit" value="Atualizar">
        <?php else: ?>
            <p>Usuário não encontrado ou ID não fornecido.</p>
        <?php endif; ?>
    </form>
    <a href="crudusuario.php"><button>Voltar</button></a>
    <?php if (isset($mensagem_erro)) {
        echo '<br><p><strong>' . $mensagem_erro . '</strong><p>';
    }
    ?>
    
</body>
</html>
