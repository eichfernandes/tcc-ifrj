<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="style.css" rel="stylesheet">
        <link rel="shortcut icon" href="icone.png" type="image/x-png">
<?php include 'conexao.php';
session_set_cookie_params(3600*24*7);
session_start();
if (empty($_GET['id'])){header('Location: index.php'); exit();}

if(isset($_SESSION['id_usuario'])){
    $iduser = $_SESSION['id_usuario'];
}

$id = mysqli_real_escape_string($mysqli, $_GET['id']);
$query = "select * from filmes where id_filme='$id' or titulo='$id' or aka='$id';";

$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);
$valid = mysqli_num_rows($result);

if($valid!=1){
    echo '<title>Me Indica - ???</title>';
    echo '<p style="padding: 10px;">Este Filme Não Existe...<br><a href="index.php">Voltar a Página Principal</a></p>';
    exit();};

if(empty($row['titulo'])){header('Location: index.php');
    exit();};

$id = $row['id_filme'];
$titulo = $row['titulo'];
$aka = $row['aka'];
$ano = $row['ano'];
$banner = $row['banner'];

$query = "select avg(notas.nota) as 'nota', count(notas.nota) as 'ava' from notas where notas.id_filme=$id";
$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);

$nota = number_format($row['nota'], 1, '.');
$ava = number_format($row['ava'], 0, '', '.');

$query = "SELECT diretores.nome as 'diretor', diretores.id_diretor as 'idir' FROM diretores, direcao "
        . "where diretores.id_diretor=direcao.id_diretor and direcao.id_filme=$id";
$result = mysqli_query($mysqli, $query);

$x=0;
if ($result){
    while ($row = mysqli_fetch_assoc($result)){
        $x=$x+1;
        $diretor[$x]=$row['diretor'];
        $idir[$x]=$row['idir'];
    };
};
mysqli_free_result($result);

$query = "SELECT tags.tag as 'tag', tags.id_tag as 'idtag' FROM tags, classificacoes "
        . "where tags.id_tag=classificacoes.id_tag and classificacoes.id_filme=$id "
        . "order by tag";
$result = mysqli_query($mysqli, $query);

$z=0;
if ($result){
    while ($row = mysqli_fetch_assoc($result)){
        $z=$z+1;
        $tag[$z]=$row['tag'];
        $idtag[$z]=$row['idtag'];
    };
};
mysqli_free_result($result);

if(!empty($_GET['p'])){
    $type = $_GET['p'];
    if($type != 'amigos'&&$type != 'sinopses'&&$type != 'avaliacoes'){
        header('Location: index.php');
        exit();
    };
}else{
    $type = "amigos";
};

if($type=="amigos"){$tt="#amg";}
elseif($type=="sinopses"){$tt="#sin";}
elseif($type=="avaliacoes"){$tt="#ava";};

?>
        <style>
            <?php echo $tt; ?>{background-color: #2f3037; border-radius: 50px;
            padding: 9px 20px;}
            <?php echo $tt; ?>:hover{color: #F3F4F9;}
            #amg, #sin, #ava{padding: 9px 20px;}
            textarea::-webkit-scrollbar{
                width: 0;
            }
        </style>
        <title>Me Indica - <?php echo $aka; ?></title>
    </head>
    <body>
        <div class="semibody"><!-- Esta div está relacionada a tela e ajuda a ajustar as restantes -->
        
        <!-- Cabeçalho -->
        <?php include "header.php" ?><!-- Cabeçalho da Página -->
        
        <!-- Conteúdo -->
        <div style="display: flex; justify-content: space-between; align-items: center; height: 100%;">
            <div class="content" style="width: 900px;"><!-- Define o que estará no conteúdo central -->
                
                <!-- ERROS DA PÁGINA -->
                <?php if(isset($_SESSION['adtag_erro'])): ?><!-- ERROR DE ADD TAG -->
                    <div class="block" style="text-align: center; padding: 20px 30px 30px 30px; background-color: #771122;">
                        Erro de Adição de Tag<br>Esta Tag Parece Não Existir
                    </div>
                <?php endif; unset($_SESSION['adtag_erro']); ?>
                
                <?php if(isset($_SESSION['addir_erro'])): ?><!-- ERROR DE ADD DIRETOR -->
                    <div class="block" style="text-align: center; padding: 20px 30px 30px 30px; background-color: #771122;">
                        Erro de Adição de Diretor<br>Este Diretor Parece Não Existir
                    </div>
                <?php endif; unset($_SESSION['addir_erro']); ?>
                
                <?php if(isset($_SESSION['retag_erro'])): ?><!-- ERROR DE REMOVER TAG -->
                    <div class="block" style="text-align: center; padding: 20px 30px 30px 30px; background-color: #771122;">
                        Erro de Remoção de Tag<br>Esta Tag Parece Não Existir
                    </div>
                <?php endif; unset($_SESSION['retag_erro']); ?>
                
                <?php if(isset($_SESSION['redir_erro'])): ?><!-- ERROR DE REMOVER DIRETOR -->
                    <div class="block" style="text-align: center; padding: 20px 30px 30px 30px; background-color: #771122;">
                        Erro de Remoção de Diretor<br>Este Diretor Parece Não Existir
                    </div>
                <?php endif; unset($_SESSION['redir_erro']); ?>
                
                <!-- PÁGINA DO FILME -->
                <div class="block"><!-- Cada div block é um bloco de conteúdo -->
                    <div style="display: flex;">
                        <?php if(empty($banner)){ ?><!-- BANNER -->
                            <div class="blockin" style="width: 280px; height: 300px; text-align: center;">
                                <p style="margin-top: 80px;">Não temos um Banner para este Filme :'(</p>
                            </div>
                        <?php }else{ ?>
                            <div>
                                <img src="<?php echo $banner; ?>" height="300"
                                    style="border-radius: 6px; display: block;">
                            </div>
                        <?php }; ?>
                        <div style="margin: 0px 0px 0px 20px; width: 100%;<?php if(!isset($_SESSION['usuario'])){echo 'padding-top: 20px; padding-bottom: 30px;';} ?>" class="blockin">
                            <!-- TITULO -->
                            <h1 style="display: inline-block; padding: 0px 0px;">
                                <?php echo $aka ?></h1>
                            
                            <!-- ANO -->
                            <p style="opacity: 75%; display: inline-block;"> (<?php echo $ano ?>)</p>
                            
                            <!-- TITULO ORIGINAL -->
                            <p style="opacity: 50%">
                                '<?php echo $titulo ?>'</p>
                            
                            <!-- DIRETORES -->
                            <p style="margin-top: 20px; line-height: 165%;"><text style="opacity: 75%">Direção: </text>
                                <?php $y=1; while($y<=$x){ ?><a class="tag" href="diretor.php?id=<?php echo $idir[$y]; ?>">
                                    <?php echo $diretor[$y]; ?></a> <?php $y=$y+1;}; ?>
                            </p>
                            
                            <!-- TAGS -->
                            <p style="margin-top: 20px; line-height: 165%;">Tags: 
                                <?php $y=1; while($y<=$z){ ?><a class="tag" href="#">
                                    <?php echo $tag[$y]; ?></a> <?php $y=$y+1;}; ?>
                            </p>
                            
                            <!-- NOTAS -->
                            <h2 style="margin-top: 10px; display: inline-block;">★ <?php echo $nota; ?></h2>
                            <h3 style="margin: 0px 0px 0px 2px; display: inline-block; opacity: 50%; font-size: 14px;">
                                de <?php echo $ava; ?> opniões</h3>
                            <?php if(isset($_SESSION['usuario'])){ ?>
                            <p style="margin-top: 5px">
                                <?php include "stars.php"; ?></p>
                            <?php }; ?>
                        </div>
                    </div>
                    
                    
                    <!-- ADIÇÃO E REMOÇÃO DE TAG E DIRETOR -->
                    <?php if(isset($_SESSION['adm'])&&$_SESSION['adm']==1){ ?>
                        <div class="blockin" style="display: box; margin: 20px auto 0px; text-align: center;">
                            <h1>ID do Filme [<?php echo $id; ?>]</h1>
                            <h1 style="margin-top: 8px;">Adicionar/Remover Tag/Diretor</h1>
                            <form style="margin-top: 20px; display: inline-block; margin-right: 38px;" method="post" action="adicionar_tag.php">
                                <input name="idfil" type="hidden" value="<?php echo $id; ?>">
                                <input name="tag" type="text" class="searchbarblack" placeholder="Tag ou ID da Tag">
                                <input id="tag" type="submit" class="but" value="Adicionar" onclick="this.disabled=true;this.value='Aguarde...';
                                    document.getElementById('dir').disabled=true;document.getElementById('retag').disabled=true;
                                    document.getElementById('redir').disabled=true;
                                    this.form.submit();"
                                    style="text-align: center;font-size: 16px;margin-left: 10px;"/>
                            </form>
                            <form style="margin-top: 10px; display: inline-block;" method="post" action="remover_tag.php">
                                <input name="idfil" type="hidden" value="<?php echo $id; ?>">
                                <input name="tag" type="text" class="searchbarblack" placeholder="Tag ou ID da Tag">
                                <input id="retag" type="submit" class="butred" value="Remover" onclick="this.disabled=true;this.value='Aguarde...';
                                    document.getElementById('tag').disabled=true;document.getElementById('dir').disabled=true;
                                    document.getElementById('redir').disabled=true;
                                    this.form.submit();"
                                    style="text-align: center;font-size: 16px;margin-left: 10px;"/>
                            </form>
                            
                            <br>
                            <form style="display: inline-block; margin-right: 38px;" method="post" action="adicionar_tag.php">
                                <input name="idfil" type="hidden" value="<?php echo $id; ?>">
                                <input name="diretor" type="text" class="searchbarblack" placeholder="Diretor ou ID do Diretor">
                                <input id="dir" type="submit" class="but" value="Adicionar" onclick="this.disabled=true;
                                    document.getElementById('tag').disabled=true;document.getElementById('retag').disabled=true;
                                    document.getElementById('redir').disabled=true;
                                    this.value='Aguarde...';this.form.submit();"
                                    style="text-align: center;font-size: 16px;margin-left: 10px;"/>
                            </form>
                            <form style="display: inline-block;" method="post" action="remover_tag.php">
                                <input name="idfil" type="hidden" value="<?php echo $id; ?>">
                                <input name="diretor" type="text" class="searchbarblack" placeholder="Diretor ou ID do Diretor">
                                <input id="redir" type="submit" class="butred" value="Remover" onclick="this.disabled=true;
                                    document.getElementById('tag').disabled=true;document.getElementById('dir').disabled=true;
                                    document.getElementById('retag').disabled=true;
                                    this.value='Aguarde...';this.form.submit();"
                                    style="text-align: center;font-size: 16px;margin-left: 10px;"/>
                            </form>
                            <h1>Adicionar Poster</h1>
                            <form style="margin-top: 20px;" method="post" action="adicionar_tag.php">
                                <input name="idfil" type="hidden" value="<?php echo $id; ?>">
                                <input name="poster" type="text" class="searchbarblack" placeholder="URL da Imagem" size="63">
                                <input id="poster" type="submit" class="but" value="Adicionar" onclick="this.disabled=true;
                                    document.getElementById('tag').disabled=true;document.getElementById('dir').disabled=true;
                                    document.getElementById('retag').disabled=true;document.getElementById('redir').disabled=true;
                                    this.value='Aguarde...';this.form.submit();"
                                    style="text-align: center;font-size: 16px;margin-left: 10px;"/>
                            </form>
                            <!-- DELETAR FILME -->
                            <div style="text-align: center; margin: 0px 0px 8px;">
                                <form id="remove" method="post" action="remover_filme.php">
                                    <input name="idfil" type="hidden" value="<?php echo $id; ?>">
                                    <input type="button" class="remover" value="Deletar Filme" onclick="this.disabled=true; remove();"
                                        style="text-align: center; font-size: 16px; margin-top: 10px;"/>
                                </form>
                            </div>
                            <script>
                                function remove() {
                                  if (confirm("Tem Certeza que Deseja Deletar este Filme?")) {
                                    document.getElementById("remove").submit();}else{location.reload();};
                                }
                            </script>
                        </div>
                    <?php }; ?>
                    
                    
                    <!-- ABAS -->
                    <div style="display: flex; justify-content: space-between; width: 600px; margin: 30px auto 0px;
                        align-items: center; font-size: 20px; margin-bottom: 30px;">
                        <a id="amg" class="link" href="filme.php?id=<?php echo $aka; ?>&p=amigos">Notas</a>
                        |<a id="sin" class="link" href="filme.php?id=<?php echo $aka; ?>&p=sinopses">Sinopses</a>
                        |<a id="ava" class="link" href="filme.php?id=<?php echo $aka; ?>&p=avaliacoes">Avaliações</a>
                    </div>


                    <!-- Amigos -->
                    <?php if($type == "amigos"){ if(isset($_SESSION['id_usuario'])){ ?>
                    <form method="get" style="text-align: center;" action="filme.php">
                        <input name="id" type="hidden" value="<?php echo $aka; ?>">
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
                        $pesq = " and (usuario like '%".mysqli_real_escape_string($mysqli, $_GET['pesquisa'])."%'"
                                . " or nota like '%".mysqli_real_escape_string($mysqli, $_GET['pesquisa'])."')";
                    }else{$pesq = "";}
                    
                    if(isset($_GET['ordem'])){
                    if($_GET['ordem']=="Z-A"){
                        $ordem = " order by usuario desc";
                    }elseif($_GET['ordem']=="1-5"){$ordem = " order by nota, usuario";
                    }elseif($_GET['ordem']=="5-1"){$ordem = " order by nota desc, usuario";
                    }else{$ordem = " order by usuario";}}else{$ordem = " order by usuario";}
                    
                    $query = "SELECT usuarios.usuario as 'usuario', usuarios.id_usuario as 'id',"
                            . " notas.nota as 'nota' FROM notas inner join usuarios on usuarios.id_usuario=notas.id_usuario"
                            . " inner join amizades on usuarios.id_usuario=amizades.id_amigo"
                            . " and amizades.id_usuario=$iduser where notas.id_filme=$id"
                            . $pesq . $ordem;
                    $result = mysqli_query($mysqli, $query);
                    $valid = mysqli_num_rows($result);
                    if($result&&$valid>=1){
                    while($row = mysqli_fetch_assoc($result)){
                        $amigo = $row['usuario'];
                        $id_amg = $row['id'];
                        $nota_amg = $row['nota'];
                        ?>
                    <div class="blockin" style="font-size: 20px; width: 550px; margin: auto; display: flex; margin-bottom: 16px;">
                        <div style="width: 70%;">
                            <a class="link" href="usuario.php?u=<?php echo $amigo; ?>"><?php echo $amigo; ?></a>
                        </div>
                        <div style="width: 30%; text-align: right;">
                            <?php echo "$nota_amg ★" ?>
                        </div>
                    </div>
                    <?php
                    }
                    }else{ ?>
                    <div style="text-align: center; font-size: 25px;">
                        -----------------------------------------------<br>
                        Você não segue ninguém que avaliou este filme.<br>
                        -----------------------------------------------
                    </div>
                    <?php }; ?>
                    <?php }else{ ?>
                    <div style="text-align: center; font-size: 25px;">
                        -----------------------------------------------<br>
                        Logue-se para seguir usuários.<br>
                        -----------------------------------------------
                    </div>
                    <?php };} ?>
                    
                    
                    
                    <!-- Sinopses -->
                    <?php if($type == "sinopses" || $type == "avaliacoes"){
                        if($type == "sinopses"){$sa=0;}else{$sa=1;}
                    ?>
                    <?php if(isset($iduser)){
                    $query = "select *, date_format(data, '%d/%m/%Y') as 'dat', TIME_FORMAT(hora, '%H:%i') as 'hor'"
                        . " from sinopses_avaliacoes where id_usuario=$iduser and id_filme=$id and s_a=$sa;";
                    $result = mysqli_query($mysqli, $query);
                    $valid = mysqli_num_rows($result);
                    $row = mysqli_fetch_assoc($result);
                    if($valid == 1 && !isset($_SESSION['edit'])){ ?>
                        <div class="blockin" style="margin: 0px auto 60px; width: 600px; padding: 15px 15px; font-size: 18px; text-align: left;">
                            <a style="font-size: 20px;"
                                class="tag" href="usuario.php?u=<?php echo $_SESSION['usuario']; ?>">
                                <?php echo $_SESSION['usuario']; ?></a>
                            <p style="margin: 20px 0px 20px;"><?php echo nl2br($row['conteudo']); ?></p>
                            <p>
                                <form method="post" action="adicionar_sa.php">
                                    <input name="sa" type="hidden" value="<?php echo $sa; ?>">
                                    <input name="idfil" type="hidden" value="<?php echo $id; ?>">
                                    <span style="font-size: 14px; opacity: 50%"><?php echo $row['dat']." - ".$row['hor']; ?></span>
                                    <div style="float: right">
                                        <input name="editar" class="seguindo" type="submit" value="Deletar">
                                        <input name="editar" class="adicionar" type="submit" value="Editar">
                                    </div>
                                </form>
                            </p>
                        </div>
                    <?php }else{ ?>
                    <div class="blockin" style="margin: 0px auto 60px; width: 600px; padding: 15px 15px; font-size: 18px; text-align: center;">
                        <form method="post" action="adicionar_sa.php">
                            <input name="sa" type="hidden" value="<?php echo $sa; ?>">
                            <input name="idfil" type="hidden" value="<?php echo $id; ?>">
                            <textarea name="content" maxlength="1100" placeholder="Escreva sua Sinopse aqui..." class="block" style="width: 570px;
                                    font-size: 20px; resize: none; border: none; outline: none; padding: 12px 15px;
                                    margin: 0px;" id="textarea" onkeypress="auto_grow(this)" onkeyup="auto_grow(this)"><?php
                                    if(isset($_SESSION['edit'])){
                                        echo $row['conteudo'];
                                        unset($_SESSION['edit']);
                                    }
                                    ?></textarea>
                            Sua Sinopse
                            <input type="submit" class="adicionar" value="Publicar" style="margin: 10px 3px 0px 0px;
                                    font-size: 16px;">
                        </form>
                    </div>
                    
                    <?php }} ?>
                    
                    <!-- PESQUISA E ORDEM SINOPSES OU AVALIAÇÕES -->
                    <form method="get" style="text-align: center; margin: 0px 0px 10px;" action="filme.php">
                        <input name="id" type="hidden" value="<?php echo $aka; ?>">
                        <input name="p" type="hidden" value="<?php echo $type; ?>">
                        <?php if(isset($_SESSION['id_usuario'])){ ?>
                        <div style="margin-bottom: 10px;">
                            <label style=""><input name="seguindo" type="checkbox" onchange="this.form.submit()" <?php 
                            if(isset($_GET['seguindo'])){echo "checked";} ?>> Mostrar apenas Perfis que você segue.</label>
                        </div>
                        <?php } ?>
                        <input class="searchbar" name="pesquisa" type="text" placeholder="Pesquisar" size="40" value="<?php if(isset($_GET['pesquisa'])){echo $_GET['pesquisa'];} ?>"
                               style="margin: 0px;">
                        <select class="searchbar" name="ordem" style="margin: 0px 0px 0px 10px;" onchange="this.form.submit()">
                            <option <?php if(isset($_GET['ordem'])&&$_GET['ordem']=="Maior Relevância"){echo "selected";} ?>>Maior Relevância</option>
                            <option <?php if(isset($_GET['ordem'])&&$_GET['ordem']=="Menor Relevância"){echo "selected";} ?>>Menor Relevância</option>
                            <option <?php if(isset($_GET['ordem'])&&$_GET['ordem']=="Usuario ↓"){echo "selected";} ?>>Usuario ↓</option>
                            <option <?php if(isset($_GET['ordem'])&&$_GET['ordem']=="Usuario ↑"){echo "selected";} ?>>Usuario ↑</option>
                            <option <?php if(isset($_GET['ordem'])&&$_GET['ordem']=="Mais Recente"){echo "selected";} ?>>Mais Recente</option>
                            <option <?php if(isset($_GET['ordem'])&&$_GET['ordem']=="Menos Recente"){echo "selected";} ?>>Menos Recente</option>
                        </select>
                    </form>
                    
                    <?php
                    
                    if(isset($_GET['pesquisa'])&&$_GET['pesquisa']!=""){
                        $p = mysqli_real_escape_string($mysqli, $_GET['pesquisa']);
                        $pesq = " and u.usuario like '%$p%' ";
                    }else{$pesq = " ";}
                    
                    if(isset($_GET['ordem'])){
                        if($_GET['ordem']=="Menor Relevância"){
                            $order = "relevancia, usuario";
                        }elseif($_GET['ordem']=="Usuario ↓"){
                            $order = "usuario, relevancia";
                        }elseif($_GET['ordem']=="Usuario ↑"){
                            $order = "usuario desc, relevancia";
                        }elseif($_GET['ordem']=="Mais Recente"){
                            $order = "a.data desc, a.hora desc, usuario";
                        }elseif($_GET['ordem']=="Menos Recente"){
                            $order = "a.data, a.hora, usuario";
                        }else{$order = "relevancia desc, usuario";}
                    }else{$order = "relevancia desc, usuario";}
                    $order = mysqli_real_escape_string($mysqli, $order);
                    
                    // SINOPSES DA COMUNIDADE
                    $query = "select a.id_sa as 'id_sa', a.conteudo as 'conteudo',"
                        . " a.id_usuario as 'id_usuario', a.id_filme as 'id_filme',"
                        . " a.s_a as 's_a', a.relevancia as 'relevancia',"
                        . " date_format(a.data, '%d/%m/%Y') as 'dat',"
                        . " TIME_FORMAT(a.hora, '%H:%i') as 'hor', u.usuario as 'usuario'"
                        . " from sinopses_avaliacoes as a inner join usuarios as u on a.id_usuario=u.id_usuario"
                        . " where a.id_filme=$id and a.s_a=$sa".$pesq."order by ".$order.";";
                    $result = mysqli_query($mysqli, $query);
                    $valid = mysqli_num_rows($result);
                    if($result&&$valid>=1){
                        while($row = mysqli_fetch_assoc($result)){ 
                            if((isset($_SESSION['id_usuario'])&&$row['id_usuario']!=$_SESSION['id_usuario'])||!isset($_SESSION['id_usuario'])){ 
                                $query = "select * from usuarios where id_usuario='{$row['id_usuario']}';";
                                $result2 = mysqli_query($mysqli, $query);
                                $rowuser = mysqli_fetch_assoc($result2); 
                                $print = 1;
                                if (isset($_GET['seguindo'])&&isset($_SESSION['id_usuario'])){
                                    $query = "select * from amizades where id_usuario={$_SESSION['id_usuario']}"
                                    . " and id_amigo={$rowuser['id_usuario']};";
                                    $result_seg = mysqli_query($mysqli, $query);
                                    $print = mysqli_num_rows($result_seg);
                                }
                                if ($print==1){ ?>
                            <div class="blockin" style="margin: 20px auto; width: 600px; padding: 15px 15px; font-size: 18px; text-align: left;">
                                <a style="font-size: 20px;"
                                    class="tag" href="usuario.php?u=<?php echo $rowuser['usuario']; ?>">
                                    <?php echo $rowuser['usuario']; ?></a>
                                <p style="margin: 20px 0px 20px;"><?php echo nl2br($row['conteudo']); ?></p>
                                <p>
                                    <form method="post" action="adicionar_sa.php">
                                        <input name="id_sa" type="hidden" value="<?php echo $row['id_sa']; ?>">
                                        <input name="id_usuario" type="hidden" value="<?php echo $rowuser['id_usuario']; ?>">
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
                                            
                                            if(isset($_SESSION['id_usuario'])){
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
                            <?php }}}
                    }else{?>
                    <div style="text-align: center; font-size: 25px;">
                        -----------------------------------------------<br>
                        Nenhum Resultado.<br>
                        -----------------------------------------------
                    </div>
                    <?php }
                    }; ?>
                    
                    
                    
                    <script type="text/javascript">
                        function auto_grow(element){
                            element.style.height = "5px";
                            element.style.height = (element.scrollHeight)+"px";
                        }
                    </script>
                </div>
            </div>
        </div>
        <!-- Rodapé -->
        <?php include "footer.php" ?> <!-- Rodapé da Página -->
        
        </div>
    </body>
</html>
