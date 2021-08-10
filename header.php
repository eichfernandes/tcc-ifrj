<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>header</title>
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
        <header>
            <ul>
                <li><a class="link" href="index.php">Início</a></li> |
                <?php if(!isset($_SESSION['usuario'])){ ?>
                    <li><a class="link" href="diretores.php">Diretores</a></li>
                <?php }else{if($_SESSION['adm']==1){ ?>
                    <li><a class="link" href="admin_diretores.php">Diretores</a></li>
                <?php };}; ?>
            </ul>
            <div class="title">Me Indica - Avaliação de Filmes</div>
            <div>
                <?php if(!isset($_SESSION['usuario'])){ ?>
                <ul>
                    <li><a class="link" href="register.php">Criar Conta</a></li>
                    <li><a class="but" href="login.php">Logar</a></li>
                </ul>
                <?php }else{ ?>
                <ul>
                    <li><a class="link" href="#">Amigos</a></li> |
                    <li><a class="link" href="#"><?php echo $_SESSION['usuario']; ?></a></li>
                    <li><a class="but" href="logout.php">Sair</a></li>
                </ul>
                <?php }; ?>
            </div>
        </header>
    </body>
</html>
