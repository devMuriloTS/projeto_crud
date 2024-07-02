<?php
session_start();
include_once './Config/Config.php';
include_once './Classes/Usuario.php';
include_once './Classes/Noticias.php';

$usuario = new Usuario($db);
$noticia = new Noticias($db);

if(isset($_SESSION['usuario_id'])){
    $dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
    $nome_usuario = $dados_usuario['nome'];
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['$order_by']) ? $_GET['$order_by'] : '';

$dados_noticia = $noticia->ler($search, $order_by);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="indexstyle.css" />
    <title>Index</title>
</head>
<body>
    <div class="container">

        <a href="login.php"><button>Login</button></a>

        <form method="GET">
            <input type="text" name="search" placeholder="Pesquisar por nome ou título"
                value="<?php echo htmlspecialchars($search); ?>">
            <label><br><br>
                <input type="radio" name="order_by" value="" <?php if ($order_by == '')
                    echo 'checked'; ?>> Normal
            </label><br><br>
            <label>
                <input type="radio" name="order_by" value="nome" <?php if ($order_by == 'titulo')
                    echo 'checked'; ?>>
                Ordem Alfabética
            </label><br><br>
            <label>
                <input type="radio" name="order_by" value="sexo" <?php if ($order_by == 'data')
                    echo 'checked'; ?>>
                Por data
            </label><br><br>
            <button type="submit">Pesquisar</button>
        </form>
        <br><br>

        <?php while($row = $dados_noticia->fetch(PDO::FETCH_ASSOC)) : ?>
            <table>
                <thread>
                    <tr>
                        <th><?php echo $row['idnot']; ?></th>
                        <th><?php echo $row['data']; ?></th>
                        <th>Postado por: <?php echo $row['usuario']; ?></th>
                    </tr>
                </thread>
            </table>
            <table>
                <tbody>
                    <tr>
                        <td style="text-align:  center;"><?php echo $row['titulo']; ?></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $row['noticia']; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php endwhile; ?>

    </div>
    
</body>
</html>