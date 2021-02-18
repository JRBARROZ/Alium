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
  $pass = 'root';
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

function login($username, $password)
{

  $query = "SELECT * FROM users WHERE `username` = ? AND `password` = ? OR `email` = ? AND `password` = ?";

  $stmt = $GLOBALS['pdo']->prepare($query);

  $stmt->execute([$username, $password, $username, $password]);
  $user = $stmt->fetch();

  $row = $stmt->rowCount();

  if ($row == 1) {
    $_SESSION['user'] = $user;
    $data = explode(' ', $user['name']);

    if (sizeof($data) > 1) {
      $_SESSION['logged-user'] = trim($data[0]) . " " . trim($data[sizeof($data)-1]);
    } else {
      $_SESSION['logged-user'] = trim($data[0]);
    }
    
    return true;
  }
  return false;
}

function redirect($url)
{
  header('location:' . $url);
}
