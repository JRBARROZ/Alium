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
                <div class="traco-signup"></div><br>
                <div class="error-message-form">
                    <h4>Erros encontrados:</h4>
                    <ul id="error-form"></ul>
                </div>
                <?php if (isset($_SESSION['error'])) : ?>
                    <div class="error-message">As senhas não conferem :/</div>
                    <?php unset($_SESSION['error']) ?>
                <?php endif ?>
                <?php if (isset($_SESSION['already_exists'])) : ?>
                    <div class="error-message">O e-mail ou CPF/CNPJ informado já está em uso.</div>
                    <?php unset($_SESSION['already_exists']) ?>
                <?php endif ?>
                <div class="signup-form">
                    <form action="add_user.php" method="POST" class="form">
                        <label for="name">Nome:<span class="red required">*</span></label><br>
                        <input type="text" id="name" name="name"><br>
                        <label for="cpf_cnpj">CPF/CNPJ:<span class="red required">*</span></label><br>
                        <input type="text" id="cpf_cnpj" name="cpf_cnpj" onfocus="removeMask(this);" onblur="addCpfCnpjMask(this);" minlength="11" maxlength="14"><br>
                        <label for="email">E-mail:<span class="red required">*</span></label><br>
                        <input type="email" id="email" name="email"><br>
                        <label for="phone">Telefone:<span class="red required">*</span></label><br>
                        <input type="text" id="phone" name="phone" onfocus="removeMask(this);" onblur="addPhoneMask(this);" minlength="10" maxlength="11"><br>
                        <label for="cep">CEP:<span class="red required">*</span> <span id="text">(Não sabe o CEP? <a href="https://buscacepinter.correios.com.br/app/endereco/index.php?t" target="_blank">Clique aqui</a>) </span></label><br>
                        <input type="text" id="cep" name="cep" size="10" maxlength="9" onblur="searchPostalCode(this);"><br>
                        <div class="form-group">
                            <div class="form-side">
                                <label for="address">Rua:<span class="red required">*</span></label>
                                <input type="text" id="address" name="address">
                            </div>
                            <div class="form-side">
                                <label for="address_number">Número:</label>
                                <input type="text" id="address_number" name="address_number">
                            </div>
                            <div class="form-side">
                                <label for="address_complement">Complemento:</label>
                                <input type="text" id="address_complement" name="address_complement">
                            </div>
                            <div class="form-side">
                                <label for="neighborhood">Bairro:<span class="red required">*</span></label>
                                <input type="text" id="neighborhood" name="neighborhood">
                            </div>
                            <div class="form-side">
                                <label for="city">Cidade:<span class="red required">*</span></label>
                                <input type="text" id="city" name="city">
                            </div>
                            <div class="form-side">
                                <label for="state">Estado:<span class="red required">*</span></label>
                                <input type="text" id="state" name="state">
                            </div>
                            <div class="form-side">
                                <label for="password">Senha:<span class="red required">*</span></label>
                                <input type="password" id="password" name="password">
                            </div>
                            <div class="form-side">
                                <label for="confirm_password">Repetir a Senha:<span class="red required">*</span></label>
                                <input type="password" id="confirm_password" name="confirm_password">
                            </div>
                        </div>
                        <label for="job" style="font-family:Nunito-Light;font-size:16px;"> Prestador de Serviço</label>
                        <input type="checkbox" id="job" name="job"><br>
                        <span class="red">Os campos com * são obrigatórios</span>
                        <br><br>
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
<script src="js/masks.js"></script>
<script src="js/cep.js"></script>
<script src="js/validate_form.js"></script>

</html>
<?php
exit();
?>