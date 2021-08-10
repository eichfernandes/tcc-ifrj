<?php
    define('HOST','remotemysql.com');
    define('USUARIO','2ILiGf97ER');
    define('SENHA','ZtgJFKb7N5');
    define('BANCO','2ILiGf97ER');
    
    /* Conexão */
    $mysqli = mysqli_connect(HOST,USUARIO,SENHA,BANCO) or die ('Erro ao Conectar ao Banco de Dados'); 
?>

