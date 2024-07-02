<?php
include_once './Config/Config.php';
include_once './Classes/Usuario.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $usuario = new Usuario($db);
    $codigo = $usuario->gerarCodigoVerificacao($email);

    if($codigo){
        $mensagem = "Seu código de verificação é: $codigo. Por favor, anote o código e <a href='redefinir_senha.php'>Clique aqui</a> para redefinir sua senha.";
    } else {
        $mensagem = 'E-mail não encontrado.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="loginstyle.css" />
    <title>Recuperar Senha</title>
</head>
<body>
<a href="index.php"><button>Voltar</button></a>
    <div class="container">
        <form method="POST">
            <label for="email">Email</label>
            <input type="email" name="email" required><br><br>
            <input type="submit" value="Enviar">
            <h2><?php echo $mensagem; ?></h2>
        </form>


    </div>

    
</body>
</html>