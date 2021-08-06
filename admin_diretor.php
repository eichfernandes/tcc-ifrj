<?php session_start();
    if(!isset($_SESSION['adm'])){
        header('Location: index.php');
        exit();
    }else{
        if($_SESSION['adm']!=1){
            header('Location: index.php');
            exit();
        };
    };
    if (empty($_GET['id'])){header('Location: index.php'); exit();};
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
        <div style="min-height: 100vh;"><!-- Esta div está relacionada a tela e ajuda a ajustar as restantes -->
        
        <!-- Cabeçalho -->
        <?php include "header.php" ?> <!-- Cabeçalho da Página -->
        
        <!-- Conteúdo -->
        <div style="display: flex; justify-content: space-between; align-items: center; height: 100%;">
            <div class="content" style="width: 40%;"><!-- Define o que estará no conteúdo central -->
                <div class="block"><!-- Cada div block é um bloco de conteúdo -->
                    
                    <!-- PUXANDO DADOS -->
                    <?php include "conexao.php";
                        $idir=$_GET['id'];
                        $query = "select nome,foto from diretores where id_diretor='".$idir."'";
                        $result = mysqli_query($mysqli, $query);
                        $row = mysqli_fetch_assoc($result);
                        $foto = $row['foto'];
                        $nome = $row['nome'];
                    ?>
                    
                    <!-- INFORMAÇÕES DO DIRETOR -->
                    <?php if(!empty($foto)){ ?>
                    <img style="padding: 0px 0px" src="<?php echo $foto; ?>" width="100%"><br><br>
                    <?php }; ?>
                    <div style="padding: 0px 11px; font-size: 14px;">
                        Diretor:<div style="text-align: right; float: right;">ID:</div>
                    </div>
                    <div style="padding: 0px 11px 0px; font-size: 25px;">
                        <?php echo $nome; ?>
                        <div style="text-align: right; float: right;">
                            [ <?php echo $idir; ?> ]
                        </div>
                    </div>

                    
                    
                    
                    <!-- LISTA DE FILMES -->
                    <?php    
                        $query = "select filmes.titulo as 'titulo', filmes.ano as 'ano', filmes.id_filme as 'id' "
                                . "from filmes, direcao where filmes.id_filme=direcao.id_filme and direcao.id_diretor=".$idir." "
                                . "group by filmes.id_filme";
                        
                        $result = mysqli_query($mysqli, $query);
                        $valid = mysqli_num_rows($result);
                        
                        /* VALIDANDO FILMES */
                        if($valid==0){echo '<div style="margin: 20px 0px 0px;text-align:center;font-size: 23px;">---------------------------------<br>'
                            . 'Nenhum Filme Encontrado<br>---------------------------------</div>';}
                        else{ ?>
                            <div style="padding: 0px 11px 0px; font-size: 14px;"><br>
                                Filmes:<br>
                            </div>
                            <div style="padding: 0px 11px 0px; font-size: 18px;">
                                Título - ( Ano )<div style="text-align: right; float: right;"> Nota - [ ID ]</div>
                            </div>
                        <?php };
                        
                        /* LISTANDO FILMES */
                        if ($result){
                            while ($row = mysqli_fetch_assoc($result)){
                                $titulo=$row['titulo'];
                                $ano=$row['ano'];
                                $id=$row['id'];
                                
                                
                                $result2 = mysqli_query($mysqli, 'select avg(nota) as "nota" from notas where id_filme='.$id);
                                $row2 = mysqli_fetch_assoc($result2);
                                $nota=number_format($row2['nota'], 1, '.');
                                
                                echo '<div class="listclick">'.
                                    $titulo.' - ('.$ano.')<div style="float: right;">'
                                        .$nota.' ★ - [ '.$id.' ]</div>'
                                .'</div>';
                            };
                        };
                        mysqli_free_result($result);
                    ?>
                    
                    <!-- ADICIONAR FILMES -->
                    <div  style="font-size: 20px; margin: 20px 12px; text-align: center;">
                        <form method="post" action="adicionar_filme.php">
                            <h2>Adicionar Filme</h2>
                            Título: <input name="titulo" type="text" class="searchbar" maxlength="100" size="30"
                                style="margin: 10px 0px 0px;" placeholder="Título em Inglês ou Mais Famoso"><br>

                            AKA: <input name="aka" type="text" class="searchbar" maxlength="100" size="30"
                                style="margin: 10px 0px 0px;" placeholder="Título em Português se Existir"><br>

                            Lançamento: <input name="ano" type="number" class="searchbar" min="1850" max="3000" size="4"
                                style="margin: 10px 0px 0px;" placeholder="(Ano)"><br>
                            
                            <input name="idir" type="hidden" value="<?php echo $idir; ?>">
                            <input type="submit" class="but" value="Adicionar"  style="text-align: center;font-size: 16px; margin-top: 10px;"/>
                        </form>
                        
                    </div>
                    
                </div>
            </div>
        </div>
        
        <!-- Rodapé -->
        <?php include "footer.php" ?> <!-- Rodapé da Página -->
        
        </div>
    </body>
</html>
