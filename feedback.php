<?php

require_once 'init.php';

if (!isLogged()) {
  redirect('signin.php');
  exit();
}

if (isset($_POST['worker_id'])) {
  $feedback = addslashes(trim($_POST['feedback']));
  $evaluation = (int)$_POST['rate'];
  $title = addslashes(trim($_POST['title']));
  $client_id = $_SESSION['user']['id'];
  $worker_id = addslashes(trim($_POST['worker_id']));

  $query = "SELECT * FROM `feedbacks` WHERE `client_id` = ? AND `worker_id` = ?";
  $stmt = $GLOBALS['pdo']->prepare($query);
  $stmt->execute([$client_id, $worker_id]);
  $rows = $stmt->rowCount();

  $service = $_POST['service'];

  if ($rows == 0) {    
    $query = "INSERT INTO `feedbacks` (`feedback`,`evaluation`,`title`,`client_id`,`worker_id`) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $GLOBALS['pdo']->prepare($query);
    $stmt->execute([$feedback, $evaluation, $title, $client_id, $worker_id]);
  } else {
    $query = "UPDATE `feedbacks` SET `feedback` = ?, `title` = ?, `evaluation` = ? WHERE `client_id` = ? AND `worker_id` = ?";
    $stmt = $GLOBALS['pdo']->prepare($query);
    $stmt->execute([$feedback, $title, $evaluation, $client_id, $worker_id]);
  }
}
redirect('worker_profile.php?id=' . $worker_id);
