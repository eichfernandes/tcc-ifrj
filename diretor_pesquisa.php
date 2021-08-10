<?php
session_start();

$_SESSION['ordemdirfil']=$_POST['ordem'];
$_SESSION['pesquisadirfil']=$_POST['pesquisa'];

header('Location: ' . $_SERVER['HTTP_REFERER']);

