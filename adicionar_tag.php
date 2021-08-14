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
        $query = "insert into classificacoes (id_tag,id_filme) values ($id,$idfil)";
        $result = mysqli_query($mysqli, $query);
        ?><script>history.go(-1)</script><?php exit();
    }else{$_SESSION['adtag_erro']=true;};
};

if (!empty($_POST['diretor'])){
    $diretor = mysqli_real_escape_string($mysqli, $_POST['diretor']);
    $query = "select * from diretores where id_diretor='$diretor' or nome='$diretor'";
    $result = mysqli_query($mysqli, $query);
    $row = mysqli_fetch_assoc($result);
    $valid = mysqli_num_rows($result);
    if($valid==1){
        $id = $row['id_diretor'];
        $query = "insert into direcao (id_diretor,id_filme) values ($id,$idfil)";
        $result = mysqli_query($mysqli, $query);
        ?><script>history.go(-1)</script><?php exit();
    }else{$_SESSION['addir_erro']=true;};
};

?><script>history.go(-1)</script><?php
exit();