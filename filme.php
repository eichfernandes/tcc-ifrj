<?php include 'conexao.php';
session_set_cookie_params(3600*24*7);
session_start();
if (empty($_GET['id'])){header('Location: index.php'); exit();}

$id = $_GET['id'];
$query = "select * from filmes where id_filme=$id";

$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);

if(empty($row['titulo'])){header('Location: index.php');
    exit();};
        
$titulo = $row['titulo'];
$aka = $row['aka'];
$ano = $row['ano'];
$banner = $row['banner'];

$query = "select avg(notas.nota) as 'nota', count(notas.nota) as 'ava' from notas where notas.id_filme=$id";
$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);

$nota = number_format($row['nota'], 1, '.');
$ava = number_format($row['ava'], 0, '', '.');

$query = "SELECT diretores.nome as 'diretor', diretores.id_diretor as 'idir' FROM diretores, direcao where diretores.id_diretor=direcao.id_diretor and direcao.id_filme=$id";
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
                    <div style="display: flex;">
                        <?php if(empty($banner)){ ?>
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
                            
                            <h1 style="display: inline-block; padding: 0px 0px;<?php if(!isset($_SESSION['usuario'])){echo 'margin: 30px 0px 0px;';} ?>">
                                <?php echo $aka ?></h1>
                            
                            <p style="opacity: 75%; display: inline-block;"> (<?php echo $ano ?>)</p>
                            
                            <p style="opacity: 50%">
                                '<?php echo $titulo ?>'</p>
                            
                            <p style="margin-top: 20px;"><text style="opacity: 75%">Direção: </text>
                                <?php $y=1; while($y<=$x){ ?><a class="tag" href="diretor.php?id=<?php echo $idir[$y]; ?>">
                                    <?php echo $diretor[$y]; ?></a><?php $y=$y+1;}; ?>
                            </p>
                                
                            <p style="margin-top: 20px;">Tags: 
                                <a href="#" class="tag">exemplo</a>
                            
                            <h2 style="margin-top: 10px; display: inline-block;">Nota: <?php echo $nota; ?>★</h2>
                            <h3 style="margin: 0px 0px 0px 25px; display: inline-block;">Nº de Avaliadores: <?php echo $ava; ?></h3>
                            <?php if(isset($_SESSION['usuario'])){ ?>
                            <p style="margin-top: 5px"><text style="font-size: 25px;">Sua Nota: <text style="font-size: 27px;">
                                ★★★★★</text></text><text style="font-size: 12px;"> Remover Nota</text></p>
                            <?php }; ?>
                        </div>
                    </div>
                    <div class="blockin" style="display: box; margin-top: 20px;">
                        Futuro espaço para edição de Tags ou Diretores
                    </div>
                </div>
            </div>
        </div>
        <!-- Rodapé -->
        <?php include "footer.php" ?> <!-- Rodapé da Página -->
        
        </div>
    </body>
</html>
