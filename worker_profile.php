<?php
require_once 'init.php';

if (!isLogged()) {
  redirect('signin.php');
  exit();
}

if (!isset($_POST['id'])) {
  redirect('provider_list.php');
  exit();
}

$user_id = $_POST['id'];

$query = "SELECT * FROM `users` WHERE `id` = ?";
$stmt = $GLOBALS['pdo']->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch();
$description = $user['description'];

$query = "SELECT * FROM `images` WHERE `user_id` = ?";
$stmt = $GLOBALS["pdo"]->prepare($query);
$stmt->execute([$user_id]);
$images = $stmt->fetchAll();
$images_ids = [];
if (sizeof($images) > 0) {
  foreach ($images as $image) {
    array_push($images_ids, $image['service_id']);
  }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/profile.css">
</head>

<body>
  <div class="header">
    <div class="menu-container">
      <a href="index.php" class="menu-logo"><img src="images/icons/logo.svg" alt=""></a>
      <nav class="menu-nav">
        <ul>
          <?php if (isset($_SESSION['user'])) : ?>
            <!-- <li><a>Bem-vindo(a),</a></li> -->
            <li><a href="profile.php"><?= $_SESSION['logged-user'] ?></a></li>
            <li><a href="logout.php" class="text-color-yellow">Sair</a></li>
          <?php else : ?>
            <li><a href="signup.php">Registrar-se</a></li>
            <li><a href="signin.php">Entrar</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </div>
  <div class="content-profile">
    <div class="perfil-provider">
      <a id="back" href="javascript:history.go(-1)"><i class="fa fa-arrow-left fa-4" aria-hidden="true"></i></a>
      <div class="perfil-img">
        <div class="img">
          <img src="./images/profile/perfilImage.jpg" alt="">
        </div>
        <br>
        <p><span class="name"><?= $user['name'] ?></span><br><i class="fa fa-map-marker" aria-hidden="true"></i> <?= $user['city'] ?>, <?= $user['state'] ?>, <br>
          <?php
          foreach ($images_ids as $i => $id) :
            $serv = getServiceById($id);
            if ($i == sizeof($images_ids) - 1 || $i == 2) :
          ?>
              <a href='provider_list.php?work=<?= $serv['service'] ?>'><?= $serv['service'] ?></a>
            <?php
            else :
            ?>
              <a href='provider_list.php?work=<?= $serv['service'] ?>'><?= $serv['service'] ?></a> -
          <?php
            endif;
            if ($i == 2) :
              break;
            endif;
          endforeach;
          ?>
        </p>
      </div>
      <div class="profile-nav">
        <div class="profile-item">
          <h3>Sobre</h3>
          <p id="about-content"><?= $description ?></p>
          <form id="about-form" action="update_profile.php" method="POST">
            <textarea name="about" cols="5" rows="6"><?= $description ?></textarea>
            <input type="submit" value="Salvar">
          </form>
        </div>
        <div class="profile-item">
          <h3>Avaliação</h3>
          <p>4.5 / 5.0 - Ótimo</p>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star-half-o checked"></span>
        </div>
        <div class="profile-item">
          <h3>Contatos</h3>
          <ul>
            <li><i class="fa fa-whatsapp" aria-hidden="true"></i> <?= $user['phone'] ?></li>
            <li><i class="fa fa-instagram" aria-hidden="true"></i> @pamisley</li>
            <li><i class="fa fa-twitter" aria-hidden="true"></i> @pam_painter</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="profile-edit">
      <div class="profile-text-edit">
        <h1>Portfólio</h1>
      </div>
    </div>
  </div>
  <section class="footer">
    <div class="footer-container">
      <div class="logo-footer">
        <img src="images/icons/logo-footer.svg" alt="">
      </div>
    </div>
  </section>
</body>
<script src="js/cep.js"></script>
<script src="js/masks.js"></script>

</html>