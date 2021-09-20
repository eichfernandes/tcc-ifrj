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
                <li><a class="link" href="diretores.php">Diretores</a></li>
            </ul>
            <div class="title"><a class="link" href="index.php">Me Indica - Avaliação de Filmes</a></div>
            <div>
                <?php if(!isset($_SESSION['usuario'])){ ?>
                <ul>
                    <li><a class="link" href="register.php">Criar Conta</a></li>
                    <li><a class="but" href="login.php">Logar</a></li>
                </ul>
                <?php }else{ ?>
                <ul>
                    <li><a class="link" href="amigos.php?p=seguindo">Perfis</a></li> |
                    <li><a class="link" href="usuario.php?u=<?php echo $_SESSION['usuario'];
                        ?>"><?php echo $_SESSION['usuario']; ?></a></li>
                    <li><a class="but" href="logout.php">Sair</a></li>
                </ul>
                <?php }; ?>
            </div>
        </header>
    </body>
</html>
