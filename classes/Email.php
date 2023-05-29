<?php 

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $fullName;
    public $token;

    public function __construct($email, $fullName, $token) {
        $this->email = $email;
        $this->fullName = $fullName;
        $this->token = $token;
    }

    public function sendEmail() {
        // Creamos el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '9c6fd3a5e10451';
        $mail->Password = 'e947aad2035306';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = "Confirma tu cuenta";

        $mail->isHTML();
        $mail->CharSet = "UTF-8";

        $content = "<html><p><strong>Hola {$this->fullName}</strong> has creado tu cuenta en App Salon <br> Has click <a href='http://localhost:3000/confirmAccount?token={$this->token}' target='_blank'>aquí</a> para confirmar y comenzar</p>";

        $content .= "<p>Si no solicito esta cuenta, por favor ignorar este mensaje</p></html>";

        $mail->Body = $content;

        $mail->send();
    }
}