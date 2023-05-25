<?php

namespace App\Mails\Contract;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

abstract class Mail
{
    protected const MAIL_FROM = 'nti67@outlook.com';
    private const MAIL_PASSWORD = 'Nti2022##';
    private const MAIL_HOST = 'smtp-mail.outlook.com';
    private const MAIL_PORT = 587;
    protected PHPMailer $mail;
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->mail->isSMTP();
        $this->mail->Host       = self::MAIL_HOST;
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = self::MAIL_FROM;
        $this->mail->Password   = self::MAIL_PASSWORD;
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = self::MAIL_PORT;
    }
    public abstract function send(string $mailTo, string $subject, string $body): bool;
}
