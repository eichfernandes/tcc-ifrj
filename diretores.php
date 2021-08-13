<?php session_start();
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
        
        <?php if (isset($_SESSION['adm'])&&$_SESSION['adm']==1){
            include "admin_diretores.php";
            exit();
        }; ?>
        
        <div class="semibody"><!-- Esta div está relacionada a tela e ajuda a ajustar as restantes -->
        
        <!-- Cabeçalho -->
        <?php include "header.php";
        
        if (!empty($_POST['ordem'])){
            $_SESSION['ordemdir']=$_POST['ordem'];
            $ordem=' order by '.$_SESSION['ordemdir'];
        }else if(isset($_SESSION['ordemdir'])){$ordem=' order by '.$_SESSION['ordemdir'];}
        else {$ordem=' order by id_diretor';};

        ?> <!-- Cabeçalho da Página -->
        
        <!-- Conteúdo -->
        <div style="display: flex; justify-content: space-between; align-items: center; height: 100%;">
            <div class="content" style="width: 650px;"><!-- Define o que estará no conteúdo central -->
                <div class="block"><!-- Cada div block é um bloco de conteúdo -->
                    <div style="padding: 0px 12px 16px;">
                        <h2>Lista de Diretores</h2>
                    </div>
                    <form method="post">
                        <input class="searchbar" size="25" name="pesquisa" placeholder="Pesquisar"
                               value="<?php if(!empty($_POST['pesquisa'])){echo $_POST['pesquisa'];}; ?>">
                        <select name="ordem" style="float: right; padding: 7px 9px;" class="order" onchange="this.form.submit()">
                            <option <?php if(!empty($_SESSION['ordemdir'])&&$_SESSION['ordemdir']=='nome'){echo "selected";}?>
                                value="nome">Crescente ↓</option>
                            <option <?php if(!empty($_SESSION['ordemdir'])&&$_SESSION['ordemdir']=='nome desc'){echo "selected";}?>
                                value="nome desc">Decrescente ↑</option>
                        </select>
                    </form>
                    <div style="padding: 0px 12px 0px; font-size: 20px;">
                        Diretores
                    </div>
                    <?php include "conexao.php";
                        if (!empty($_POST['pesquisa'])){
                            $pesquisa=' where nome like "%'.$_POST['pesquisa'].'%"'
                                    . ' or id_diretor like "%'.$_POST['pesquisa'].'%"';
                        }else{$pesquisa='';};
                        
                        $query = "select nome, id_diretor from diretores".$pesquisa.$ordem;
                        
                        $result = mysqli_query($mysqli, $query);
                        
                        if ($result){
                            while ($row = mysqli_fetch_assoc($result)){
                                $nome=$row['nome'];
                                $id=$row['id_diretor'];
                                echo '<form name="form'.$id.'" method="get" action="diretor.php">'.
                                    '<input name="id" type="hidden" value="'.$id.'">'.
                                    '<div class="listclick" onClick="document.forms.form'.$id.'.submit();">'.
                                    $nome.
                                    '</div></form>';
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
