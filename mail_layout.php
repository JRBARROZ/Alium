<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    p, a {
      font-family: "Nunito-Regular";
      font-size: 1.75em;
      font-style: normal;
      font-weight: 400;
      line-height: 1em;
      letter-spacing: 0em;
      text-align: left;
    }
  </style>
</head>
<?php
$token = md5(random_int(2,100000));
?>
<body>
  <h2>Olá, <?= $_SESSION['user']['name'] ?></h2>
  <p>Você está recebendo este e-mail porque solicitou recuperação da senha. Clique no link abaixo para iniciar o processo de recuperação.</p>
  <a href="http://localhost:8000/forgot_password.php?user=<?= $_SESSION['user']['email'] ?>&token=<?= $token ?>">Clique aqui para recuperar a senha</a>
</body>

</html>