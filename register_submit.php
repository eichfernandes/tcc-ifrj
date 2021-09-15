<title>Aguarde...</title>
<link href="style.css" rel="stylesheet">
<link rel="shortcut icon" href="icone.png" type="image/x-png">
<?php session_start();
include 'conexao.php';

if (empty($_POST['usuario'])||empty($_POST['nome'])||
empty($_POST['sobrenome'])||empty($_POST['senha'])||empty($_POST['senha2']))/* Validação Espaços Vazios */
{
    $_SESSION['vazio']=true;
    ?><script>history.go(-1)</script><?php
    exit();
} else {
    $usuario = mysqli_real_escape_string($mysqli, $_POST['usuario']);
    
    $query = "select id_usuario from usuarios where usuario = '{$usuario}'";
    
    $result = mysqli_query($mysqli, $query);
    $valid = mysqli_num_rows($result);
    
    if ($valid==1){
        $_SESSION['repetido']=true;
        ?><script>history.go(-1)</script><?php
        exit();
    };
    if (strpos($usuario, ' ')){
        $_SESSION['space']=true;
        ?><script>history.go(-1)</script><?php
        exit();
    };
    if ($_POST['senha']!=$_POST['senha2']){
        $_SESSION['erroSenha']=true;
        ?><script>history.go(-1)</script><?php
        exit();
    };
};

$nome= mysqli_real_escape_string($mysqli, $_POST['nome']);
$sobrenome= mysqli_real_escape_string($mysqli, $_POST['sobrenome']);
$senha= mysqli_real_escape_string($mysqli, $_POST['senha']);

$query = "insert into usuarios (usuario, nome, sobrenome, senha) values ('{$usuario}','{$nome}','{$sobrenome}',md5('{$senha}'))";
$result = mysqli_query($mysqli, $query);

$query = "select * from usuarios where usuario='$usuario'";
$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);

$_SESSION['usuario']=$usuario;
$_SESSION['nome']=$nome;
$_SESSION['sobrenome']=$sobrenome;
$_SESSION['adm']=0;
$_SESSION['id_usuario']=$row['id_usuario'];

header("Location: index.php");
exit();

