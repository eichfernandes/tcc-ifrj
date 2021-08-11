<?php session_start();
if (empty($_GET['id'])){header('Location: diretores.php');}
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
            <div class="content" style="width: 780px;"><!-- Define o que estará no conteúdo central -->
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
                    <img style="padding: 0px 0px; display: block; margin: auto; border-radius: 20px;" src="<?php echo $foto; ?>" height="300px"><br><br>
                    <?php }; ?>
                    <div style="padding: 0px 11px; font-size: 14px;">
                        Diretor:
                    </div>
                    <div style="padding: 0px 11px 20px; font-size: 25px;">
                        <?php echo $nome; ?>
                    </div>

                    <form method="post" action="diretor_pesquisa.php">
                        <input class="searchbar" size="25" name="pesquisa" placeholder="Pesquisar"
                               value="<?php if(!empty($_SESSION['pesquisadirfil'])){echo $_SESSION['pesquisadirfil'];}; ?>">
                        <select name="ordem" style="float: right; padding: 7px 9px;" class="order" onchange="this.form.submit()">
                            <option <?php if(!empty($_SESSION['ordemdirfil'])&&$_SESSION['ordemdirfil']=='filmes.aka'){echo "selected";}?>
                                value="filmes.aka">Titulo ↓</option>
                            <option <?php if(!empty($_SESSION['ordemdirfil'])&&$_SESSION['ordemdirfil']=='filmes.aka desc'){echo "selected";}?>
                                value="filmes.aka desc">Titulo ↑</option>
                        </select>
                    </form>
                    
                    <!-- LISTA DE FILMES -->
                    <?php
                        
                        if(!empty($_SESSION['pesquisadirfil'])){
                            $pesq = mysqli_real_escape_string($mysqli,$_SESSION['pesquisadirfil']);
                            $pesquisa="and (filmes.titulo like '%".$pesq."%' or filmes.aka like '%".$pesq."%') ";
                        }else{$pesquisa="";};
                        
                        unset($_SESSION['pesquisadirfil']);
                        
                        if(isset($_SESSION['ordemdirfil'])){
                            $order = " order by " . $_SESSION['ordemdirfil'];
                        }else{$order = " order by filmes.id_filme"; };
                    
                        $query = "select filmes.titulo as 'titulo', filmes.aka as 'aka', filmes.ano as 'ano', filmes.id_filme as 'id' "
                                . "from filmes, direcao where filmes.id_filme=direcao.id_filme and direcao.id_diretor=".$idir." ".$pesquisa
                                . "group by filmes.id_filme" . $order;
                        
                        $result = mysqli_query($mysqli, $query);
                        $valid = mysqli_num_rows($result);
                        
                        /* VALIDANDO FILMES */
                        if($valid==0){echo '<div style="margin: 20px 0px 0px;text-align:center;font-size: 23px;">---------------------------------<br>'
                            . 'Nenhum Filme Encontrado<br>---------------------------------</div>';}
                        else{ ?>
                            <div style="padding: 0px 11px 0px; font-size: 14px;">
                                Filmes:<br>
                            </div>
                            <div style="padding: 0px 11px 0px; font-size: 18px;">
                                Título - ( Ano )<div style="text-align: right; float: right;"> Nota</div>
                            </div>
                        <?php };
                        
                        /* LISTANDO FILMES */
                        if ($result){
                            while ($row = mysqli_fetch_assoc($result)){
                                $titulo=$row['titulo'];
                                $ano=$row['ano'];
                                $id=$row['id'];
                                $aka=$row['aka'];
                                
                                
                                $result2 = mysqli_query($mysqli, 'select avg(nota) as "nota" from notas where id_filme='.$id);
                                $row2 = mysqli_fetch_assoc($result2);
                                $nota=number_format($row2['nota'], 1, '.');
                                
                                echo '<div class="listclick">'.
                                    $aka.' - ('.$ano.')<div style="float: right;">'
                                        .$nota.' ★</div>'
                                .'</div>';
                            };
                        };
                        mysqli_free_result($result);
                    ?>
                </div>
            </div>
        </div>
        
        <!-- Rodapé -->
        <?php include "footer.php" ?> <!-- Rodapé da Página -->
        
        </div>
    </body>
</html>
