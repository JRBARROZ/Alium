<?php
require_once 'init.php';

if (isLogged()) {
  redirect('index.php');
  exit();
}

require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$mailFrom = 'project.alium@gmail.com';
$user = $_SESSION['user-recovery'];
$mailTo = $user['email'];
$token = md5(random_int(PHP_INT_MIN,PHP_INT_MAX));
$token_date = time();

$query = "UPDATE `users` SET `token` = ?, `token_date` = ? WHERE `id` = ?";
$stmt = $GLOBALS['pdo']->prepare($query);
$stmt->execute([$token, $token_date, $user['id']]);

$body = "
<!DOCTYPE html>
<html lang='pt-br'>

<head>
  <meta charset='UTF-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <link href='https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap' rel='stylesheet'>
  <style>

  .inputButton {
    width: 200px;
    height: 41px;
    background-color: #0E2548;
    color: white;
    font-family: 'Nunito', sans-serif;
    font-size: 24px;
    border: none;
    padding: 8px 8px;
    outline: none;
    cursor: pointer;
    transition: 1s;
}
  h1{
    color: rgb(77 ,97,128);
    font-family: 'Nunito', sans-serif;
    font-size: 35px;
}
  h2{
    font-family: 'Nunito', sans-serif;
    font-size: 24px;
}
a{
color: white !important;
text-decoration:none;
}
  </style>
</head>
<body>
  <img src='aliumLogo.png' alt=''>
  <h1>Recuperação de Senha</h1>
  <h2>Olá, " . $user['name'] . "</h2><br>
  <h2>Verificamos que você solicitou a troca de sua<br>
  senha. Para continuar, clique no botão abaixo.<br>
  O link para redefinição irá expirar em 15 minutos.
  </h2>
  <button class='inputButton'>
  <a href='http://localhost:8000/recovery_password.php?user=" . md5($user['id']) . $user['id'] . '&token=' . $token . "'>Redefinir Senha</a> 
  </button>
</body>

</html>
";

try {
  //Server settings
  // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
  $mail->CharSet = "UTF-8";
  $mail->isSMTP();                                            //Send using SMTP
  $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
  $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
  $mail->Username   = 'project.alium@gmail.com';              //SMTP username
  $mail->Password   = 'alium1973';                            //SMTP password
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
  $mail->WordWrap   = 55;
  $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

  //Recipients
  $mail->setFrom($mailFrom, 'Equipe Alium');
  $mail->addAddress($mailTo);     //Add a recipient
  // $mail->addAddress('ellen@example.com');               //Name is optional
  // $mail->addReplyTo('btsp@discente.ifpe.edu.br', 'Information');
  // $mail->addCC('cc@example.com');
  // $mail->addBCC('bcc@example.com');

  //Attachments
  // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
  // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

  //Content
  $mail->isHTML(true);                                  //Set email format to HTML
  $mail->Subject = 'Recuperação de Senha';
  $mail->Body    = $body;
  // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

  if ($mail->send()) {
    $_SESSION['success-recovery'] = true;
    redirect('forgot_password.php');
  }

} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>