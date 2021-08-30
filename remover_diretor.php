<title>Aguarde...</title>
<link href="style.css" rel="stylesheet">
<link rel="shortcut icon" href="icone.png" type="image/x-png">
<?php include "conexao.php";

if(empty($_POST['idir'])){
    header('Location: index.php');
    exit();
};

$idir = $_POST['idir'];

$query = "SELECT filmes.id_filme as 'idfil' FROM filmes, direcao WHERE direcao.id_diretor=$idir and direcao.id_filme=filmes.id_filme";
$result = mysqli_query($mysqli, $query);
if ($result){
    while ($row = mysqli_fetch_assoc($result)){
        $idfil = $row['idfil'];
        echo $idfil;
        $query2 = "delete from direcao where id_filme=$idfil";
        $result2 = mysqli_query($mysqli, $query2);
        $query2 = "delete from classificacoes where id_filme=$idfil";
        $result2 = mysqli_query($mysqli, $query2);
        $query2 = "delete from filmes where id_filme=$idfil";
        $result2 = mysqli_query($mysqli, $query2);
        $query2 = "delete from notas where id_filme=$idfil";
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
    };
};

$query = "delete from direcao where id_diretor=$idir";
$result = mysqli_query($mysqli, $query);
$query = "delete from diretores where id_diretor=$idir";
$result = mysqli_query($mysqli, $query);
header('Location: diretores.php');
exit();
?>
