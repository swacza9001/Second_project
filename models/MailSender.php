<?php

class MailSender {
    
    public function sendMail(string $receiver, string $subject, string $message, string $sender) : bool {
        $header = "From: " . $sender;
        $header .= "\nMIME-Version: 1.0\n";
        $header .= "Content-Type: text/html; charset=\"utf-8\"\n";
        return mb_send_mail($receiver, $subject, $message, $header);
    }
}