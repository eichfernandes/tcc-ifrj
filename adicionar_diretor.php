<title>Aguarde...</title>
<link href="style.css" rel="stylesheet">
<link rel="shortcut icon" href="icone.png" type="image/x-png">
<?php include "conexao.php"; session_start();
$diretor = mysqli_real_escape_string($mysqli,$_POST['diretor']);

if(empty($diretor)){
    $_SESSION['addir_erro']=true;
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
};

$query='insert into diretores (nome) values ("'.$diretor.'")';
$result = mysqli_query($mysqli, $query);
?><script>history.go(-1)</script><?php
exit();

