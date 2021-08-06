<?php include "conexao.php";
$idir =  mysqli_real_escape_string($mysqli,$_POST['idir']);
$titulo = mysqli_real_escape_string($mysqli,$_POST['titulo']);
$aka = mysqli_real_escape_string($mysqli,$_POST['aka']);
$ano = mysqli_real_escape_string($mysqli,$_POST['ano']);

if(empty($titulo)||empty($ano)){
    header('Location: ' . $_SERVER['HTTP_REFERER']);
};

if(empty($_POST['aka'])){
    $aka="null";
};

$query='insert into filmes (titulo,aka,ano) values ("'.$titulo.'","'.$aka.'","'.$ano.'")';
$result = mysqli_query($mysqli, $query);

$query='select id_filme from filmes where titulo="'.$titulo.'" and aka="'.$aka.'" and ano="'.$ano.'" ';
$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);
$idfil = "'".$row['id_filme']."'";

$query='insert into direcao (id_diretor,id_filme) values ('.$idir.','.$idfil.')';
$result = mysqli_query($mysqli, $query);

if(!empty($_POST['dir2'])){
    $dir2 = $_POST['dir2'];
    $query='insert into direcao (id_diretor,id_filme) values ('.$dir2.','.$idfil.')';
    $result = mysqli_query($mysqli, $query);
};

if(!empty($_POST['dir3'])){
    $dir3 = $_POST['dir3'];
    $query='insert into direcao (id_diretor,id_filme) values ('.$dir3.','.$idfil.')';
    $result = mysqli_query($mysqli, $query);
};

if(!empty($_POST['dir4'])){
    $dir4 = $_POST['dir4'];
    $query='insert into direcao (id_diretor,id_filme) values ('.$dir4.','.$idfil.')';
    $result = mysqli_query($mysqli, $query);
};

header('Location: ' . $_SERVER['HTTP_REFERER']);

