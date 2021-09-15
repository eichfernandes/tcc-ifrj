<title>Aguarde...</title>
<link href="style.css" rel="stylesheet">
<link rel="shortcut icon" href="icone.png" type="image/x-png">
<?php
    session_start();
    include 'conexao.php';
    
    if (empty($_POST['usuario'])||empty($_POST['senha'])){
        header('Location: login.php');
        exit();
    }
    
    $usuario = mysqli_real_escape_string($mysqli, $_POST['usuario']);
    $senha = mysqli_real_escape_string($mysqli, $_POST['senha']);
    
    $query = "select * from usuarios where usuario = '{$usuario}' and senha = md5('{$senha}')";
    
    $result = mysqli_query($mysqli, $query);
    
    $valid = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    
    
    if ($valid==1){
        $_SESSION['usuario']=$usuario;
        $_SESSION['nome']=$row['nome'];
        $_SESSION['sobrenome']=$row['sobrenome'];
        $_SESSION['adm']=$row['adm'];
        $_SESSION['id_usuario']=$row['id_usuario'];
        header('Location: index.php');
        
    }
    else{
        $_SESSION['login_error']=true;
        ?><script>history.go(-1)</script><?php
    };
?>
