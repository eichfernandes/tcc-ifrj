<?php include 'conexao.php';
session_set_cookie_params(3600*24*7);
session_start();
$user = $_GET['u'];

$query = "select * from usuarios where id_usuario='$user' or usuario='$user'";
$result = mysqli_query($mysqli, $query);
$valid = mysqli_num_rows($result);

if($valid!=1){
    header('Location: index.php');
    exit();
};

$row = mysqli_fetch_assoc($result);


$id = $row['id_usuario'];
$usuario = $row['usuario'];
$nome = $row['nome'];
$sobrenome = $row['sobrenome'];




?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Me Indica - <?php echo $row['usuario']; ?></title>
        <link href="style.css" rel="stylesheet">
        <link rel="shortcut icon" href="icone.png" type="image/x-png">
    </head>
    <body>
        <div class="semibody"><!-- Esta div está relacionada a tela e ajuda a ajustar as restantes -->
        
        <!-- Cabeçalho -->
        <?php include "header.php" ?> <!-- Cabeçalho da Página -->
        
        <!-- Conteúdo -->
        <div style="display: flex; justify-content: space-between; align-items: center; height: 100%;">
            <div class="content"><!-- Define o que estará no conteúdo central -->
                <div class="block"><!-- Cada div block é um bloco de conteúdo -->
                    <h1><?php echo $row['usuario']; ?></h1>
                    <h2 style="opacity: 60%;"><?php echo "'".$nome.' '.$sobrenome."'"; ?></h2>
                </div>
            </div>
        </div>
        <!-- Rodapé -->
        <?php include "footer.php" ?> <!-- Rodapé da Página -->
        
        </div>
    </body>
</html>

