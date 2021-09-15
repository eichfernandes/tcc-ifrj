<?php 
session_set_cookie_params(3600*24*7);
session_start();
include "conexao.php";

$t = 0;

if(isset($_GET['s'])&&$_GET['s']!=""){
    $s = $_GET['s'];
};
if(isset($_GET['o'])){
    $o = $_GET['o'];
};
if(isset($_GET['todos'])){
    $all = 1;
}else{$all = 0;};

if(isset($_GET['page'])){
    $page = (int)$_GET['page'];
}else{$page = 1;}
if($page <= 0){
    $page = 1;
}
$begin = 0 + 10*($page-1);
$end = 10 + 10*($page-1);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Me Indica - Avaliação de Filmes</title>
        <link href="style.css" rel="stylesheet">
        <link rel="shortcut icon" href="icone.png" type="image/x-png">
        <style>
            #all{display:none;}
            img:hover{opacity: 60%}
        </style>
    </head>
    <body>
        <div class="semibody"><!-- Esta div está relacionada a tela e ajuda a ajustar as restantes -->
        
        <!-- Cabeçalho -->
        <?php include "header.php" ?> <!-- Cabeçalho da Página -->
        
        <!-- Conteúdo -->
        <div style="display: flex; justify-content: space-between; align-items: center; height: 100%;">
            <div class="content" style="width: 900px;"><!-- Define o que estará no conteúdo central -->
                <div class="block"><!-- Cada div block é um bloco de conteúdo -->
                    <form method="get">
                        <!-- TAGS -->
                        <div style="margin: 0px 0px 20px;text-align: center;">
                            <div style="margin-bottom: 10px;">
                                <label class="tagw" style="font-size: 20px;"><input name="todos" id="all" type="checkbox" class="check" onclick="this.form.submit()"
                                <?php if($all==1){echo "checked";} ?>>Filtrar Tags</label></div>
                            <?php if($all==1){ ?>
                            <?php 
                            $alltags = "";
                            $result = mysqli_query($mysqli, "select * from tags;");
                            if($result){
                                while($row = mysqli_fetch_assoc($result)){
                                    $tag = $row['tag'];
                                    $idtag = $row['id_tag'];
                            ?>
                            <div style="display: inline-block; margin-bottom: 8px;">
                            <label class="tagw"><input name="<?php echo $tag; ?>" type="checkbox" class="check" onclick="this.form.submit()"
                                <?php if(isset($_GET[$tag])){echo "checked";
                                if($t==1){$alltags = $alltags." and classificacoes.id_tag=$idtag";}else{$alltags = "classificacoes.id_tag=$idtag";
                                $t=1;}} ?>> - <?php echo $tag ?></label></div>
                            <?php }}} ?>
                        </div>
                        
                        <!-- PESQUISA -->
                        
                        <input name="s" type="text" maxlength="70" size="40" class="searchbar" placeholder="Pesquisar Filmes"
                               <?php if(isset($s)&&$s!=''){echo "value='$s'";} ?> style="margin-bottom: 20px;">
                        <div style="float: right;">
                            <span style="font-size: 18px;">Ordem: </span><select name="o" class="searchbar" onchange="this.form.submit()">
                                <option value="nota desc" <?php if(isset($o)&&$o=="nota desc"){echo "selected"; $or=1;} ?>>
                                    Melhor Nota</option>

                                <option value="nota" <?php if(isset($o)&&$o=="nota"){echo "selected";$or=1;} ?>>
                                    Pior Nota</option>
                                
                                <option value="aka" <?php if(isset($o)&&$o=="aka"){echo "selected";$or=1;} ?>>
                                    Título A-Z</option>

                                <option value="aka desc" <?php if(isset($o)&&$o=="aka desc"){echo "selected";$or=1;} ?>>
                                    Título Z-A</option>
                                
                                <option value="ano desc" <?php if(isset($o)&&$o=="ano desc"){echo "selected";$or=1;} ?>>
                                    Mais Recente</option>

                                <option value="ano" <?php if(isset($o)&&$o=="ano"){echo "selected";$or=1;} ?>>
                                    Menos Recente</option>

                            </select>
                        </div>
                    
                        <div>
                        <!-- RESULTADOS -->
                        <?php
                        
                        if(isset($alltags)&&$alltags != ""){$alltags = " and (".$alltags.")";}
                        elseif($all==1){$alltags = " and (classificacoes.id_tag=0)";}else{$alltags = "";}
                        
                        if(!isset($or)||$or!=1){
                            $o = " order by nota desc";
                        }else{$o = " order by ".$o;}
                        
                        if(isset($_GET['s'])){
                            $pesquisa = mysqli_real_escape_string($mysqli, $_GET['s']);
                        }else{$pesquisa = "";}
                        
                        $query = "SELECT filmes.aka as 'aka', filmes.titulo as 'titulo', filmes.nota_media as 'nota' from classificacoes"
                        . " join filmes on classificacoes.id_filme=filmes.id_filme"
                        . " where (aka like '%$pesquisa%' or titulo like '%$pesquisa%')".$alltags
                        . " group by aka".$o.";";
                        $result = mysqli_query($mysqli, $query);
                        $numrows = mysqli_num_rows($result);
                        if($numrows%10>=1){
                            $x = 1;
                        }else{$x = 0;}
                        $tot = $numrows;
                        $total = intdiv($numrows,10)+$x;
                        if($total==0){$total=1;}
                        
                        if($page>$total){
                            header("Location: ".$local.str_replace("page=".$_GET['page'], "page=1", $_SERVER['REQUEST_URI']));
                        }
                        
                        $query = "SELECT filmes.aka as 'aka', filmes.banner as 'poster', filmes.id_filme as 'idfil',"
                        . " filmes.titulo as 'titulo', filmes.nota_media as 'nota', filmes.ano as 'ano'"
                        . " from classificacoes"
                        . " join filmes on classificacoes.id_filme=filmes.id_filme"
                        . " where (aka like '%$pesquisa%' or titulo like '%$pesquisa%')".$alltags
                        . " group by aka".$o
                        . " limit ".$begin.",".$end.";";
                        
                        $result = mysqli_query($mysqli, $query); ?>
                        
                        <span style="text-align: center; opacity: 50%; margin-left: 10px;"><?php echo $tot ?> resultados...</span>
                        <?php
                        if($result&&$numrows>=1){
                            while($row = mysqli_fetch_assoc($result)){ ?>
                        <div class="listclick" style="margin-bottom: 15px; padding: 0px; display: flex; border-radius:10px;"
                             onclick="location.href='filme.php?id=<?php echo $row['aka'] ?>';">
                            <?php if(isset($row['poster'])){ ?>
                            <div style="max-width: 18%; display: block">
                                <img src="<?php echo $row['poster'] ?>" width="100%" height="100%" style="border-radius: 10px 0px 0px 10px; display: block"
                                    title="<?php echo $row['aka']." - '".$row['titulo']."' (".$row['ano'].")" ?>">
                            </div>
                            <?php } ?>
                            <div style="display: inline-block; <?php if(isset($row['poster'])){echo "width: 82%;";}else{echo "width: 100%;";} ?> padding: 10px 20px;">
                                <h2 style="font-size: 31px"><?php echo $row['aka'] ?></h2>
                                <span style="font-size: 25px; opacity: 50%; font-style: italic;">'<?php echo $row['titulo'] ?>'</span><br>
                                <span style="font-size: 27px; opacity: 80%;">(<?php echo $row['ano'] ?>) - ★ <?php echo $row['nota'] ?></span><br>
                                <?php
                                $query = "select diretores.nome as 'diretor' from direcao join diretores"
                                        . " on direcao.id_diretor=diretores.id_diretor where direcao.id_filme={$row['idfil']};";
                                $result2 = mysqli_query($mysqli, $query);
                                if($result2){
                                    while($row2 = mysqli_fetch_assoc($result2)){ ?>
                                <a href="diretor.php?id=<?php echo $row2['diretor'] ?>" class="tag" style="line-height: 240%;">
                                    <?php echo $row2['diretor'] ?></a>
                                    <?php }
                                }
                                ?>
                            </div>
                        </div>
                            <?php }
                        }else{ ?>
                        <div style="text-align: center; font-size: 25px; margin-bottom: 50px;"><br>
                            -----------------------------------------------<br>
                            Nenhum Resultado.<br>
                            -----------------------------------------------
                        </div>
                            
                        <?php } ?>
                        </div>
                        <div style="text-align: center;">
                            <input name="page" type="submit" value="<?php $page ?>" style="display: none;">
                            <?php if($page>1){ ?>
                            <a name="page" type="submit" class="link" href="<?php if(isset($_GET['page'])){echo str_replace("page=".$_GET['page'], "page=".($page-1), $_SERVER['REQUEST_URI']);}
                            else{echo $_SERVER['REQUEST_URI']."?&page=".($page-1);} ?>"
                                   style="font-size: 30px; font-weight: 500"><</a>
                            <?php } ?>
                            <text style="font-size: 30px;"><?php echo "Página ".$page." de ".$total ?></text>
                            <?php if($page<$total){ ?>
                            <a name="page" type="submit" class="link" href="<?php if(isset($_GET['page'])){echo str_replace("page=".$_GET['page'], "page=".($page+1), $_SERVER['REQUEST_URI']);}
                            else{echo $_SERVER['REQUEST_URI']."?&page=".($page+1);} ?>"
                                   style="font-size: 30px; font-weight: 500">></a>
                            <?php }; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Rodapé -->
        <?php include "footer.php" ?> <!-- Rodapé da Página -->
        
        </div>
    </body>
</html>
