<?php require_once 'init.php' ?>
<?php

$query = "SELECT images.name, users.id FROM images INNER JOIN users ON users.id = images.user_id WHERE images.name LIKE ?";
$stmt = $GLOBALS['pdo']->prepare($query);
$stmt->execute(["perfil%"]);
$perfil = $stmt->fetchAll();
$perfilPicArray = [];
foreach ($perfil as $key => $value) {
  array_push($perfilPicArray, $value['name']);
}
?>

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
  if (!isset($_GET['work'])) {
    redirect('profile.php');
  }
  if (isset($_GET['work'])) {
    $query = "SELECT * FROM `services` WHERE `service` = ?";
    $stmt = $GLOBALS['pdo']->prepare($query);
    $stmt->execute([$_GET['work']]);
    $service = $stmt->fetch();
    $rows = $stmt->rowCount();

    if ($rows > 0) {
      $query = "SELECT * FROM `users_has_services` WHERE service_id=?";
      $stmt = $GLOBALS['pdo']->prepare($query);
      $stmt->execute([$service['id']]);
      $users = $stmt->fetchAll();
      $rows_user_services = $stmt->rowCount();
    } else {
      redirect('index.php');
      $_SESSION['work'] =  strtoupper($_GET['work']);
  ?>
</body>

</html>
<?php
      exit();
    }
  }
?>
<h1 class="provider-title"><?= strtoupper($_GET['work']) ?></h1>
<div class="provider">
  <?php if ($rows_user_services != 0) : ?>
    <?php foreach ($users as $key => $user) : ?>
      <?php
      $user = getUserById($user['user_id']);
      $user_id = $user['id'];
      if (isset($_SESSION['user']) && $user['id'] === $_SESSION['user']['id']) {
        continue;
      }
      $query = "SELECT `evaluation` FROM `feedbacks` WHERE `worker_id` = ? ";
      $stmt = $GLOBALS['pdo']->prepare($query);
      $stmt->execute([$user['id']]);
      $evaluations = $stmt->fetchAll();
      $row = $stmt->rowCount();
      $rate = 0;
      if ($row > 0) {
        $sum = 0;
        foreach ($evaluations as $evaluation) {
          $sum += $evaluation['evaluation'];
        }
        $rate = round(($sum / $row), 1);
        $rate_size = strlen((string)$rate);
        if ($rate_size == 1) {
          $rate = '' . $rate . '.0';
        }
      }
      ?>
      <div class="provider-item">
        <div class="provider-img">
          <?php if (sizeof($perfilPicArray) > 0) : ?>
            <?php if (is_dir("./images/portfolio/user_port_$user_id/perfil/")) : ?>
              <img src="./images/portfolio/user_port_<?= $user['id'] ?>/perfil/<?= $perfilPicArray[$key] ?>" alt="">
            <?php else : ?>
              <div class="profile-img">
                <p id="prof-pic-letter"><?= strtoupper($user["name"][0]) ?></p>
              </div>
            <?php endif ?>
          <?php else : ?>
            <div class="profile-img">
              <p id="prof-pic-letter"><?= strtoupper($user["name"][0]) ?></p>
            </div>
          <?php endif ?>
        </div>
        <div class="provider-title2">
          <h1><?= $user['name'] ?></h1>
        </div>
        <div class="profile-item star-size">
          <?php if ($rate == 0) : ?>
            <p>Sem avaliações</p>
          <?php else : ?>
            <p><?= $rate ?>/5.0</p>
            <?php
            $rate = (string)$rate;
            $eval = explode('.', $rate);
            $int_rate = (int)$eval[0];
            $dec_rate = (int)$eval[1];
            for ($i = 0; $i < 5; $i++) :
            ?>
              <?php if ($i <= $int_rate - 1) : ?>
                <span class="fa fa-star checked"></span>
              <?php elseif ($i == $int_rate && $dec_rate >= 3) : ?>
                <span class="fa fa-star-half-o checked"></span>
              <?php else : ?>
                <span class="fa fa-star empty-star"></span>
              <?php endif ?>
            <?php endfor ?>
            <?php if ($row == 1) : ?>
              <br><span class="count-evaluations"><?= $row ?> avaliação</span>
            <?php else : ?>
              <br><span class="count-evaluations"><?= $row ?> avaliações</span>
            <?php endif ?>
          <?php endif ?>
        </div>
        <p><?= $user['description'] ?></p>
        <form action="worker_profile.php" method="POST">
          <input type="hidden" name="id" value="<?= $user['id'] ?>">
          <input type="hidden" name="service" value="<?= $_GET['work'] ?>">
          <button type="submit">Contatar</button>
        </form>
      </div>
    <?php endforeach ?>
  <?php else : ?>
    <p class="not-found">Não tem ninguém prestando este serviço no momento.</p>
    <div class="teste">
      <div class="provider-img">
        <img src="./images/backgrounds/index.jpg" alt="">
      </div>
      <div class="provider-title2">
        <h1>Teste</h1>
      </div>
      <div class="profile-item star-size">
        <p>4.5 / 5.0 - Ótimo</p>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star-half-o checked"></span>
      </div>
      <p>Teste</p>
      <form action="worker_profile.php" method="POST">
        <input type="hidden" name="id" value="teste">
        <button type="submit">Contatar</button>
      </form>
    </div><br>
  <?php endif ?>
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