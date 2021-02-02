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
  echo "credenciais inválidas";
}
if (isset($_GET['logout'])) {
  session_destroy();
  redirect('signin.php');
}
?>
<a href="validate_user.php?logout=1">sair</a>
<a href="signin.php">voltar</a>