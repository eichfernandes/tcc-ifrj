<title>Aguarde...</title>
<link href="style.css" rel="stylesheet">
<link rel="shortcut icon" href="icone.png" type="image/x-png">
<?php include "conexao.php"; session_start();

$idfil = $_POST['idfil'];


if (!empty($_POST['tag'])){
    $tag = mysqli_real_escape_string($mysqli, $_POST['tag']);
    $query = "select * from tags where id_tag='$tag' or tag='$tag'";
    $result = mysqli_query($mysqli, $query);
    $row = mysqli_fetch_assoc($result);
    $valid = mysqli_num_rows($result);
    if($valid==1){
        $id = $row['id_tag'];
        $query = "delete from classificacoes where id_filme=$idfil and id_tag=$id";
        $result = mysqli_query($mysqli, $query);
        ?><script>history.go(-1)</script><?php exit();
    }else{$_SESSION['retag_erro']=true;};
};

if (!empty($_POST['diretor'])){
    $diretor = mysqli_real_escape_string($mysqli, $_POST['diretor']);
    $query = "select * from diretores where id_diretor='$diretor' or nome='$diretor'";
    $result = mysqli_query($mysqli, $query);
    $row = mysqli_fetch_assoc($result);
    $valid = mysqli_num_rows($result);
    if($valid==1){
        $id = $row['id_diretor'];
        $query = "delete from diretores where id_filme=$idfil and id_diretor=$id";
        $result = mysqli_query($mysqli, $query);
        ?><script>history.go(-1)</script><?php exit();
    }else{$_SESSION['redir_erro']=true;};
};

?><script>history.go(-1)</script><?php
exit();