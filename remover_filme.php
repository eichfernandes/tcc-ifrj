<title>Aguarde...</title>
<link href="style.css" rel="stylesheet">
<link rel="shortcut icon" href="icone.png" type="image/x-png">
<?php include 'conexao.php';

$idfil = $_POST['idfil'];

$query2 = "delete from direcao where id_filme=$idfil";
$result2 = mysqli_query($mysqli, $query2);
$query2 = "delete from classificacoes where id_filme=$idfil";
$result2 = mysqli_query($mysqli, $query2);
$query2 = "delete from filmes where id_filme=$idfil";
$result2 = mysqli_query($mysqli, $query2);
$query2 = "delete from notas where id_filme=$idfil";
$result2 = mysqli_query($mysqli, $query2);
$query2 = "select * from sinopses_avaliacoes where id_filme=$idfil;";
$result2 = mysqli_query($mysqli, $query2);
if ($result2){
    while ($row = mysqli_fetch_assoc($result2)){
        $idsa = $row['id_sa'];
        $query3 = "delete from comentarios where id_sa=$idsa;";
        $result3 = mysqli_query($mysqli, $query3);
    };
};
$query2 = "delete from sinopses_avaliacoes where id_filme=$idfil;";
$result2 = mysqli_query($mysqli, $query2);
?><script>history.go(-2)</script><?php
exit();
