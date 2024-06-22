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
    header('Location: portal.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Usuário</title>
</head>

<body>
    <h1> Adicionar Usuário</h1>
    <form method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" placeholder="Nome" required>
        <br><br> <label>Sexo: </label>
        <label for="masculino">
            <input type="radio" id="masculino" name="sexo" value="M" required> Masculino
        </label>
        <label for="feminino">
            <input type="radio" id="feminino" name="sexo" value="F" required> Feminino
        </label>
        <br> <br>

        <label for="fone">Fone:</label>
        <input type="text" name="fone" placeholder="Fone" required> 
        <br> <br>

        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Email" required> 
        <br> <br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" placeholder="Senha" required>
        <br> <br>

        <input type="submit" value="Adicionar">
    </form>
</body>

</html>