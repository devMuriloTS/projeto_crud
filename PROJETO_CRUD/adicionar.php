<?php
include_once './Config/Config.php';
include_once './Classes/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario($db);
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $usuario->criar($nome, $sexo, $fone, $email, $senha);
    header('Location: crudusuario.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="loginstyle.css" />
    <title>Adicionar Usuário</title>
</head>

<body>
    <div class="container">
    <form method="POST" class="registro">
        <p> Adicionar </p>
        <div class="input-container">
        <input type="text" name="nome" required>
        <label for="nome">Nome</label>
        </div>
        <div class="sexo">
        <div class="input-container">  
        <input type="radio" id="masculino" name="sexo" value="M" required> 
        <p for="masculino">
            Masculino
        </p>
        </div>
        <div class="input-container">
            <input type="radio" id="feminino" name="sexo" value="F" required> 
        <p for="feminino">
            Feminino
        </p>
        </div>
        </div>

        <div class="input-container">
        <input type="text" name="fone" required maxlength="15"> 
        <label for="fone">Fone</label>
        </div>
        <br> <br>

        <div class="input-container">
        <input type="email" name="email" required> 
        <label for="email">Email</label>
        </div>
        <br> <br>

        <div class="input-container">
        <input type="password" name="senha" required>
        <label for="senha">Senha</label>
        </div>
        <br> <br>

        <button type="submit">Adicionar</button>
    </form>
    <a class="voltar" href="./crudusuario.php"><button class="voltarbt">Voltar</button></a>
    </div>
</body>

</html>