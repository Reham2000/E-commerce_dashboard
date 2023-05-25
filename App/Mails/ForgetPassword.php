<?php 
namespace App\Mails;

use App\Mails\Contract\Mail;
use PHPMailer\PHPMailer\Exception;

class ForgetPassword extends Mail {
    public const MAIL_FROM_NAME = "Ecommerce Team";
    public function send(string $mailTo,string $subject, string $body) :bool
    {
        try{
            $this->mail->setFrom(self::MAIL_FROM, self::MAIL_FROM_NAME);
            $this->mail->addAddress($mailTo);     
            $this->mail->isHTML(true);         
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
            $this->mail->send();
            return true;
        }catch(Exception $e){
            return false;
        }
    }
}