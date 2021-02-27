<?php

require_once 'init.php';

if (!isLogged()) {
  redirect('signin.php');
  exit();
}

if (isset($_POST['worker_id'])) {
    $data = [];
    $data[] = addslashes(trim($_POST['feedback']));
    $data[] = (int)$_POST['rate'];
    $data[] = addslashes(trim($_POST['title']));
    $data[] = $_SESSION['user']['id'];
    $data[] = addslashes(trim($_POST['worker_id']));

    $query = "INSERT INTO `feedbacks` (`feedback`,`evaluation`,`title`,`client_id`,`worker_id`) VALUES (?,?,?,?,?)";
    
    $stmt = $GLOBALS['pdo']->prepare($query);
    $stmt->execute($data);

}
redirect('index.php');
?>