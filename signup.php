<?php require_once 'init.php' ?>
<?php
    if (isLogged()) {
        redirect('index.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/signup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Cadastro</title>
</head>

<body>
    <div class="header">
        <div class="header-container">
            <header>
                <a href="index.php" class="menu-logo"><img src="images/icons/logo.svg" alt=""></a>
            </header>
        </div>
    </div>
    <div class="content">
        <section class="signin bg-image-signin">
            <div class="signin-container">
                <div class="signin">
                    <div class="signin-container">
                        <p class="text-signin">Já tem uma conta?</p>
                        <div class="signin-form">
                            <p class="subtext-signin">Que bom que você já faz parte do nosso time
                            <div class="signin-button">
                                <form action="signin.php" method="POST">
                                    <input type="submit" value="CONECTAR-SE" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="signup">
            <div>
                <h1 class="title-signup">Registro</h1>
                <div class="traco-signup"></div>
                <?php if(isset($_SESSION['error'])):?>
                    <div class="error-message">As senhas não conferem :/</div>
                    <?php unset($_SESSION['error'])?>
                <?php endif ?>
                <div class="signup-form">
                    <form action="add_user.php" method="POST">
                        <label for="name">Nome:</label><br>
                        <input type="text" id="name" name="name" required><br>
                        <label for="cpf_cnpj">CPF/CNPJ:</label><br>
                        <input type="text" id="cpf_cnpj" name="cpf_cnpj" onfocus="removeMask(this);" onblur="addCpfCnpjMask(this);" minlength="11" maxlength="18" required><br>
                        <label for="email">E-mail:</label><br>
                        <input type="email" id="email" name="email" required><br>
                        <label for="phone">Telefone:</label><br>
                        <input type="text" id="phone" name="phone" onfocus="removeMask(this);" onblur="addPhoneMask(this);" required><br>
                        <label for="username">Nome de usuário:</label><br>
                        <input type="text" id="username" name="username" required><br>
                        <label for="password">Senha:</label><br>
                        <input type="password" id="password" name="password" required><br>
                        <label for="confirm_password">Repetir a Senha:</label><br>
                        <input type="password" id="confirm_password" name="confirm_password" required><br>
                        <label for="cep">CEP:</label><br>
                        <input type="text" id="cep" name="cep" size="10" maxlength="9" onblur="pesquisacep(this.value);" required><br>
                        <label for="address">Rua:</label><br>
                        <input type="text" id="address" name="address" required><br>
                        <label for="address_number">Número:</label><br>
                        <input type="text" id="address_number" name="address_number" required><br>
                        <label for="neighborhood">Bairro:</label><br>
                        <input type="text" id="neighborhood" name="neighborhood" required><br>
                        <label for="city">Cidade:</label><br>
                        <input type="text" id="city" name="city" required><br>
                        <label for="state">Estado:</label><br>
                        <input type="text" id="state" name="state" required><br><br>
                        <label for="job" style="font-family:Nunito-Light;font-size:16px;"> Prestador de Serviço</label>
                        <input type="checkbox" id="job" name="job"><br><br>
                        <input type="submit" value="CADASTRAR">
                    </form>
                </div>
            </div>
        </section>
    </div>
    <footer>
        <section class="footer">
            <div class="footer-container">
                <div class="logo-footer">
                    <img src="images/icons/logo-footer.svg" alt="">
                </div>
            </div>
        </section>
    </footer>
</body>
<script src="js/cep.js"></script>
<script src="js/masks.js"></script>
</html>