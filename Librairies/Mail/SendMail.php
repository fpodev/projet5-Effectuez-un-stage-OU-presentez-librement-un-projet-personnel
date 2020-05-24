<?php
namespace App\Mail;
/*
Author: fpodev (fpodev@gmx.fr)
SendMail.php (c) 2020
Desc: Script envoir de mail de confirmation création de nouvel utilisateur.
      Les options laissées en commentaire pour une future utilisation eventuelle
Created:  2020-05-24T13:57:19.584Z
Modified: !date!
*/


// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class SendMail{
        
            private $destinataire;
            private $sujet;
            private $message;
     
    public function __construct(){      
        $this->mail = new PHPMailer(true);
    }

    public function mail($destinataire, $sujet, $message){

    // Instantiation and passing `true` enables exceptions
     $mail = new PHPMailer(true);

    try {
        //Server settings
       // $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $this->mail->SetLanguage('fr','phpmailer/language/');
        $this->mail->CharSet = "UTF-8";
        $this->mail->isSMTP();                                            // Send using SMTP
        $this->mail->Host       = 'mail.gmx.com ';                    // Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $this->mail->Username   = '***';                     // SMTP username
        $this->mail->Password   =  ****;                               // SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPthis->maile::rENCRYPTION_SMTPS` encouraged
        $this->mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPthis->mailer::ENCRYPTION_SMTPS` above

        //Recipients
        $this->mail->setFrom('ne-pas-repondre@gmx.ca', 'Administrateur GMAO');
        $this->mail->addAddress($destinataire);     // Add a recipient
       // $this->mail->addAddress('ellen@example.com');               // Name is optional
        //$this->mail->addReplyTo('info@example.com', 'Information');
       // $this->mail->addCC('cc@example.com');
        //$this->mail->addBCC('bcc@example.com');

        // Attachments
       // $this->mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $this->mail->isHTML(true);                                  // Set this->mail format to HTML
        $this->mail->Subject = $sujet;
        $this->mail->Body    = $message;
      //  $this->mail->AltBody = 'This is the body in plain text for non-HTML this->mail clients';

        $this->mail->send();
        echo 'L\'utilisateur à bien été ajouté. Un courriel de confirmation lui à été envoyé';
    } catch (Exception $e) {
        echo " Erreur lors de l'envoie du courriel: {$this->mail->ErrorInfo}";
    }
    }
}
