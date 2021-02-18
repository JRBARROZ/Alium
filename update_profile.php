<?php
require_once 'init.php';

if (!isLogged() || !isset($_POST['name'])) {
  redirect('index.php');
}

$query = "SELECT * FROM `services`";
$stmt = $GLOBALS['pdo']->prepare($query);
$stmt->execute();
$services = $stmt->fetchAll();

// echo "<pre>";
// var_dump(filter_input_array(INPUT_POST));
// echo "</pre>";

// exit();


if (isset($_POST['name']) || isset($_POST['email'])) {
  foreach ($services as $key => $service) {
    $serv = str_replace(' ', '_', $service['service']);

    if (isset(filter_input_array(INPUT_POST)[$serv])) {

      $query = "SELECT * FROM `images` WHERE `user_id` = ? AND `service_id` = ?";
      $stmt = $GLOBALS['pdo']->prepare($query);
      $stmt->execute([$_SESSION['user']['id'], $service['id']]);
      $rows = $stmt->rowCount();

      if ($rows === 0) {
        $url = '';
        $query = "INSERT INTO `images` (`url`, `user_id`, `service_id`) VALUES (?, ?, ?)";
        $stmt = $GLOBALS['pdo']->prepare($query);
        $stmt->execute([$url, $_SESSION['user']['id'], $service['id']]);
      }
    } else if (!isset(filter_input_array(INPUT_POST)[$serv])) {
      $query = "DELETE FROM `images` WHERE `user_id` = ? AND `service_id` = ?";
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
  $data[] = addslashes(trim($_POST['neighborhood']));
  $data[] = addslashes(trim($_POST['city']));
  $data[] = addslashes(trim($_POST['state']));
  $data[] = addslashes(trim($_POST['cep']));
  $data[] = addslashes(trim($_POST['user_id']));

  $query = "UPDATE `users` SET `name` = ?, `cpf_cnpj` = ?, `email` = ?, `phone` = ?, `address` = ?, `address_number` = ?, `neighborhood` = ?, `city` = ?, `state` = ?, `postal_code` = ? WHERE `id` = ?";

  $stmt = $GLOBALS['pdo']->prepare($query);
  $stmt->execute($data);
}

if (isset($_POST['about'])) {
  $about = addslashes(trim($_POST['about']));

  $query = "UPDATE `users` SET `description` = ? WHERE `id` = ?";
  $stmt = $GLOBALS['pdo']->prepare($query);
  $stmt->execute([$about, $_SESSION['user']['id']]);
}

updateLoggedUser($_SESSION['user']['id']);

redirect('profile.php');
