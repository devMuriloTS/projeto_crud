<?php
    session_start();
    include_once './Config/Config.php';
    include_once './Classes/Usuario.php';

    $usuario = new Usuario($db);

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['login'])){
            // Processar login
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            if($dados_usuario = $usuario->login($email, $senha)){
                $_SESSION['usuario_id'] = $dados_usuario['id'];
                header('location:portal.php');
                exit();
            }else{
                $mensagem_erro = "Credenciais inválidas!";
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styleCRUD.css" />
    <title>Autenticação</title>
</head>
<body>
    <div class="container">
        <form method="POST">
            <label for="email">Email:</label>
            <input type="email" placeholder="Email" name="email" required>
            <br> <br>
            <label for="senha">Senha:</label>
            <input type="password" placeholder="Senha" name="senha" required>
            <br> <br><br>

            <input type="submit" value="Login" name="login">
            <br>
            <a href="./registrar.php"><p>Registrar-se</p></a>
            <a href="./repass.php"><p>Recuperar senha</p></a>
        </form>

        <div class="mensagem">
            <?php
                if(isset($mensagem_erro)){
                    echo'<p> ' . $mensagem_erro . '</p>';
                }
            ?>
        </div>
    </div>

    <footer>
        
    </footer>
    
</body>
</html>