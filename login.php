<?php
session_start();
if (isset($_SESSION['usuario'])){
    header('Location: index.php');
    exit();
};
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Me Indica - Login</title>
        <link href="style.css" rel="stylesheet">
        <link rel="shortcut icon" href="icone.png" type="image/x-png">
    </head>
    <body>
        <script>
            function mostrarSenha(){
                var senha=document.getElementById('senha');
                if (senha.type=='password'){
                    senha.type='text';
                } else {
                    senha.type='password';
                }
            }
        </script>
        <div class="content" style="width: 400px; margin-top: 10%;">
            <div class="block" style="text-align: center; padding-bottom: 50px;">
                <h1>Fazer Login</h1><br>
                <form method="post" action="login_submit.php">
                    
                    <!-- USUÁRIO -->
                    <input style="margin-bottom: 20px; padding: 7px 14px; border: 1px solid rgb(255, 255, 255, 0.2); border-radius: 5px; 
                           background-color: rgb(52, 53, 58, 1); outline: none; font-size: 18px;"
                           type="text" placeholder="Usuário" size="20" name="usuario">
                    
                    <!-- SENHA -->
                    <input style="padding: 7px 14px; border: 1px solid rgb(255, 255, 255, 0.2); border-radius: 5px; 
                           background-color: rgb(52, 53, 58, 1); outline: none; font-size: 18px;"
                           type="password" placeholder="Senha" size="20" name="senha" id="senha">
                    <div style="margin: 14px auto;">
                        <input class="check" type="checkbox" onclick="mostrarSenha()"> Mostrar Senha
                    </div>
                    
                    <!-- BOTÃO ENVIAR -->
                    <button style="font-size: 18px;" class="but" type="submit"
                            onclick="this.disabled=true;this.value='Enviando, Aguarde...';this.form.submit();">Entrar</button>
                    
                </form>
            </div>
            
            <?php if(isset($_SESSION['login_error'])): ?>
                <div class="block" style="text-align: center; padding: 20px 30px 30px 30px; background-color: #771122;">
                    Erro de Login<br>Usuário ou Senha Incorretos
                </div>
            <?php endif; unset($_SESSION['login_error']); ?>
            
        </div>
    </body>
</html>
