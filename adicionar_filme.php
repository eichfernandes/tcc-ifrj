<?php include "conexao.php";
$idir =  "'".$_POST['idir']."'";
$titulo = "'".$_POST['titulo']."'";
$aka = "'".$_POST['aka']."'";
$ano = "'".$_POST['ano']."'";

if(empty($titulo)||empty($ano)){
    header('Location: ' . $_SERVER['HTTP_REFERER']);
};

if(empty($_POST['aka'])){
    $aka="null";
};

$query='insert into filmes (titulo,aka,ano) values ('.$titulo.','.$aka.','.$ano.')';
$result = mysqli_query($mysqli, $query);

$query='select id_filme from filmes where titulo='.$titulo.' and aka='.$aka.' and ano='.$ano;
$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);
$idfil = "'".$row['id_filme']."'";

$query='insert into direcao (id_diretor,id_filme) values ('.$idir.','.$idfil.')';
$result = mysqli_query($mysqli, $query);

header('Location: ' . $_SERVER['HTTP_REFERER']);

