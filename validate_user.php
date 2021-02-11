<?php
require_once 'init.php';
if(!isset($_POST['email'])){
  redirect('signin.php');
  exit();
}
$email = addslashes(trim($_POST['email']));
$password = sha1(addslashes(trim($_POST['password'])));

if (login($email, $password)) {
  redirect('index.php');
} else {
  $_SESSION['error-login'] = true;
}
redirect('signin.php');
?>