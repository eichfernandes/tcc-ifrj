<?php include 'conexao.php';
session_set_cookie_params(3600*24*7);
session_start();
$user = mysqli_real_escape_string($mysqli, $_GET['u']);

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

if (isset($_SESSION['id_usuario'])){
    
    $result = mysqli_query($mysqli,"select * from amizades where id_usuario='".$_SESSION['id_usuario']."' and "
            . "id_amigo='$id';");
    $valid = mysqli_num_rows($result);
    if($valid==1){
        $friend=true;
        $self = false;
    }else{
        if($_SESSION['id_usuario']==$id){
            $self = true;
        }else{$friend = false; $self = false;};
    };
    
}else{
    $self = false;
};

if(!empty($_GET['p'])){
    $type = $_GET['p'];
    if($type != 'notas'&&$type != 'sinopses'&&$type != 'avaliacoes'){
        header('Location: index.php');
        exit();
    };
}else{
    $type = "notas";
};

if($type=="notas"){$tt="#not";}
elseif($type=="sinopses"){$tt="#sin";}
elseif($type=="avaliacoes"){$tt="#ava";};


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Me Indica - <?php echo $row['usuario']; ?></title>
        <link href="style.css" rel="stylesheet">
        <link rel="shortcut icon" href="icone.png" type="image/x-png">
        <style>
            <?php echo $tt; ?>{background-color: #2f3037; border-radius: 50px;
            padding: 9px 20px;}
            <?php echo $tt; ?>:hover{color: #F3F4F9;}
            #not, #sin, #ava{padding: 9px 20px;}
            textarea::-webkit-scrollbar{
                width: 0;
            }
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
                    <div style="width: 700px; margin: 0px auto 20px; text-align: center">
                        <?php 
                        $resultseg = mysqli_query($mysqli, "select (select count(id_usuario) from amizades where id_usuario=1)"
                                . " as 'Seguindo', (select count(id_amigo) from amizades where id_amigo=1) as 'Seguidores'");
                        $rowseg = mysqli_fetch_assoc($resultseg);
                        ?>
                        <span style="font-size: 16px; opacity: 70%">
                        Tem <?php echo number_format($rowseg['Seguidores'],0,",","."); if($rowseg['Seguidores']==1){echo " Seguidor";}else{echo " Seguidores";} ?><br>
                        e Segue <?php echo number_format($rowseg['Seguindo'],0,",","."); if($rowseg['Seguindo']==1){echo " pessoa";}else{echo " pessoas";} ?></span>
                    </div>
                    <div class="blockin" style="padding-bottom: 16px; text-align: center; width: 550px; margin: auto;">
                        
                        <div style="width: 100%;">
                            <h1 style="padding-bottom: 7px;"><?php echo $row['usuario']; ?></h1>
                            <h2 style="opacity: 60%;"><?php echo "'".$nome.' '.$sobrenome."'"; ?></h2>
                        </div>
                        <?php if(!$self&&isset($_SESSION['id_usuario'])){ ?>
                        <?php if(!$friend){ ?>
                        <div style="text-align: center; width: 100%; padding:0px; margin-top: 10px;">
                            <form id="adfollow" method="post" action="follow.php">
                                <input name="iduser" type="hidden" value="<?php echo $id; ?>">
                                <input name="follow" type="hidden" value="a">
                                <input type="button" class="adicionar" value="Seguir" onclick="this.disabled=true; adfollow();"
                                       style="font-size: 18px;"/>
                            </form>
                        </div>
                        <?php }else{ ?>
                        <div style="text-align: center; width: 100%; padding:0px; margin-top: 10px;">
                            <form id="stopfollow" method="post" action="follow.php">
                                <input name="iduser" type="hidden" value="<?php echo $id; ?>">
                                <input name="follow" type="hidden" value="r">
                                <input type="button" class="seguindo" value="Seguindo" onmouseover="this.value='Deixar de Seguir'"
                                       onmouseout="this.value='Seguindo'" onclick="this.disabled=true; stopfollow();"
                                       style="font-size: 18px;"/>
                            </form>
                        </div>
                        <?php };}; ?>
                        <script>
                            function adfollow() {
                                document.getElementById("adfollow").submit();
                            };
                            function stopfollow() {
                                if (confirm("Tem Certeza que Deseja Parar de Seguir <?php echo $usuario; ?>?")){
                                    document.getElementById("stopfollow").submit();}else{location.reload();};
                            };
                        </script>
                    </div>
                    
                    
                    
                    
                    <!-- ABAS -->
                    <div style="display: flex; justify-content: space-between; width: 600px; margin: 30px auto 0px;
                        align-items: center; font-size: 20px; margin-bottom: 30px;">
                        <a id="not" class="link" href="usuario.php?u=<?php echo $usuario; ?>&p=notas">Notas</a>
                        |<a id="sin" class="link" href="usuario.php?u=<?php echo $usuario; ?>&p=sinopses">Sinopses</a>
                        |<a id="ava" class="link" href="usuario.php?u=<?php echo $usuario; ?>&p=avaliacoes">Avaliações</a>
                    </div>
                    
                    
                    <!-- NOTAS -->
                    <?php if($type == "notas"){ ?>
                    <form method="get" style="text-align: center;" action="usuario.php">
                        <input name="u" type="hidden" value="<?php echo $usuario; ?>">
                        <input name="p" type="hidden" value="<?php echo $type; ?>">
                        <input class="searchbar" name="pesquisa" type="text" placeholder="Pesquisar" size="40" value="<?php if(isset($_GET['pesquisa'])){echo $_GET['pesquisa'];} ?>">
                        <select class="searchbar" name="ordem" style="margin-left: 10px;" onchange="this.form.submit()">
                            <option <?php if(isset($_GET['ordem'])&&$_GET['ordem']=="A-Z"){echo "selected";} ?>>A-Z</option>
                            <option <?php if(isset($_GET['ordem'])&&$_GET['ordem']=="Z-A"){echo "selected";} ?>>Z-A</option>
                            <option <?php if(isset($_GET['ordem'])&&$_GET['ordem']=="1-5"){echo "selected";} ?>>1-5</option>
                            <option <?php if(isset($_GET['ordem'])&&$_GET['ordem']=="5-1"){echo "selected";} ?>>5-1</option>
                        </select>
                    </form>
                    <?php
                    if(isset($_GET['pesquisa'])&&$_GET['pesquisa']!=""){
                        $pesq = " and (aka like '%".mysqli_real_escape_string($mysqli, $_GET['pesquisa'])."%'"
                                . " or titulo like '%".mysqli_real_escape_string($mysqli, $_GET['pesquisa'])."%'"
                                . " or nota like '%".mysqli_real_escape_string($mysqli, $_GET['pesquisa'])."')";
                    }else{$pesq = "";}
                    
                    if(isset($_GET['ordem'])){
                    if($_GET['ordem']=="Z-A"){
                        $ordem = " order by aka desc";
                    }elseif($_GET['ordem']=="1-5"){$ordem = " order by nota, aka";
                    }elseif($_GET['ordem']=="5-1"){$ordem = " order by nota desc, aka";
                    }else{$ordem = " order by aka";}}else{$ordem = " order by aka";}
                    
                    $query = "SELECT notas.nota as 'nota', filmes.titulo as 'titulo', filmes.aka as 'aka' FROM notas"
                            . " inner join filmes on filmes.id_filme=notas.id_filme where notas.id_usuario=$id"
                            . $pesq . $ordem;
                    $result = mysqli_query($mysqli, $query);
                    $valid = mysqli_num_rows($result);
                    if($result&&$valid>=1){
                    while($row = mysqli_fetch_assoc($result)){
                        $nota = $row['nota'];
                        $aka = $row['aka'];
                        ?>
                    <div class="blockin" style="font-size: 20px; width: 550px; margin: auto; display: flex; margin-bottom: 16px;">
                        <div style="width: 70%;">
                            <a class="link" href="filme.php?id=<?php echo $aka; ?>"><?php echo $aka; ?></a>
                        </div>
                        <div style="width: 30%; text-align: right;">
                            <?php echo "$nota ★" ?>
                        </div>
                    </div>
                    <?php
                    }
                    }else{ ?>
                    <div style="text-align: center; font-size: 25px;">
                        -----------------------------------------------<br>
                        Este usuário não avaliou nenhum filme.<br>
                        -----------------------------------------------
                    </div>
                    <?php }; ?>
                    <?php }; ?>
                    
                    
                    <!-- Sinopses -->
                    <?php if($type == "sinopses" || $type == "avaliacoes"){
                            if($type == "sinopses"){$sa=0;}else{$sa=1;}
                    ?>
                    <form method="get" style="text-align: center; margin: 0px 0px 10px;" action="usuario.php">
                        <input name="u" type="hidden" value="<?php echo $usuario; ?>">
                        <input name="p" type="hidden" value="<?php echo $type; ?>">
                        <input class="searchbar" name="pesquisa" type="text" placeholder="Pesquisar" size="40" value="<?php if(isset($_GET['pesquisa'])){echo $_GET['pesquisa'];} ?>"
                               style="margin: 0px;">
                        <select class="searchbar" name="ordem" style="margin: 0px 0px 0px 10px;" onchange="this.form.submit()">
                            <option <?php if(isset($_GET['ordem'])&&$_GET['ordem']=="Maior Relevância"){echo "selected";} ?>>Maior Relevância</option>
                            <option <?php if(isset($_GET['ordem'])&&$_GET['ordem']=="Menor Relevância"){echo "selected";} ?>>Menor Relevância</option>
                            <option <?php if(isset($_GET['ordem'])&&$_GET['ordem']=="Título ↓"){echo "selected";} ?>>Título ↓</option>
                            <option <?php if(isset($_GET['ordem'])&&$_GET['ordem']=="Título ↑"){echo "selected";} ?>>Títlo ↑</option>
                            <option <?php if(isset($_GET['ordem'])&&$_GET['ordem']=="Mais Recente"){echo "selected";} ?>>Mais Recente</option>
                            <option <?php if(isset($_GET['ordem'])&&$_GET['ordem']=="Menos Recente"){echo "selected";} ?>>Menos Recente</option>
                        </select>
                    </form>
                    
                    <?php
                    
                    if(isset($_GET['pesquisa'])&&$_GET['pesquisa']!=""){
                        $p = mysqli_real_escape_string($mysqli, $_GET['pesquisa']);
                        $pesq = " and (aka like '%$p%' or titulo like '%$p%') ";
                    }else{$pesq = " ";}
                    
                    if(isset($_GET['ordem'])){
                        if($_GET['ordem']=="Menor Relevância"){
                            $order = "relevancia, aka";
                        }elseif($_GET['ordem']=="Título ↓"){
                            $order = "aka, relevancia";
                        }elseif($_GET['ordem']=="Título ↑"){
                            $order = "aka desc, relevancia";
                        }elseif($_GET['ordem']=="Mais Recente"){
                            $order = "a.data desc, a.hora desc, aka";
                        }elseif($_GET['ordem']=="Menos Recente"){
                            $order = "a.data, a.hora, aka";
                        }else{$order = "relevancia desc, aka";}
                    }else{$order = "relevancia desc, aka";}
                    
                    // SINOPSES DA COMUNIDADE
                    $query = "select a.id_sa as 'id_sa', a.conteudo as 'conteudo',"
                        . " a.id_usuario as 'id_usuario', a.id_filme as 'id_filme',"
                        . " a.s_a as 's_a', a.relevancia as 'relevancia',"
                        . " date_format(a.data, '%d/%m/%Y') as 'dat',"
                        . " TIME_FORMAT(a.hora, '%H:%i') as 'hor', f.aka as 'aka', f.titulo as 'titulo'"
                        . " from sinopses_avaliacoes as a inner join filmes as f on a.id_filme=f.id_filme"
                        . " where a.id_usuario=$id and a.s_a=$sa".$pesq."order by ".$order.";";
                    $result = mysqli_query($mysqli, $query);
                    $valid = mysqli_num_rows($result);
                    if($result&&$valid>=1){
                        while($row = mysqli_fetch_assoc($result)){ ?>
                            <div class="blockin" style="margin: 20px auto; width: 600px; padding: 15px 15px; font-size: 18px; text-align: left;">
                                <p style="font-size: 16px; opacity: 60%; margin: 0px 0px 5px 0px;">
                                    <?php echo $usuario; ?> sobre</p>
                                <a style="font-size: 20px;"
                                    class="tag" href="filme.php?id=<?php echo $row['aka']; ?>">
                                    <?php echo $row['aka']; ?></a>
                                <p style="margin: 20px 0px 20px;"><?php echo nl2br($row['conteudo']); ?></p>
                                <p>
                                    <form method="post" action="adicionar_sa.php">
                                        <input name="id_sa" type="hidden" value="<?php echo $row['id_sa']; ?>">
                                        <input name="id_usuario" type="hidden" value="<?php echo $id; ?>">
                                        <span style="font-size: 14px; opacity: 50%"><?php echo $row['dat']." - ".$row['hor']; ?></span>
                                        
                                        <div style="float: right;">
                                            <?php 
                                            // BONS
                                            $query = "select count(avaliacao) as aval from avaliacoes_sa where id_sa={$row['id_sa']} and avaliacao=1;";
                                            $result4 = mysqli_query($mysqli, $query);
                                            $row4 = mysqli_fetch_assoc($result4);
                                            $ups = $row4['aval'];
                                            
                                            // RUINS
                                            $query = "select count(avaliacao) as aval from avaliacoes_sa where id_sa={$row['id_sa']} and avaliacao=-1;";
                                            $result4 = mysqli_query($mysqli, $query);
                                            $row4 = mysqli_fetch_assoc($result4);
                                            $downs = $row4['aval'];
                                            
                                            if(isset($_SESSION['id_usuario'])&&$id!=$_SESSION['id_usuario']){
                                            $query = "select avaliacao from avaliacoes_sa where id_sa={$row['id_sa']}"
                                            . " and id_usuario={$_SESSION['id_usuario']};";
                                            $result3 = mysqli_query($mysqli, $query);
                                            $row3 = mysqli_fetch_assoc($result3);
                                            
                                            ?>
                                            <input name="aval" class="<?php if($row3['avaliacao']==1){echo "upa";}else{echo "up";} ?>" type="submit" value="▲"> <?php echo $ups; ?>
                                            <input name="aval" class="<?php if($row3['avaliacao']==-1){echo "downa";}else{echo "down";} ?>" type="submit" value="▼"> <?php echo $downs; ?>
                                            <?php }else{ ?>
                                            ▲ <?php echo $ups; ?>
                                            ▼ <?php echo $downs; ?>
                                            <?php } ?>
                                        </div>
                                        
                                    </form>
                                </p>
                            </div>
                            <?php }}else{ ?>
                    <div style="text-align: center; font-size: 25px;">
                        -----------------------------------------------<br>
                        Nenhum Resultado.<br>
                        -----------------------------------------------
                    </div>
                    <?php }
                    } ?>
                </div> 
            </div>
        </div>
        
        <!-- Rodapé -->
        <?php include "footer.php" ?> <!-- Rodapé da Página -->
        
        </div>
    </body>
</html>

