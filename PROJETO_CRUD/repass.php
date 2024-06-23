<?php
session_start();
include_once './Config/Config.php';
include_once './Classes/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $email = $_POST['email'];
    $usuario = new Usuario($db);
    $dados_usuario = $usuario->buscarPorEmail($email);

    if ($dados_usuario) {
        $token = bin2hex(random_bytes(50)); // gera um token de 100 caracteres

        // definir a data de expiração
        $expire_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // salvar o token no banco de dados junto com o email e a data de expiração
        $sql = "INSERT INTO reset_password (email, token, expire_at) VALUES (:email, :token, :expire_at)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expire_at', $expire_at);
        $stmt->execute();

        $envio_email = enviarEmailRecuperacaoSenha($email, $token);

        // mostra pro usuário se enviou
        if ($envio_email) {
            $_SESSION['success_message'] = "Um email foi enviado para você com instruções para redefinir sua senha.";
        } else {
            $_SESSION['error_message'] = "Houve um problema ao enviar o email. Por favor, tente novamente mais tarde.";
        }
        exit();
    } else {
        $_SESSION['error_message'] = "Email não encontrado. Verifique se o email está correto.";
        exit();
    }
}

function enviarEmailRecuperacaoSenha($email, $token) {
    $assunto = 'Recuperação de Senha';
    $mensagem = 'Olá! Para redefinir sua senha, clique no link abaixo:';
    $mensagem .= "\n\n";
    $mensagem .= '' . urlencode($token); // aqui no caso eu preciso colocar o url do site para que seja redirecionado

    // cabeçalho
    $headers = 'From: murilo271231@gmail.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    // envia
    return mail($email, $assunto, $mensagem, $headers);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar senha</title>
</head>
<body>
    <form method="POST">
        <label for="email">Digite seu email:</label>
        <input type="email" id="email" name="email" required>

        <button type="submit" name="submit">Enviar</button>
    </form>
</body>
</html>