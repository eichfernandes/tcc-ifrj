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
        <div style="min-height: 100vh;"><!-- Esta div está relacionada a tela e ajuda a ajustar as restantes -->
        
        <!-- Cabeçalho -->
        <?php include "header.php" ?> <!-- Cabeçalho da Página -->
        
        <!-- Conteúdo -->
        <div style="display: flex; justify-content: space-between; align-items: center; height: 100%;">
            <div class="content" style="width: 40%;"><!-- Define o que estará no conteúdo central -->
                <div class="block"><!-- Cada div block é um bloco de conteúdo -->
                    <form method="post">
                        <input class="searchbar" size="25" name="pesquisa" placeholder="Pesquisar"
                               value="<?php if(!empty($_POST['pesquisa'])){echo $_POST['pesquisa'];}; ?>">
                        <select name="ordem" style="float: right; padding: 7px 9px;" class="order" onchange="this.form.submit()">
                            <option <?php if(empty($_POST['ordem'])||$_POST['ordem']=='id_diretor'){echo "selected";}?> 
                                value="id_diretor">ID ↓</option>
                            <option <?php if(!empty($_POST['ordem'])&&$_POST['ordem']=='id_diretor desc'){echo "selected";}?>
                                value="id_diretor desc">ID ↑</option>
                            <option <?php if(!empty($_POST['ordem'])&&$_POST['ordem']=='nome'){echo "selected";}?>
                                value="nome">Nome ↓</option>
                            <option <?php if(!empty($_POST['ordem'])&&$_POST['ordem']=='nome desc'){echo "selected";}?>
                                value="nome desc">Nome ↑</option>
                        </select>
                    </form>
                    <div style="padding: 0px 12px 0px; font-size: 20px;">
                        Diretores
                        <div style="text-align: right; float: right;">IDs</div>
                    </div>
                    <?php include "conexao.php";
                        if (!empty($_POST['pesquisa'])){
                            $pesquisa=' where nome like "%'.$_POST['pesquisa'].'%"'
                                    . ' or id_diretor like "%'.$_POST['pesquisa'].'%"';
                        }else{$pesquisa='';};
                        
                        if (!empty($_POST['ordem'])){
                            $ordem=' order by '.$_POST['ordem'];
                        }else{$ordem=' order by id_diretor';};
                        

                        
                        $query = "select nome, id_diretor from diretores".$pesquisa.$ordem;
                        
                        $result = mysqli_query($mysqli, $query);
                        
                        if ($result){
                            while ($row = mysqli_fetch_assoc($result)){
                                $nome=$row['nome'];
                                $id=$row['id_diretor'];
                                echo '<div class="listclick">'.
                                    $nome.'<div style="float: right;">[ '.$id.' ]</div>'
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
