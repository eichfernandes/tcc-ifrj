<?php
    define('HOST','remotemysql.com');
    define('USUARIO','1sdukLlAib');
    define('SENHA','1GJEWG9Fjw');
    define('BANCO','1sdukLlAib');
    
    /* Conexão */
    $mysqli = mysqli_connect(HOST,USUARIO,SENHA,BANCO) or die ('Erro ao Conectar ao Banco de Dados'); 
?>

