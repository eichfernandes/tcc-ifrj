<?php session_start(); include "conexao.php";
if (empty($_GET['id'])){header('Location: diretores.php');};

$id = mysqli_real_escape_string($mysqli, $_GET['id']);
$query = "select * from diretores where id_diretor='$id' or nome='$id';";
$result = mysqli_query($mysqli, $query);
$valid = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);

if($valid!=1){header('Location: index.php');
    exit();}
    
// PUXANDO DADOS //
$idir = $row['id_diretor'];
$foto = $row['foto'];
$nome = $row['nome'];

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Me Indica - <?php echo $nome; ?></title>
        <link href="style.css" rel="stylesheet">
        <link rel="shortcut icon" href="icone.png" type="image/x-png">
    </head>
    <body>
        <div class="semibody"><!-- Esta div está relacionada a tela e ajuda a ajustar as restantes -->
        
        <!-- Cabeçalho -->
        <?php include "header.php"; ?> <!-- Cabeçalho da Página -->
        
        <!-- Conteúdo -->
        <div style="display: flex; justify-content: space-between; align-items: center; height: 100%;">
            <div class="content" style="width: 780px;"><!-- Define o que estará no conteúdo central -->
                
                <!-- ERROS -->
                <?php if(isset($_SESSION['addir_erro'])): ?>
                    <div class="block" style="text-align: center; padding: 20px 30px 30px 30px; background-color: #771122;">
                        Erro de Adição<br>Algum Campo Obrigatório Faltando
                    </div>
                <?php endif; unset($_SESSION['addir_erro']); ?>
                
                <div class="block"><!-- Cada div block é um bloco de conteúdo -->
                    
                    <!-- INFORMAÇÕES DO DIRETOR -->
                    <?php if(!empty($foto)){ ?>
                    <img style="padding: 0px 0px; display: block; margin: auto; border-radius: 20px;" src="<?php echo $foto; ?>" height="300px"><br><br>
                    <?php }; ?>
                    <div style="padding: 0px 11px; font-size: 14px;">
                        Diretor:
                        <!-- ID if ADM -->
                        <?php if (isset($_SESSION['adm'])&&$_SESSION['adm']==1){ ?>
                            <div style="text-align: right; float: right;">ID:</div>
                        <?php }; ?>
                    </div>
                    <div style="padding: 0px 11px 20px; font-size: 25px;">
                        <?php echo $nome; ?>
                        <!-- ID if ADM -->
                        <?php if (isset($_SESSION['adm'])&&$_SESSION['adm']==1){ ?>
                            <div style="text-align: right; float: right;">
                                [ <?php echo $idir; ?> ]
                            </div>
                        <?php }; ?>
                    </div>

                    <form method="post" action="diretor_pesquisa.php">
                        <input name="idir" type="hidden" value="<?php $idir ?>"/>
                        <input class="searchbar" size="25" name="pesquisa" placeholder="Pesquisar"
                               value="<?php if(!empty($_SESSION['pesquisadirfil'])){echo $_SESSION['pesquisadirfil'];}; ?>">
                        <select name="ordem" style="float: right; padding: 7px 9px;" class="order" onchange="this.form.submit()">
                            <option <?php if(!empty($_SESSION['ordemdirfil'])&&$_SESSION['ordemdirfil']=='filmes.aka'){echo "selected";}?>
                                value="filmes.aka">Titulo ↓</option>
                            <option <?php if(!empty($_SESSION['ordemdirfil'])&&$_SESSION['ordemdirfil']=='filmes.aka desc'){echo "selected";}?>
                                value="filmes.aka desc">Titulo ↑</option>
                            <option <?php if(!empty($_SESSION['ordemdirfil'])&&$_SESSION['ordemdirfil']=='filmes.nota_media, filmes.aka'){echo "selected";}?>
                                value="filmes.nota_media, filmes.aka">Nota ↓</option>
                            <option <?php if(!empty($_SESSION['ordemdirfil'])&&$_SESSION['ordemdirfil']=='filmes.nota_media desc, filmes.aka'){echo "selected";}?>
                                value="filmes.nota_media desc, filmes.aka">Nota ↑</option>
                            <option <?php if(!empty($_SESSION['ordemdirfil'])&&$_SESSION['ordemdirfil']=='filmes.ano, filmes.aka'){echo "selected";}?>
                                value="filmes.ano, filmes.aka">Ano ↓</option>
                            <option <?php if(!empty($_SESSION['ordemdirfil'])&&$_SESSION['ordemdirfil']=='filmes.ano desc, filmes.aka'){echo "selected";}?>
                                value="filmes.ano desc, filmes.aka">Ano ↑</option>
                            <!-- Ordens de ADM -->
                            <?php if (isset($_SESSION['adm'])&&$_SESSION['adm']==1){ ?>
                                <option <?php if(!empty($_SESSION['ordemdirfil'])&&$_SESSION['ordemdirfil']=='filmes.id_filme'){echo "selected";}?> 
                                    value="filmes.id_filme">ID ↓</option>
                                <option <?php if(!empty($_SESSION['ordemdirfil'])&&$_SESSION['ordemdirfil']=='filmes.id_filme desc'){echo "selected";}?>
                                    value="filmes.id_filme desc">ID ↑</option>
                            <?php }; ?>
                        </select>
                    </form>
                    
                    <!-- LISTA DE FILMES -->
                    <?php
                        
                        if(!empty($_SESSION['pesquisadirfil'])){
                            $pesq = mysqli_real_escape_string($mysqli,$_SESSION['pesquisadirfil']);
                            $pesquisa="and (filmes.titulo like '%".$pesq."%' or filmes.aka like '%".$pesq."%' or filmes.ano like '%".$pesq."%') ";
                        }else{$pesquisa="";};
                        
                        unset($_SESSION['pesquisadirfil']);
                        
                        if(isset($_SESSION['ordemdirfil'])){
                            $order = " order by " . $_SESSION['ordemdirfil'];
                        }else{$order = " order by filmes.id_filme"; };
                        $order = mysqli_real_escape_string($mysqli, $order);
                    
                        $query = "select filmes.titulo as 'titulo', filmes.aka as 'aka', filmes.ano as 'ano', filmes.id_filme as 'id', filmes.nota_media as 'nota' "
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
                                Título - ( Ano )<div style="text-align: right; float: right;"> Nota 
                                <?php if (isset($_SESSION['adm'])&&$_SESSION['adm']==1){echo ' - [ ID ]';}; ?></div>
                            </div>
                        <?php };
                        
                        /* LISTANDO FILMES */
                        if ($result){
                            while ($row = mysqli_fetch_assoc($result)){
                                $titulo=$row['titulo'];
                                $ano=$row['ano'];
                                $id=$row['id'];
                                $aka=$row['aka'];
                                $nota=number_format($row['nota'], 1, '.');
                                
                                echo '<form name="form'.$id.'" method="get" action="filme.php">'.
                                    '<input name="id" type="hidden" value="'.$aka.'">'
                                    . '<div class="listclick" onClick="document.forms.form'.$id.'.submit();">'.
                                    $aka.' - ('.$ano.')<div style="float: right;">'
                                        .$nota.' ★';
                                if (isset($_SESSION['adm'])&&$_SESSION['adm']==1){echo  ' - [ '.$id.' ]';};
                                echo '</div></div></form>';
                            };
                        };
                        mysqli_free_result($result);
                    ?>
                    
                    <!-- ADICIONANDO FILMES -->
                    <?php if (isset($_SESSION['adm'])&&$_SESSION['adm']==1){ ?>
                    <div  style="font-size: 20px; width: 370px; padding-bottom: 35px; margin: 30px auto 0px;" class="blockin">
                        <form method="post" action="adicionar_filme.php">
                            <h2 style="margin: 10px 0px;">Adicionar Filme</h2>
                            
                            Título: <input name="titulo" type="text" class="searchbarblack" maxlength="100" size="30"
                                style="margin: 10px 0px 0px;" placeholder="Título em Inglês ou Mais Famoso"><br>

                            AKA: <input name="aka" type="text" class="searchbarblack" maxlength="100" size="30"
                                style="margin: 10px 0px 0px;" placeholder="Título em Português se Existir"><br>

                            Lançamento: <input name="ano" type="number" class="searchbarblack" min="1850" max="3000" size="4"
                                style="margin: 10px 0px 0px;" placeholder="(Ano)" maxlength="4"><br>
                            
                            <input name="idir" type="hidden" value="<?php echo $idir; ?>">
                            <input type="submit" class="but" value="Adicionar" onclick="this.disabled=true;this.value='Aguarde...';this.form.submit();"
                                   style="text-align: center;font-size: 16px; margin-top: 10px;"/>
                        </form>
                    </div>
                    <!-- DELETAR DIRETOR -->
                    <div style="text-align: center; margin-top: 10px;">
                        <form id="remove" method="post" action="remover_diretor.php">
                            <input name="idir" type="hidden" value="<?php echo $idir; ?>">
                            <input type="button" class="remover" value="Deletar Diretor" onclick="this.disabled=true; remove();"
                                style="text-align: center; font-size: 16px; margin-top: 10px;"/>
                        </form>
                    </div>
                    <script>
                        function remove() {
                          if (confirm("Tem Certeza que Deseja Deletar este Diretor?")) {
                            document.getElementById("remove").submit();}else{location.reload();};
                        }
                    </script>
                    <?php }; ?>
                </div>
            </div>
        </div>
        
        <!-- Rodapé -->
        <?php include "footer.php" ?> <!-- Rodapé da Página -->
        
        </div>
    </body>
</html>
