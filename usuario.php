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

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Me Indica - <?php echo $row['usuario']; ?></title>
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
                    <div class="blockin" style="padding-bottom: 16px; display: flex;">
                        <div style="width: 80%;">
                            <h1 style="padding-bottom: 7px;"><?php echo $row['usuario']; ?></h1>
                            <h2 style="opacity: 60%;"><?php echo "'".$nome.' '.$sobrenome."'"; ?></h2>
                        </div>
                        <?php if(!$self&&isset($_SESSION['id_usuario'])){ ?>
                        <?php if(!$friend){ ?>
                        <div style="text-align: right; width: 20%; padding: 15px 20px 0px;">
                            <form id="adfollow" method="post" action="follow.php">
                                <input name="iduser" type="hidden" value="<?php echo $id; ?>">
                                <input name="follow" type="hidden" value="a">
                                <input type="button" class="adicionar" value="Seguir" onclick="this.disabled=true; adfollow();"
                                       style="font-size: 18px;"/>
                            </form>
                        </div>
                        <?php }else{ ?>
                        <div style="text-align: right; width: 20%; padding: 15px 20px 0px;">
                            <form id="stopfollow" method="post" action="follow.php">
                                <input name="iduser" type="hidden" value="<?php echo $id; ?>">
                                <input name="follow" type="hidden" value="r">
                                <input type="button" class="remover" value="Parar de Seguir" onclick="this.disabled=true; stopfollow();"
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
                </div>
                
                
                
                
                
                
            </div>
        </div>
        
        <!-- Rodapé -->
        <?php include "footer.php" ?> <!-- Rodapé da Página -->
        
        </div>
    </body>
</html>

