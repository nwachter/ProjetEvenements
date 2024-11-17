<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function mail_utf8($to, $from_user, $from_email, $subject = '(Aucun sujet)', $message = '')
{
    $from_user = "=?UTF-8?B?" . base64_encode($from_user) . "?=";
    $subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";

    // $headers = "From: $from_user <$from_email>\r\n" .
    //     "MIME-Version: 1.0" . "\r\n" .
    //     "Content-type: text/html; charset=UTF-8" . "\r\n";
    $headers = "From: " . $from_user . " <" . $from_email . ">\r\n" .
        "MIME-Version: 1.0" . "\r\n" .
        "Content-type: text/html; charset=UTF-8" . "\r\n" . "X-Mailer: PHP/" . phpversion();
    echo $subject . "<br>" . $headers . "<br>";

    return mail($to, $subject, $message, $headers);
}

function verifContact($array)
{
    global $error_message, $message;
    if (empty($array['sujet']) && empty($array['email']) && empty($array['message'])) {
        $error_message .= "Veuillez remplir les champs.<br />";
    } else {
        $error_message = "";

        if (empty($array['sujet'])) {
            $error_message .= "Le sujet est vide.<br />";
            $array = array();
        }

        if (empty($array['email']) || !filter_var($array['email'], FILTER_VALIDATE_EMAIL)) {
            $error_message .= "L'email est invalide.<br />";
            $array = array();
        }

        if (empty($array['message'])) {
            $error_message .= "Le champ message est vide.<br />";
            $error_message = "*";
            $array = array();
        }

        if (!empty($array['sujet']) && !empty($array['email']) && !empty($array['message']) && filter_var($array['email'], FILTER_VALIDATE_EMAIL)) {
            $error_message = "";

            return true;
        }
        echo $error_message;
        return false;
    }
}



function sendMail($to = "trashkan18@gmail.com", $from_user = "NinjaEvents", $from_email = "ninjaevents@zohomail.eu", $subject = '(Aucun sujet)', $message = 'Bonjour,<br /> Je vous contacte depuis NinjaEvents.')
{

    require 'vendor/autoload.php';

    $password = $_ENV['MAIL_APP_PASSWORD'];


    $mail = new PHPMailer(true);
    try {

        // //Expéditeur
        // $mail->setFrom($from_email, $from_user);
        $mail->isSMTP();
        $mail->Host       = 'smtp.zoho.eu';
        $mail->SMTPAuth   = true;
        $mail->Username   = $from_email;
        //  $mail->Password   = 'Q226neH1b3NJ';
        $mail->Password   = $_ENV['MAIL_APP_PASSWORD'];
        echo "<p class='text-white'>" . "TO : " . $to . " - FROMUSER :" . $from_user . " - FROMEMAIL " . $from_email . " - SUBJECT : " . $subject . " - Message : " . $message . " - PASSWORD  " . $_ENV['MAIL_APP_PASSWORD'] . "</p>";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->SMTPDebug = 3;
        $mail->Debugoutput = function ($str, $level) {
            error_log("PHPMailer Debug: $str");
        };

        // Expéditeur (utilisateur)
        $mail->setFrom($from_email, $from_user);

        //Destinataire
        $mail->addAddress($to);

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );


        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";
        $mail->Subject = $subject;
        $mail->Body    = $message;

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }

        return $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        error_log("Erreur PHPMailer: " . $mail->ErrorInfo);
    }
}
