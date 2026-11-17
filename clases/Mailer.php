<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    function enviarEmail($email, $asunto, $cuerpo)
    {
        require_once __DIR__ . '/../config/config.php';
        require  __DIR__ . '/../phpmailer/src/PHPMailer.php';
        require  __DIR__ . '/../phpmailer/src/SMTP.php';
        require  __DIR__ . '/../phpmailer/src/Exception.php';


        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host = MAIL_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_USER;
            $mail->Password = MAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = MAIL_PORT;

            // Recipients
            $mail->setFrom(MAIL_USER, 'CAFETERIA ESCOLAR');

            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $asunto;

            $mail->Body = mb_convert_encoding($cuerpo, 'ISO-8859-1', 'UTF-8');
            $mail->setLanguage('es', '../phpmailer/language/phpmailer.lang-es.php');

            if ($mail->send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo "Error al enviar el correo electrónico de la compra: {$mail->ErrorInfo}";
            return false;
        }
    }
}
