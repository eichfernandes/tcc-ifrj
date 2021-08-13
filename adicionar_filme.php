<?php include "conexao.php"; session_start();
$idir =  mysqli_real_escape_string($mysqli,$_POST['idir']);
$titulo = mysqli_real_escape_string($mysqli,$_POST['titulo']);
$aka = mysqli_real_escape_string($mysqli,$_POST['aka']);
$ano = mysqli_real_escape_string($mysqli,$_POST['ano']);

if(empty($titulo)||empty($ano)||empty($aka)){
    $_SESSION['addir_erro']=true;
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
};


$query='insert into filmes (titulo,aka,ano) values ("'.$titulo.'","'.$aka.'","'.$ano.'")';
$result = mysqli_query($mysqli, $query);

$query='select id_filme from filmes where titulo="'.$titulo.'" and aka="'.$aka.'" and ano="'.$ano.'" ';
$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);
$idfil = "'".$row['id_filme']."'";

$query='insert into direcao (id_diretor,id_filme) values ('.$idir.','.$idfil.')';
$result = mysqli_query($mysqli, $query);

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();

