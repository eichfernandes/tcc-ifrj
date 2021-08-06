<?php session_start();
if (isset($_SESSION['usuario'])){
    header('Location: index.php');
    exit();
}; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TCC - Registro</title>
        <link href="style.css" rel="stylesheet">
        <link rel="shortcut icon" href="icone.png" type="image/x-png">
    </head>
    <body>
        <div class="content" style="width: 660px; margin-top: 4%;">
            <div class="block" style="text-align: center; padding-bottom: 50px;">
                <form method="post" action="register_submit.php">
                    <h1>Registrar Conta</h1>

                    <!-- Nome de Usuário -->
                    <h2 style="margin: 14px 0px;">Usuário</h2>
                    <input style="padding: 7px 14px; font-size: 18px; border: 1px solid rgb(255, 255, 255, 0.2); border-radius: 5px; 
                           background-color: rgb(52, 53, 58, 1); outline: none;" maxlength="25"
                           type="text" name="usuario" class="reg_user" placeholder="Nome de Usuário para Login" size="40">

                    <!-- Nome -->
                    <h2 style="margin: 14px 0px;">Nome</h2>
                    <input style="margin: 0px 0px 14px 0px; padding: 7px 14px; font-size: 18px; border: 1px solid rgb(255, 255, 255, 0.2); border-radius: 5px; 
                           background-color: rgb(52, 53, 58, 1); outline: none;" maxlength="40"
                           type="text" name="nome" class="reg_user" placeholder="Seu Nome Real" size="40">

                    <!-- Sobrenome -->
                    <input style="padding: 7px 14px; font-size: 18px; border: 1px solid rgb(255, 255, 255, 0.2); border-radius: 5px; 
                           background-color: rgb(52, 53, 58, 1); outline: none;" maxlength="80"
                           type="text" name="sobrenome" class="reg_user" placeholder="Seu Sobrenome" size="40">

                    <!-- Senha -->
                    <h2 style="margin: 14px 0px;">Senha</h2>
                    <input style="margin-bottom: 14px; padding: 7px 14px; font-size: 18px; border: 1px solid rgb(255, 255, 255, 0.2); border-radius: 5px; 
                           background-color: rgb(52, 53, 58, 1); outline: none;" maxlength="25"
                           type="password" name="senha" class="reg_pass" placeholder="Senha para Login" size="40">

                    <!-- Confirmação de Senha -->
                    <input style="padding: 7px 14px; font-size: 18px; border: 1px solid rgb(255, 255, 255, 0.2); border-radius: 5px; 
                           background-color: rgb(52, 53, 58, 1); outline: none;"
                           type="password" name="senha2" class="reg_pass" placeholder="Confirmar Senha" size="40">

                    <!-- BOTÃO ENVIAR -->
                    <div style="margin-top: 18px;"><button style="font-size: 18px;" class="but" type="submit"
                        onclick="this.disabled=true;this.form.submit();">Registrar</button></div>
                </form>
            </div>
            <?php if(isset($_SESSION['vazio'])){ ?>
            <div class="block" style="text-align: center; padding: 20px 30px 20px 30px; background-color: #771122;">
                Erro: Espaço(s) essêncial(is) em branco
            </div>
            <?php }; unset($_SESSION['vazio']); ?>
            <?php if(isset($_SESSION['repetido'])){ ?>
            <div class="block" style="text-align: center; padding: 20px 30px 20px 30px; background-color: #771122;">
                Erro: Este usuário já está em uso
            </div>
            <?php }; unset($_SESSION['repetido']); ?>
            <?php if(isset($_SESSION['erroSenha'])){ ?>
            <div class="block" style="text-align: center; padding: 20px 30px 20px 30px; background-color: #771122;">
                Erro: As senhas não são iguais
            </div>
            <?php }; unset($_SESSION['erroSenha']); ?>
            
        </div>
        

    </body>
</html>
