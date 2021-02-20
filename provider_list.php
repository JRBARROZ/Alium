<?php require_once 'init.php' ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/provider_list.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Alium</title>
</head>

<body>
  <div class="header">
    <div class="menu-container">
      <a href="index.php" class="menu-logo"><img src="images/icons/logo.svg" alt=""></a>
      <nav class="menu-nav">
        <ul>
          <?php if (isset($_SESSION['user'])) : ?>
            <!-- <li><a>Bem-vindo(a), </a></li> -->
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
  <?php
  if (isset($_GET['work'])) {
    $query = "SELECT * FROM `services` WHERE `service` = ?";
    $stmt = $GLOBALS['pdo']->prepare($query);
    $stmt->execute([$_GET['work']]);
    $service = $stmt->fetch();
    $rows = $stmt->rowCount();

    if ($rows > 0) {
      $query = "SELECT * FROM `images` WHERE service_id=?";
      $stmt = $GLOBALS['pdo']->prepare($query);
      $stmt->execute([$service['id']]);
      $users = $stmt->fetchAll();
    } else {
  ?>
  <h1 class="provider-title">Erro</h1>
  <div class="provider">
    <p>A busca por <?= strtoupper($_GET['work']) ?> não obteve resultados! Tente novamente</p>
  </div>
  <?php
    exit();
    }
  }
  ?>
  <h1 class="provider-title"><?= strtoupper($_GET['work']) ?></h1>
  <div class="provider">
    <?php foreach ($users as $user) : ?>
      <?php
        $user = getUserById($user['user_id']);
        if (isset($_SESSION['user']) && $user['id'] === $_SESSION['user']['id']) {
          continue;
        }
      ?>
      <div class="provider-item">
        <div class="provider-img">
          <img src="./images/backgrounds/index.jpg" alt="">
        </div>
        <div class="provider-title2">
          <h1><?= $user['name'] ?></h1>
        </div>
        <div class="profile-item star-size">
          <p>4.5 / 5.0 - Ótimo</p>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star checked"></span>
          <span class="fa fa-star-half-o checked"></span>
        </div>
        <p><?= $user['description'] ?></p>
        <form action="worker_profile.php" method="POST">
          <input type="hidden" name="id" value="<?= $user['id'] ?>">
          <button type="submit">Contatar</button>
        </form>
      </div>
    <?php endforeach ?>
    <!-- <div class="provider-item">
      <div class="provider-img">
        <img src="./images/backgrounds/index.jpg" alt="">
      </div>
      <div class="provider-title2">
        <h1>Pamela</h1>
      </div>
      <div class="profile-item star-size">
        <p>4.5 / 5.0 - Ótimo</p>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star-half-o checked"></span>
      </div>
      <p>Magna pariatur adipisicing ea aliquip laboris labore occaecat cupidatat commodo eiusmod eu cillum irure.</p>
      <button>Contatar</button>
    </div>
    <div class="provider-item">
      <div class="provider-img">
        <img src="./images/backgrounds/index.jpg" alt="">
      </div>
      <div class="provider-title2">
        <h1>Pamela</h1>
      </div>
      <div class="profile-item star-size">
        <p>4.5 / 5.0 - Ótimo</p>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star-half-o checked"></span>
      </div>
      <p>Magna pariatur adipisicing ea aliquip laboris labore occaecat cupidatat commodo eiusmod eu cillum irure.</p>
      <button>Contatar</button>
    </div>
    <div class="provider-item">
      <div class="provider-img">
        <img src="./images/backgrounds/index.jpg" alt="">
      </div>
      <div class="provider-title2">
        <h1>Pamela</h1>
      </div>
      <div class="profile-item star-size">
        <p>4.5 / 5.0 - Ótimo</p>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star-half-o checked"></span>
      </div>
      <p>Magna pariatur adipisicing ea aliquip laboris labore occaecat cupidatat commodo eiusmod eu cillum irure.</p>
      <button>Contatar</button>
    </div>
    <div class="provider-item">
      <div class="provider-img">
        <img src="./images/backgrounds/index.jpg" alt="">
      </div>
      <div class="provider-title2">
        <h1>Pamela</h1>
      </div>
      <div class="profile-item star-size">
        <p>4.5 / 5.0 - Ótimo</p>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star-half-o checked"></span>
      </div>
      <p>Magna pariatur adipisicing ea aliquip laboris labore occaecat cupidatat commodo eiusmod eu cillum irure.</p>
      <button>Contatar</button>
    </div>
    <div class="provider-item">
      <div class="provider-img">
        <img src="./images/backgrounds/index.jpg" alt="">
      </div>
      <div class="provider-title2">
        <h1>Pamela</h1>
      </div>
      <div class="profile-item star-size">
        <p>4.5 / 5.0 - Ótimo</p>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star-half-o checked"></span>
      </div>
      <p>Magna pariatur adipisicing ea aliquip laboris labore occaecat cupidatat commodo eiusmod eu cillum irure.</p>
      <button>Contatar</button>
    </div> -->

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