<title>Aguarde...</title>
<link href="style.css" rel="stylesheet">
<link rel="shortcut icon" href="icone.png" type="image/x-png">
<?php session_start(); include "conexao.php";

if(empty($_POST['nota'])||empty($_POST['idfil'])||!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
    exit();
};

$nota = $_POST['nota']; $iduser = $_SESSION['id_usuario']; $idfil = $_POST['idfil'];

$query = "select * from notas where id_usuario=$iduser and id_filme=$idfil";
$result = mysqli_query($mysqli, $query);
$valid = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);

if($valid==1){
    if($row['nota']==$nota){
        $query = "delete from notas where id_usuario=$iduser and id_filme=$idfil";
        $result = mysqli_query($mysqli, $query);
    }else{
        $query = "update notas set nota=$nota where id_usuario=$iduser and id_filme=$idfil";
        $result = mysqli_query($mysqli, $query);
    }
}else{
    $query = "insert into notas (nota,id_usuario,id_filme) values ($nota,$iduser,$idfil)";
    $result = mysqli_query($mysqli, $query);
};

$result = mysqli_query($mysqli, 'select avg(nota) as "notmed" from notas where id_filme='.$idfil);
$row = mysqli_fetch_assoc($result);
$notmed = $row['notmed'];

$query = "update filmes set nota_media=$notmed where id_filme=$idfil";
$result = mysqli_query($mysqli, $query);
?><script>history.go(-1)</script>