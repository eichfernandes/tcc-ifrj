<?php session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Me Indica - Diretores</title>
        <link href="style.css" rel="stylesheet">
        <link rel="shortcut icon" href="icone.png" type="image/x-png">
    </head>
    <body>
        
        
        <div class="semibody"><!-- Esta div está relacionada a tela e ajuda a ajustar as restantes -->
        
        <!-- Cabeçalho -->
        <?php include "header.php";
        

        ?> <!-- Cabeçalho da Página -->
        
        <!-- Conteúdo -->
        <div style="display: flex; justify-content: space-between; align-items: center; height: 100%;">
            <div class="content" style="width: 650px;"><!-- Define o que estará no conteúdo central -->
                
                <!-- ERROS -->
                <?php if(isset($_SESSION['addir_erro'])): ?>
                    <div class="block" style="text-align: center; padding: 20px 30px 30px 30px; background-color: #771122;">
                        Erro de Adição<br>Digite um Nome para Adicionar
                    </div>
                <?php endif; unset($_SESSION['addir_erro']); ?>
                
                <div class="block"><!-- Cada div block é um bloco de conteúdo -->
                    <?php if (isset($_SESSION['adm'])&&$_SESSION['adm']==1){ ?>
                        <div style="padding: 0px 12px 10px;">
                            <h2>Adicionar Diretor</h2>
                        </div>
                        <form method="post" action="adicionar_diretor.php">
                            <input class="searchbar" size="25" name="diretor" placeholder="Nome do Diretor" style="margin: 0px 12px 30px 0px" maxlength="50">
                            <input type="submit" class="but" value="Adicionar" onclick="this.disabled=true;this.value='Aguarde...';this.form.submit();"
                                style="text-align: center;font-size: 16px; margin-top: 10px;"/>
                        </form>
                    <?php }; ?>
                    
                    <div style="padding: 0px 12px 16px;">
                        <h2>Lista de Diretores</h2>
                    </div>
                    
                    <form method="post" action="diretores_pesquisa.php">
                        <input class="searchbar" size="25" name="pesquisa" placeholder="Pesquisar"
                               value="<?php if(!empty($_SESSION['pesquisadir'])){echo $_SESSION['pesquisadir'];}; ?>">
                        <select name="ordem" style="float: right; padding: 7px 9px;" class="order" onchange="this.form.submit()">
                            <option <?php if((!empty($_SESSION['ordemdir'])&&$_SESSION['ordemdir']=='nome')||empty($_SESSION['ordemdir'])){echo "selected";}?>
                                value="nome">Nome ↓</option>
                            <option <?php if(!empty($_SESSION['ordemdir'])&&$_SESSION['ordemdir']=='nome desc'){echo "selected";}?>
                                value="nome desc">Nome ↑</option>
                            <?php if (isset($_SESSION['adm'])&&$_SESSION['adm']==1){ ?>
                                <option <?php if(!empty($_SESSION['ordemdir'])&&$_SESSION['ordemdir']=='id_diretor'){echo "selected";}?> 
                                    value="id_diretor">ID ↓</option>
                                <option <?php if(!empty($_SESSION['ordemdir'])&&$_SESSION['ordemdir']=='id_diretor desc'){echo "selected";}?>
                                    value="id_diretor desc">ID ↑</option>
                            <?php }; ?>
                        </select>
                    </form>
                    <div style="padding: 0px 12px 0px; font-size: 20px;">
                        Diretores
                    </div>
                    <?php include "conexao.php";
                        if (!empty($_SESSION['pesquisadir'])){
                            $pesquisa=' where nome like "%'.$_SESSION['pesquisadir'].'%"'
                                    . ' or id_diretor like "%'.$_SESSION['pesquisadir'].'%"';
                        }else{$pesquisa='';};
                        
                        unset($_SESSION['pesquisadir']);
                        
                        if(isset($_SESSION['ordemdir'])){
                            $ordem = " order by " . $_SESSION['ordemdir'];
                        }else{$ordem = " order by nome";};
                        
                        $query = "select nome, id_diretor from diretores".$pesquisa.$ordem;
                        
                        $result = mysqli_query($mysqli, $query);
                        
                        if ($result){
                            while ($row = mysqli_fetch_assoc($result)){
                                $nome=$row['nome'];
                                $id=$row['id_diretor'];
                                echo '<form name="form'.$id.'" method="get" action="diretor.php">'.
                                    '<input name="id" type="hidden" value="'.$id.'">'.
                                    '<div class="listclick" onClick="document.forms.form'.$id.'.submit();">'.
                                    $nome;
                                if (isset($_SESSION['adm'])&&$_SESSION['adm']==1){echo '<div style="float: right;">[ '.$id.' ]</div>';};
                                echo '</div></form>';
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
