<?php include "conexao.php";
session_set_cookie_params(3600*24*7);
session_start();
if(isset($_SESSION['id_usuario'])){
    $idme = $_SESSION['id_usuario'];
}else{
    header('Location: index.php');
    exit();
};

if(!empty($_GET['p'])){
    $type = $_GET['p'];
    if($type != 'seguindo'&&$type != 'seguindo de volta'&&$type != 'buscar perfis'){
        header('Location: index.php');
        exit();
    };
}else{
    header('Location: index.php');
    exit();
};
$idme = $_SESSION['id_usuario'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Me Indica - Avaliação de Filmes</title>
        <link href="style.css" rel="stylesheet">
        <link rel="shortcut icon" href="icone.png" type="image/x-png">
    </head>
    <body>
        <div class="semibody"><!-- Esta div está relacionada a tela e ajuda a ajustar as restantes -->
        
        <!-- Cabeçalho -->
        <?php include "header.php" ?> <!-- Cabeçalho da Página -->
        
        <!-- Conteúdo -->
        <div style="display: flex; justify-content: space-between; align-items: center; height: 100%;">
            <div class="content" style="width: 800px;"><!-- Define o que estará no conteúdo central -->
                <div class="block"><!-- Cada div block é um bloco de conteúdo -->
                    <div style="display: flex; justify-content: space-between; width: 600px;
                        align-items: center; font-size: 20px; margin: auto;">
                        <a class="link" href="amigos.php?p=seguindo">Seguindo</a>
                        |<a class="link" href="amigos.php?p=seguindo de volta">Seguindo de Volta</a>
                        |<a class="link" href="amigos.php?p=buscar perfis">Buscar Perfis</a>
                    </div>
                    
                    <!-- Seguindo -->
                    <?php if($type == "seguindo"){ ?>
                    Em Desenvolvimento
                    <!-- SELECT a.usuario as 'usuario' from amizades inner join usuarios as a on amizades.id_amigo=a.id_usuario where amizades.id_usuario=6 -->
                    <?php }; ?>
                    
                    <!-- Seguindo de Volta -->
                    <?php if($type == "seguindo de volta"){ ?>
                    Em Desenvolvimento
                    <?php }; ?>
                    
                    <!-- Buscar Perfis -->
                    <?php if($type == "buscar perfis"){ ?>
                    <form method="get" style="margin-top: 30px;text-align: center;">
                        <input name="p" type="hidden" value="<?php echo $type; ?>">
                        <input class="searchbar" name="pesquisa" type="text" placeholder="Pesquisar" size="40" value="<?php if(isset($_GET['pesquisa'])){echo $_GET['pesquisa'];} ?>">
                        <select class="searchbar" name="ordem" style="margin-left: 10px;" onchange="this.form.submit()">
                            <option <?php if(isset($_GET['ordem'])&&$_GET['ordem']=="A-Z"){echo "selected";} ?>>A-Z</option>
                            <option <?php if(isset($_GET['ordem'])&&$_GET['ordem']=="Z-A"){echo "selected";} ?>>Z-A</option>
                        </select>
                    </form>
                    <?php
                    if(isset($_GET['pesquisa'])&&$_GET['pesquisa']!=""){
                        if(isset($_GET['ordem'])&&($_GET['ordem']=="A-Z"||$_GET['ordem']=="Z-A")){
                            $pesq = mysqli_real_escape_string($mysqli, $_GET['pesquisa']);
                            if($_GET['ordem']=="A-Z"){
                                $ordem = " order by usuario";
                            }else{$ordem = " order by usuario desc";}
                            $result = mysqli_query($mysqli, "select * from usuarios where usuario like '%$pesq%'".$ordem." limit 500;");
                            if($result){
                                while($row = mysqli_fetch_assoc($result)){
                                    $user = $row['usuario'];
                                    $id = $row['id_usuario'];
                                    $result2 = mysqli_query($mysqli, "select * from amizades where"
                                        . " amizades.id_usuario='$idme' and amizades.id_amigo='$id';");
                                    $foll = mysqli_num_rows($result2)
                                ?>
                    <div class="blockin" style="font-size: 20px; width: 500px; margin: auto; display: flex; margin-bottom: 16px;">
                        <did style="width: 70%;">
                            <a class="link" href="usuario.php?u=<?php echo $user; ?>">
                            <?php echo $user; ?></a></did>
                        <?php if($foll==0){ ?>
                        <div style="text-align: right; width: 30%; padding: 0px;">
                            <form id="adfollow" method="post" action="follow.php">
                                <input name="iduser" type="hidden" value="<?php echo $id; ?>">
                                <input name="follow" type="hidden" value="a">
                                <input type="button" class="adicionar" value="Seguir" onclick="this.disabled=true; this.form.submit();"
                                       style="font-size: 18px;"/>
                            </form>
                        </div>
                        <?php }else{ ?>
                        <div style="text-align: right; width: 30%; padding: 0px;">
                            <form id="stopfollow" method="post" action="follow.php">
                                <input name="iduser" type="hidden" value="<?php echo $id; ?>">
                                <input name="follow" type="hidden" value="r">
                                <input type="button" class="remover" value="Desseguir" onclick="this.disabled=true; this.form.submit();"
                                       style="font-size: 18px;"/>
                            </form>
                        </div>
                        <?php }; ?>
                    </div>
                                <?php
                                };
                            };
                        };
                    };
                    ?>
                    <?php }; ?>
                </div>
            </div>
        </div>
        <!-- Rodapé -->
        <?php include "footer.php" ?> <!-- Rodapé da Página -->
        
        </div>
    </body>
</html>