<?php
    define('HOST','localhost');
    define('USUARIO','root');
    define('SENHA','');
    define('BANCO','meindica_bd');
    
    /* Conexão */
    $mysqli = mysqli_connect(HOST,USUARIO,SENHA,BANCO) or die ('Erro ao Conectar ao Banco de Dados'); 
?>

