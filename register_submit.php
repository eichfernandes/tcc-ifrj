<?php session_start();
include 'conexao.php';

if (empty($_POST['usuario'])||empty($_POST['nome'])||
empty($_POST['sobrenome'])||empty($_POST['senha'])||empty($_POST['senha2']))/* Validação Espaços Vazios */
{
    $_SESSION['vazio']=true;
    header("Location: register.php");
    exit();
} else {
    $usuario = mysqli_real_escape_string($mysqli, $_POST['usuario']);
    
    $query = "select id_usuario from usuarios where usuario = '{$usuario}'";
    
    $result = mysqli_query($mysqli, $query);
    $valid = mysqli_num_rows($result);
    
    if ($valid==1){
        $_SESSION['repetido']=true;
        header("Location: register.php");
        exit();
    };
    if ($_POST['senha']!=$_POST['senha2']){
        $_SESSION['erroSenha']=true;
        header("Location: register.php");
        exit();
    };
};

$nome= mysqli_real_escape_string($mysqli, $_POST['nome']);
$sobrenome= mysqli_real_escape_string($mysqli, $_POST['sobrenome']);
$senha= mysqli_real_escape_string($mysqli, $_POST['senha']);

$query = "insert into usuarios (usuario, nome, sobrenome, senha) values ('{$usuario}','{$nome}','{$sobrenome}',md5('{$senha}'))";
$result = mysqli_query($mysqli, $query);

$_SESSION['usuario']=$usuario;
$_SESSION['nome']=$nome;
$_SESSION['sobrenome']=$sobrenome;
$_SESSION['adm']=0;

header("Location: index.php");
exit();
