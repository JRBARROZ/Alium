<?php
require_once 'init.php';

if (!isset($_POST['id'])) {
  redirect('provider_list.php');
  exit();
}

$worker_id = $_POST['id'];

$query = "SELECT * FROM `users` WHERE `id` = ?";
$stmt = $GLOBALS['pdo']->prepare($query);
$stmt->execute([$worker_id]);
$worker = $stmt->fetch();
$description = $worker['description'];

$query = "SELECT * FROM `users_has_services` WHERE `user_id` = ?";
$stmt = $GLOBALS["pdo"]->prepare($query);
$stmt->execute([$worker_id]);
$images = $stmt->fetchAll();
$images_ids = [];
if (sizeof($images) > 0) {
  foreach ($images as $image) {
    array_push($images_ids, $image['service_id']);
  }
}

$query = "SELECT * FROM `images` WHERE `user_id` = ?";
$stmt = $GLOBALS['pdo']->prepare($query);
$stmt->execute([$worker_id]);
$portfolio_images = $stmt->fetchAll();
$phone = $worker['phone'];
$whatsappPhone = str_replace(['(',')',' ','-'], '', $phone);

if ( $worker['social_media'] == '') {
  $insta = 'Não Informado';
  $twitter = 'Não Informado';
} else {
  list($insta, $twitter) = explode(';', $worker['social_media']) ?? '';
  $insta = $insta[0] == '@' ? trim($insta) : "@" . trim($insta);
  $twitter = $twitter[0] == '@' ? trim($twitter) : "@" . trim($twitter);
}

if(isLogged()){
$query = "SELECT * FROM `feedbacks` WHERE `client_id` = ? AND `worker_id` = ?";
$stmt = $GLOBALS['pdo']->prepare($query);
$stmt->execute([$_SESSION['user']['id'], $worker['id']]);
$rows = $stmt->rowCount();
$evaluation = $stmt->fetch();
$already_evaluated = false;

if ($rows != 0) {
  $already_evaluated = true;
}

$title = $already_evaluated ? $evaluation['title'] : '';
$feedback = $already_evaluated ? $evaluation['feedback'] : '';
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
        <p><span class="name"><?= $worker['name'] ?></span><br><i class="fa fa-map-marker" aria-hidden="true"></i> <?= $worker['city'] ?>, <?= $worker['state'] ?>, <br>
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
        <?php if(isLogged()): ?>
        <?php if ($already_evaluated): ?>
          <div class="profile-item">
            <h3>Você já avaliou <?= $worker['name'] ?></h3>
            <button type="button" href="#" class="btn" onclick="showEvaluateForm()">Editar Avaliação</button>
          </div>
          <?php else: ?>
            <div class="profile-item">
              <h3>Avaliar <?= $worker['name'] ?></h3>
              <button type="button" href="#" class="btn" onclick="showEvaluateForm()">Avaliar Prestador</button>
            </div>
          <?php endif ?>
        <div class="profile-item evaluate">
            <form id="rating" action="feedback.php" method="POST">
              <div class="star-widget">
              <?php for ($i = 5; $i > 0; $i--): ?>
                <?php if ($already_evaluated && $i == $evaluation['evaluation']): ?>
                  <input type="radio" name="rate" id="rate-<?= $i ?>" value="<?= $i ?>" checked> 
                  <label for="rate-<?= $i ?>" class="fa fa-star"></label>
                <?php else: ?>
                  <input type="radio" name="rate" id="rate-<?= $i ?>" value="<?= $i ?>"> 
                  <label for="rate-<?= $i ?>" class="fa fa-star"></label>
                <?php endif ?>
              <?php endfor ?>
              </div>
              <input type="hidden" name="worker_id" value="<?= $worker['id']?>">
              <input type="hidden" name="service" value="<?= $_POST['service']?>">
              <label for="title">Título</label><br>
              <input type="text" name="title" id="title" placeholder="Ex: Profissional excelente!" value="<?= $title ?>"><br>
              <label for="feedback">Feedback</label><br>
              <textarea id="feedback" name="feedback" cols="5" rows="6" placeholder="Conte-nos sobre sua experiência com o(a) <?=$worker['name']?>"><?= $feedback ?></textarea>
              <input type="submit" value="Avaliar">
              <button type="button" href="#" class="btn cancel-button" onclick="hideEvaluateForm()">Cancelar</button>
            </form>
        </div>
        <?php else: ?>
          <div class="profile-item">
            <h3>Entre para avaliar este profissional</h3>
            <a href="signin.php" class="btn">Entrar</a>
          </div>
        <?php endif ?>
        <div class="profile-item">
          <h3>Contatos</h3>
          <ul id="contacts-content">
            <li><a href="https://wa.me/+55<?= $whatsappPhone ?>" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i> Entre em contato </a></li>
            <li><a href="https://www.instagram.com/<?= str_replace('@', '', $insta) ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i> <?= $insta ?></a></li>
            <li><a href="https://twitter.com/<?= str_replace('@', '', $twitter) ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i> <?= $twitter ?></a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="profile-edit">
      <div class="profile-text-edit">
        <h1>Portfólio</h1>
        <div id='profile-preview'>
          <div class="profile-preview">
            <?php foreach($portfolio_images as $i => $image): ?>
              <img class="profile-preview-item" src="images/portfolio/user_port_<?= $worker_id ?>/<?= $i ?>.jpg" alt="teste">
            <?php endforeach ?>
          </div>
        </div>
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
<script src="js/profile.js"></script>
</html>