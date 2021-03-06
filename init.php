<?php
session_start();

$pdo = null;

function connectDatabase()
{
  if ($GLOBALS['pdo'] !== null) {
    return;
  }
  $host = 'localhost';
  $db = 'alium';
  $user = 'root';
  $pass = 'Jhon2929@';
  $dsn = "mysql:host=$host;dbname=$db;charset=utf8";

  $opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
  ];

  try {
    $GLOBALS['pdo'] = new PDO($dsn, $user, $pass, $opt);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}
connectDatabase();

function isLogged()
{
  return isset($_SESSION['user']);
}

function isAdmin()
{
  return isset($_SESSION['logged-user']) && isset($_SESSION['admin']);
}

function login($email, $password)
{

  $query = "SELECT * FROM users WHERE `email` = ? AND `password` = ?";

  $stmt = $GLOBALS['pdo']->prepare($query);

  $stmt->execute([$email, $password]);
  $user = $stmt->fetch();

  $row = $stmt->rowCount();

  if ($row == 1) {
    $_SESSION['user'] = $user;
    $data = explode(' ', $user['name']);

    if (sizeof($data) > 1) {
      $_SESSION['logged-user'] = trim($data[0]) . " " . trim($data[sizeof($data) - 1]);
    } else {
      $_SESSION['logged-user'] = trim($data[0]);
    }

    return true;
  }
  return false;
}

function updateLoggedUser($id)
{
  $query = "SELECT * FROM users WHERE `id` = ?";

  $stmt = $GLOBALS['pdo']->prepare($query);
  $stmt->execute([$id]);
  $user = $stmt->fetch();

  $_SESSION['user'] = $user;
  $data = explode(' ', $user['name']);

  if (sizeof($data) > 1) {
    $_SESSION['logged-user'] = trim($data[0]) . " " . trim($data[sizeof($data) - 1]);
  } else {
    $_SESSION['logged-user'] = trim($data[0]);
  }
}

function getUserById($id) {
  $query = "SELECT * FROM users WHERE `id` = ?";
  $stmt = $GLOBALS['pdo']->prepare($query);
  $stmt->execute([$id]);
  $user = $stmt->fetch();
  return $user;
}

function getServiceById($id) {
  $query = "SELECT * FROM `services` WHERE `id` = ?";
  $stmt = $GLOBALS['pdo']->prepare($query);
  $stmt->execute([$id]);
  return $stmt->fetch();
}

function redirect($url)
{
  header('location:' . $url);
}
