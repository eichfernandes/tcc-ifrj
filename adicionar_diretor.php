<?php include "conexao.php";
$diretor = mysqli_real_escape_string($mysqli,$_POST['diretor']);

if(empty($diretor)){
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
};

$query='insert into diretores (nome) values ("'.$diretor.'")';
$result = mysqli_query($mysqli, $query);

exit();

