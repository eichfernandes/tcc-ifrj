<title>Aguarde...</title>
<link href="style.css" rel="stylesheet">
<link rel="shortcut icon" href="icone.png" type="image/x-png">
<?php include 'conexao.php'; session_start();

if(isset($_POST['aval'])){
    $iduser = $_SESSION['id_usuario'];
    $idsa = $_POST['id_sa'];
    if($_POST['aval']=='▲'){
        $aval = 1;
    }else{
        $aval = -1;
    }
    $query = "select avaliacao from avaliacoes_sa where id_sa=$idsa and id_usuario=$iduser;";
    $result = mysqli_query($mysqli, $query);
    $valid = mysqli_num_rows($result);
    if($valid >= 1){
        $row = mysqli_fetch_assoc($result);
        $oldaval = $row['avaliacao'];
        if($oldaval==$aval){
            $query = "delete from avaliacoes_sa where id_sa=$idsa and id_usuario=$iduser;";
        }else{$query = "update avaliacoes_sa set avaliacao=$aval where id_sa=$idsa and id_usuario=$iduser;";}
    }else{
        $query = "insert into avaliacoes_sa values ($idsa, $iduser, $aval);";
    }
    $result = mysqli_query($mysqli, $query);
    $query = "select sum(avaliacao) as aval from avaliacoes_sa where id_sa=$idsa;";
    $result = mysqli_query($mysqli, $query);
    $row = mysqli_fetch_assoc($result);
    $result = mysqli_query($mysqli, "update sinopses_avaliacoes set relevancia={$row['aval']} where id_sa=$idsa;");
    ?><script>history.go(-1)</script><?php
    exit();
}

if(isset($_POST['editar'])){
    if($_POST['editar']=='Editar'){
        $_SESSION['edit'] = 1;
        ?><script>history.go(-1)</script><?php
        exit();
    }
    if($_POST['editar']=='Deletar'){
        $sa = $_POST['sa'];
        $idfil = $_POST['idfil'];
        $query = "delete from sinopses_avaliacoes where id_usuario={$_SESSION['id_usuario']} and"
        . " id_filme=$idfil and s_a=$sa;";
        $result = mysqli_query($mysqli, $query);
        ?><script>history.go(-1)</script><?php
        exit();
    }
}

if(isset($_POST['sa'])||isset($_POST['content'])||$_POST['content']!=""){
    $sa = $_POST['sa'];
    $content = mysqli_real_escape_string($mysqli, $_POST['content']);
    $idfil = $_POST['idfil'];
    $query = "select * from sinopses_avaliacoes where id_usuario={$_SESSION['id_usuario']} and"
    . " id_filme=$idfil and s_a=$sa;";
    $result = mysqli_query($mysqli, $query);
    $valid = mysqli_num_rows($result);
    if ($valid >= 1){
        $query = "update sinopses_avaliacoes set conteudo='$content', data=now(), hora=now()"
                . " where id_usuario={$_SESSION['id_usuario']} and id_filme=$idfil and s_a=$sa;";
        $result = mysqli_query($mysqli, $query);
    }else{
        $query = "INSERT INTO sinopses_avaliacoes (conteudo, id_usuario, id_filme,"
            . " data, hora, s_a) VALUES"
            . " ('$content', {$_SESSION['id_usuario']}, $idfil, now(), now(), $sa)";
        $result = mysqli_query($mysqli, $query);
    }
    ?><script>history.go(-1)</script><?php
    exit();
}

header("Location: index.php");
exit();