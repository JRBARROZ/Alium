<?php require_once('init.php') ?>
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
  <div class="content-forgot-password">
    <section class="conectar">
      <div class="conectar-container">
        <h1 class="title-login">Recuperar Senha</h1>
        <div class="traco-forgot-password"></div>
        <?php if (isset($_SESSION['success-recovery'])) : ?>
          <div class="success-message">E-mail enviado! Verifique sua caixa de entrada.</div>
          <?php unset($_SESSION['success-recovery']) ?>
        <?php endif ?>
        <?php if (isset($_SESSION['error-recovery'])) : ?>
          <div class="error-message">E-mail inválido!</div>
          <?php unset($_SESSION['error-recovery']) ?>
        <?php endif ?>
        <!-- <div class="error-message">Houve um erro no seu registro</div> -->
        <div class="conectar-form">
          <form action="forgot_password.php" method="POST">
            <label for="email">E-mail:</label><br>
            <input type="text" id="email" name="email" required><br>
            <input type="submit" value="RECUPERAR">
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
<?php 
if (isset($_POST['email'])) {
  $email = addslashes(trim($_POST['email']));

  $query = "SELECT * FROM `users` WHERE `email` = ?";
  $stmt = $GLOBALS['pdo']->prepare($query);
  $stmt->execute([$email]);
  $rows = $stmt->rowCount();

  if ($rows == 0) {
    $_SESSION['error-recovery'] = true;
  } else {
    $user = $stmt->fetch();
    $_SESSION['user-recovery'] = $user;
    redirect('send_mail.php');
    exit();
  }
  redirect('forgot_password.php');
}
?>