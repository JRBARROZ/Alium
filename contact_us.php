<?php
require 'init.php';

require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['message'])) {

  $user_email = addslashes(trim($_POST['email']));
  $subject = addslashes(trim($_POST['assunto']));
  $user_message = addslashes(trim($_POST['message']));
  $user_name = addslashes(trim($_POST['name']));

  $mail = new PHPMailer(true);
  $mailFrom = $user_email;
  $mailTo = 'project.alium@gmail.com';

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
  <p>
    Email: " . $mailFrom . "<br>
    Usuário: " . $user_name . "<br>
  </p>
  <p>" . $user_message . " </p>
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
    $mail->setFrom($mailFrom, 'Feedback Alium');
    $mail->addAddress($mailTo);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    if ($mail->send()) {
      $_SESSION['feedback_sended'] = true;
      redirect('index.php');
    }
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}
