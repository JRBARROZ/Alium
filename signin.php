<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/signin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Conectar</title>
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
        <section class="register bg-image-signup">
            <div class="register-container">
                <h1 class="text-login">Novo por aqui?</h1>
                <div class="subtext-login">
                    <p>Se inscreva e conheça o melhor que a ALIUM tem a oferecer ;)</p>
                </div><br><br>
                <a class="register-form" href="signup.php">REGISTRE-SE</a>
            </div>
        </section>
        <section class="conectar">
            <div class="conectar-container">
                <h1 class="title-login">Conectar</h1>
                <div class=></div>
                <div class="traco-login"></div>
                <?php if(isset($_SESSION['success'])) :?>
                    <div class="success-message">Você foi registrado com sucesso!</div>
                    <?php unset($_SESSION['success'])?>
                <?php endif ?>
                <!-- <div class="error-message">Houve um erro no seu registro</div> -->
                <div class="conectar-form">
                    <form action="validate_user.php" method="POST">
                        <label for="email">E-mail:</label><br>
                        <input type="text" id="email" name="email" required><br>
                        <label for="password">Senha:</label><br>
                        <input type="password" id="password" name="password" required><br>
                        <a href="forgot_password.php">Esqueceu sua senha?</a><br>
                        <input type="submit" value="ENTRAR">
                    </form>
                </div>
            </div>
        </section>
    </div>
    <section class="footer">
        <div class="footer-container">
            <div class="logo-footer">
                <img src="images/icons/logo-footer.svg" alt="">
            </div>
        </div>
    </section>
</body>

</html>