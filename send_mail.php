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
  <style>
    p, a {
      font-family: 'Nunito-Regular';
      font-size: 1.25em;
      font-style: normal;
      font-weight: 400;
      line-height: 1em;
      letter-spacing: 0em;
      text-align: left;
    }
  </style>
</head>
<body>
  <h2>Olá, " . $user['name'] . "</h2>
  <p>Você está recebendo este e-mail porque solicitou recuperação da senha.<br>
  Clique no link abaixo para iniciar o processo de recuperação.</p>
  <a href='http://localhost:8000/recovery_password.php?user=" . md5($user['id']) . $user['id'] . "&token=" . $token . "'>Clique aqui para recuperar a senha</a>
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