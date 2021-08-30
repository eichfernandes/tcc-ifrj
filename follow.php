<title>Aguarde...</title>
<link href="style.css" rel="stylesheet">
<link rel="shortcut icon" href="icone.png" type="image/x-png">
<?php 
session_start();
include "conexao.php";
if(empty($_POST['iduser'])||empty($_POST['follow'])||!isset($_SESSION['id_usuario'])){
    header('Location: index.php');
    exit();
}

$iduser = $_POST['iduser'];
$follow = $_POST['follow'];
$id = $_SESSION['id_usuario'];

if($follow=='a'){
    $query = "insert into amizades (id_usuario,id_amigo) values ('$id','$iduser');";
}else{$query = "delete from amizades where id_usuario='$id' and id_amigo='$iduser';";};
$result = mysqli_query($mysqli, $query);
?><script>history.go(-1)</script>