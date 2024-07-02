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
                header('Location: portal.php');
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
    <link rel="stylesheet" type="text/css" href="loginstyle.css" />
    <title>Autenticação</title>
</head>
<body>
    <div class="container">
        <form method="POST">
        <p> Autenticação </p>
            <div class="form">
	            <div class="input-container">
		        <input type="email" name="email" required/>
		        <label>Email</label>		
	            </div>
	            <div class="input-container">		
		        <input type="password" name="senha" class="password-input" required/>
		        <label>Senha</label>
	        </div>

            <button type="submit" name="login" id="logar">Login</button>
            </div>

        </form>
        <a href="./registrar.php"><button>Registrar-se</button></a>
        <a href="./solicitar_recuperacao.php"><button>Recuperar senha</button></a>

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