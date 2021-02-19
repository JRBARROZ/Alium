<?php
require_once 'init.php';

$user = $_SESSION['user-recovery'];
$user_id = md5($user['id']) . $user['id'];
$query = "SELECT `token`, `token_date` FROM `users` WHERE `id` = ?";
$stmt = $GLOBALS['pdo']->prepare($query);
$stmt->execute([$user['id']]);
$result = $stmt->fetch();

if (isset($_GET['user']) && $_GET['user'] === $user_id && isset($_GET['token']) && $_GET['token'] === $result['token'] && (time() - $result['token_date']) < 900) {
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
        <!-- <?php if (isset($_SESSION['success-recovery'])) : ?>
          <div class="success-message">E-mail enviado! Verifique sua caixa de entrada.</div>
          <?php unset($_SESSION['success-recovery']) ?>
        <?php endif ?> -->
        <!-- <div class="error-message">Houve um erro no seu registro</div> -->
        <div class="conectar-form">
          <form action="recovery_password.php" method="POST">
            <label for="password">Senha:</label><br>
            <input type="password" id="password" name="password" required><br>
            <label for="confirm-password">Confirme a Senha:</label><br>
            <input type="password" id="confirm-password" name="confirm-password" required><br>
            <input type="hidden" name="id" value="<?= $user['id'] ?>" required><br>
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
} else {

}
if (isset($_POST['password'])) {
  $password = sha1(addslashes(trim($_POST['password'])));
  $user_id = $_POST['id'];

  $query = "UPDATE `users` SET `password` = ? WHERE `id` = ?";
  $stmt = $GLOBALS['pdo']->prepare($query);
  $stmt->execute([$password, $user_id]);
  $_SESSION['success-password-recover'] = true;
  redirect('signin.php');
}
?>