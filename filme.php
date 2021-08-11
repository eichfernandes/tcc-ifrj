<?php 
session_set_cookie_params(3600*24*7);
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TCC - Avaliação de Filmes</title>
        <link href="style.css" rel="stylesheet">
        <link rel="shortcut icon" href="icone.png" type="image/x-png">
    </head>
    <body>
        <div class="semibody"><!-- Esta div está relacionada a tela e ajuda a ajustar as restantes -->
        
        <!-- Cabeçalho -->
        <?php include "header.php" ?> <!-- Cabeçalho da Página -->
        
        <!-- Conteúdo -->
        <div style="display: flex; justify-content: space-between; align-items: center; height: 100%;">
            <div class="content" style="width: 900px;"><!-- Define o que estará no conteúdo central -->
                <div class="block"><!-- Cada div block é um bloco de conteúdo -->
                    <div style="display: flex; height: 300px;">
                        <div>
                            <img src="https://br.web.img3.acsta.net/pictures/21/03/16/14/31/0831115.jpg" height="300"
                                style="border-radius: 5px;">
                        </div>
                        <div style="margin: 0px 0px 0px 22px" class="blockin">
                            <h1 style="display: inline-block; padding: 0px 0px;">Another Round</h1>
                            <p style="opacity: 75%; display: inline-block"> (2020)</p>
                            <p style="opacity: 50%">
                                'Druk'</p>
                            <p style="margin-top: 20px;"><text style="opacity: 75%">Direção: </text>
                                <a class="tag" href="#">Thomas Vinterberg</a>
                            <p style="margin-top: 20px;">Tags: 
                                <a href="#" class="tag">Comédia</a> <a href="#" class="tag">Drama</a><br><br></p>
                            <h2 style="margin-top: 5px">Nota: 4.7★</h2>
                            <p style="margin-top: 20px"><text style="font-size: 25px;">Sua Nota: <text style="font-size: 27px;">
                                ★★★★★</text></text><text style="font-size: 12px;"> remover nota</text></p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- Rodapé -->
        <?php include "footer.php" ?> <!-- Rodapé da Página -->
        
        </div>
    </body>
</html>
