<?php
require_once 'init.php';

if (!isLogged() || !isset($_POST['name'])) {
  redirect('index.php');
}

$query = "SELECT * FROM `services`";
$stmt = $GLOBALS['pdo']->prepare($query);
$stmt->execute();
$services = $stmt->fetchAll();

if (isset($_POST['name']) || isset($_POST['email'])) {

  foreach ($services as $key => $service) {
    $serv = str_replace(' ', '_', $service['service']);

    if (isset(filter_input_array(INPUT_POST)[$serv])) {
      $query = "SELECT * FROM `users_has_services` WHERE `user_id` = ? AND `service_id` = ?";
      $stmt = $GLOBALS['pdo']->prepare($query);
      $stmt->execute([$_SESSION['user']['id'], $service['id']]);
      $rows = $stmt->rowCount();

      if ($rows === 0) {
        $query = "INSERT INTO `users_has_services` (`user_id`, `service_id`) VALUES (?, ?)";
        $stmt = $GLOBALS['pdo']->prepare($query);
        $stmt->execute([$_SESSION['user']['id'], $service['id']]);
      }
    } else if (!isset(filter_input_array(INPUT_POST)[$serv])) {
      $query = "DELETE FROM `users_has_services` WHERE `user_id` = ? AND `service_id` = ?";
      $stmt = $GLOBALS['pdo']->prepare($query);
      $stmt->execute([$_SESSION['user']['id'], $service['id']]);
    }
  }
  $data = [];

  $data[] = addslashes(trim($_POST['name']));
  $data[] = addslashes(trim($_POST['cpf_cnpj']));
  $data[] = addslashes(trim($_POST['email']));
  $data[] = addslashes(trim($_POST['phone']));
  $data[] = addslashes(trim($_POST['address']));
  $data[] = addslashes(trim($_POST['address_number']));
  $data[] = addslashes(trim($_POST['address_complement']));
  $data[] = addslashes(trim($_POST['neighborhood']));
  $data[] = addslashes(trim($_POST['city']));
  $data[] = addslashes(trim($_POST['state']));
  $data[] = addslashes(trim($_POST['cep']));
  $data[] = addslashes(trim($_POST['user_id']));

  $query = "UPDATE `users` SET `name` = ?, `cpf_cnpj` = ?, `email` = ?, `phone` = ?, `address` = ?, `address_number` = ?, `address_complement` = ?, `neighborhood` = ?, `city` = ?, `state` = ?, `postal_code` = ? WHERE `id` = ?";

  $stmt = $GLOBALS['pdo']->prepare($query);
  $stmt->execute($data);
}

if (isset($_POST['about'])) {
  $about = addslashes(trim($_POST['about']));

  $query = "UPDATE `users` SET `description` = ? WHERE `id` = ?";
  $stmt = $GLOBALS['pdo']->prepare($query);
  $stmt->execute([$about, $_SESSION['user']['id']]);
}

if (isset($_POST['insta'])) {
  $phone = addslashes(trim($_POST['phone']));
  $insta = addslashes(trim($_POST['insta']));
  $twitter = addslashes(trim($_POST['twitter']));
  $instaAndTwitter = $insta . ";" . $twitter;
  $queryUpdate = "UPDATE `users` SET `phone` = ? WHERE `id` = ?";
  $stmt = $GLOBALS['pdo']->prepare($queryUpdate);
  $stmt->execute([$phone, $_SESSION['user']['id']]);

  $queryVerifyIfExists = "SELECT `social_media` FROM `users` WHERE `id` = ? ";
  $stmt = $GLOBALS['pdo']->prepare($queryVerifyIfExists);
  $stmt->execute([$_SESSION['user']['id']]);
  $data = $stmt->fetch();
  $row = $stmt->rowCount();
  if($row === 1){
    $queryUpdate = "UPDATE `users` SET `social_media` = ? WHERE `id` = ?";
    $stmt = $GLOBALS['pdo']->prepare($queryUpdate);
    $stmt->execute([$instaAndTwitter, $_SESSION['user']['id']]);
  }else{
    $queryInsert = "INSERT INTO `users` (`social_media`) VALUES (?) WHERE `id` = ?";
    $stmt = $GLOBALS['pdo']->prepare($queryInsert);
    $stmt->execute([$instaAndTwitter, $_SESSION['user']['id']]);
  }

}


updateLoggedUser($_SESSION['user']['id']);

redirect('profile.php');
