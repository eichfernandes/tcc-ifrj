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
                        Diretor:<div style="text-align: right; float: right;">ID:</div>
                    </div>
                    <div style="padding: 0px 11px 20px; font-size: 25px;">
                        <?php echo $nome; ?>
                        <div style="text-align: right; float: right;">
                            [ <?php echo $idir; ?> ]
                        </div>
                    </div>

                    <form method="post" action="diretor_pesquisa.php">
                        <input class="searchbar" size="25" name="pesquisa" placeholder="Pesquisar"
                               value="<?php if(!empty($_SESSION['pesquisadirfil'])){echo $_SESSION['pesquisadirfil'];}; ?>">
                        <select name="ordem" style="float: right; padding: 7px 9px;" class="order" onchange="this.form.submit()">
                            <option <?php if(!empty($_SESSION['ordemdirfil'])&&$_SESSION['ordemdirfil']=='filmes.id_filme'){echo "selected";}?> 
                                value="filmes.id_filme">ID ↓</option>
                            <option <?php if(!empty($_SESSION['ordemdirfil'])&&$_SESSION['ordemdirfil']=='filmes.id_filme desc'){echo "selected";}?>
                                value="filmes.id_filme desc">ID ↑</option>
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
                                Título - ( Ano )<div style="text-align: right; float: right;"> Nota - [ ID ]</div>
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
                                        .$nota.' ★ - [ '.$id.' ]</div>'
                                .'</div>';
                            };
                        };
                        mysqli_free_result($result);
                    ?>
                    
                    <!-- ADICIONAR FILMES -->
                    <div  style="font-size: 20px; margin: 20px 12px 0px;">
                        <form method="post" action="adicionar_filme.php">
                            <h2 style="margin: 10px 0px;">Adicionar Filme</h2>
                            
                            ID Diretor 2: <input name="dir2" type="number" class="searchbar" min="1" max="99999999" size="8"
                                style="margin: 10px 0px 0px;" placeholder="(Opcional)"><br>
                            
                            ID Diretor 3: <input name="dir3" type="number" class="searchbar" min="1" max="99999999" size="8"
                                style="margin: 10px 0px 0px;" placeholder="(Opcional)"><br>
                            
                            ID Diretor 4: <input name="dir4" type="number" class="searchbar" min="1" max="99999999" size="8"
                                style="margin: 10px 0px 0px;" placeholder="(Opcional)"><br>
                            
                            Título: <input name="titulo" type="text" class="searchbar" maxlength="100" size="30"
                                style="margin: 10px 0px 0px;" placeholder="Título em Inglês ou Mais Famoso"><br>

                            AKA: <input name="aka" type="text" class="searchbar" maxlength="100" size="30"
                                style="margin: 10px 0px 0px;" placeholder="Título em Português se Existir"><br>

                            Lançamento: <input name="ano" type="number" class="searchbar" min="1850" max="3000" size="4"
                                style="margin: 10px 0px 0px;" placeholder="(Ano)"><br>
                            
                            <input name="idir" type="hidden" value="<?php echo $idir; ?>">
                            <input type="submit" class="but" value="Adicionar" onclick="this.disabled=true;this.value='Enviando, Aguarde...';this.form.submit();"
                                   style="text-align: center;font-size: 16px; margin-top: 10px;"/>
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
