<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/phpmailer/src/Exception.php';
require_once __DIR__ . '/vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/phpmailer/src/SMTP.php';

// passing true in constructor enables exceptions in PHPMailer
$mail = new PHPMailer(true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['floatingName']);
    $email = sanitizeInput($_POST['floatingEmail']);
    $company = sanitizeInput($_POST['floatingCompany']);
    $phone = sanitizeInput($_POST['floatingPhone']);
    $subject = sanitizeInput($_POST['floatingSubject']);
    $query = sanitizeInput($_POST['floatingtextarea']);


    $message = "Name - " . $name . "<br/>Email: - " . $email . "<br/>" . "Company - $company<br/> Phone - $phone<br/>Query -$query";


try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com';     //SMTP Host                 
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = '';                     //SMTP username
    $mail->Password   = '';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
    $mail->Port       = 465;                                    

    //Recipients
    $mail->setFrom(''); //Sender
    $mail->addAddress(''); //Reciever

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}


function sanitizeInput($input) {
   $input = trim($input);
   $input = stripslashes($input);
   $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
   return $input;
}
?>

<html>
  <body>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <form action="/pc/email/php_i2.php"method="post" id="contact-form">
      <h2>Contact us</h2>
      <p>
        <label>Name:</label>
        <input name="floatingName" type="text" required />
      </p>
      <p>
        <label>Email Address:</label>
        <input style="cursor: pointer;" name="floatingEmail" type="email" required />
      </p>
      <p>
        <label>Company:</label>
        <input name="floatingCompany" type="text" required />
      </p>
      <p>
        <label>Phone:</label>
        <input name="floatingPhone" type="text" required />
      </p>
      <p>
        <label>Subject:</label>
        <input name="floatingSubject" type="text" required />
      </p>
      <p>
        <label>Query:</label>
        <textarea name="floatingtextarea" required></textarea>
      </p>
      <p>
        <button
        type="submit"
        >
          Submit
        </button>
      </p>
    </form>

    <script>
    function onRecaptchaSuccess() {
      document.getElementById('contact-form').submit();
    }
    </script>
  </body>
</html>
