<?php
require_once "init.php";
if(!isset($_POST['password'])){
    redirect('signup.php');
    exit();
}
if($_POST['password'] != $_POST['confirm_password']){
    $_SESSION['error'] = true;
    redirect('signup.php');
    exit();
}

$user = [];
$user[] = addslashes(trim($_POST['name']));
$user[] = addslashes(trim($_POST['cpf_cnpj']));
$user[] = addslashes(trim($_POST['email']));
$user[] = addslashes(trim($_POST['phone']));
$user[] = "Você ainda não falou nada sobre você. Que tal nos contar um pouco? =)";
$user[] = addslashes(trim($_POST['address']));
$user[] = addslashes(trim($_POST['address_number']));
$user[] = addslashes(trim($_POST['address_complement']));
$user[] = addslashes(trim($_POST['neighborhood']));
$user[] = addslashes(trim($_POST['city']));
$user[] = addslashes(trim($_POST['state']));
$user[] = sha1(addslashes(trim($_POST['password'])));
$user[] = addslashes(trim($_POST['cep']));
$user[] = isset($_POST['job']) ? 'worker' : 'client';

$query = "INSERT INTO `users` (`name`, `cpf_cnpj`, `email`, `phone`, `description`, `address`, `address_number`, `address_complement`, `neighborhood`, `city`, `state`, `password`, `postal_code`, `role`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $GLOBALS['pdo']->prepare($query);

try{
    $stmt->execute($user);
    $_SESSION['success'] = true;
    redirect("signin.php");
}
catch (PDOException $e) {
    echo $e->getMessage();
    redirect("signup.php");
}
?>