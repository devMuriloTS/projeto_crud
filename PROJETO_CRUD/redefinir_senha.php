<?php
include_once './Config/Config.php';
include_once './Classes/Usuario.php';

$mensagem = '';

if($_SERVER['REQUEST_METHOD'] === "POST") {
    $codigo = $_POST['codigo'];
    $nova_senha = $_POST['nova_senha'];
    $usuario = new Usuario($db);

    if($usuario->redefinirSenha($codigo, $nova_senha)){
        $mensagem = "Senha redefinida com sucesso. Você pode <a href='login.php'>Entrar</a> agora.";
    } else {
        $mensagem = "Código de verificação inválido.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="loginstyle.css" /> 
    <title>Redefinir Senha</title>
</head>
<body>
    <div class="container">
        <h1>Redefinir senha</h1>
        <form method="POST">
            <label for="codigo">Código de verificação:</label>
            <input type="text" name="codigo" placeholder="Seu código aqui" required><br><br>
            <label for="nova_senha">Nova senha:</label>
            <input type="password" name="nova_senha"required><br><br>
            <input type="submit" value="Redefinir senha">
            <div class="mensagem">
            <h2><?php echo $mensagem; ?></h2>
        </div>
        </form>
        
    </div>

</body>
</html>