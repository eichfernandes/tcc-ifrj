<title>Aguarde...</title>
<link href="style.css" rel="stylesheet">
<link rel="shortcut icon" href="icone.png" type="image/x-png">
<?php
session_start();

if(empty($_POST['ordem'])&&empty($_POST['pesquisa'])){
    header('Location: index.php');
    exit();
};

$_SESSION['ordemdir']=$_POST['ordem'];
$_SESSION['pesquisadir']=$_POST['pesquisa'];

?><script>history.go(-1)</script><?php
exit();
