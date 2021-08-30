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


?>
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
                        <div style="margin: 0px 0px 0px 20px; width: 100%;" class="blockin">
                            <!-- TITULO -->
                            <h1 style="display: inline-block; padding: 0px 0px;<?php if(!isset($_SESSION['usuario'])){echo 'margin: 30px 0px 0px;';} ?>">
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
                            <h2 style="margin-top: 10px; display: inline-block;">Nota: <?php echo $nota; ?>★</h2>
                            <h3 style="margin: 0px 0px 0px 25px; display: inline-block;">Nº de Avaliadores: <?php echo $ava; ?></h3>
                            <?php if(isset($_SESSION['usuario'])){ ?>
                            <p style="margin-top: 5px"><text style="font-size: 25px;">Sua Nota: <text style="font-size: 27px;">
                                <?php include "stars.php"; ?></text></text></p>
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
                </div>
            </div>
        </div>
        <!-- Rodapé -->
        <?php include "footer.php" ?> <!-- Rodapé da Página -->
        
        </div>
    </body>
</html>
