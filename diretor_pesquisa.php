<?php
session_start();

if(empty($_POST['ordem'])&&empty($_POST['pesquisa'])){
    header('Location: index.php');
    exit();
};

$_SESSION['ordemdirfil']=$_POST['ordem'];
$_SESSION['pesquisadirfil']=$_POST['pesquisa'];

header('Location: ' . $_SERVER['HTTP_REFERER']);

