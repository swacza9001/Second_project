<?php

class MailSender {
    /**
     * odeslání mailu
     * @param string $receiver 
     * @param string $subject
     * @param string $message
     * @param string $sender
     * @return bool
     */
    public function sendMail(string $receiver, string $subject, string $message, string $sender) : bool {
        $header = "From: " . $sender;
        $header .= "\nMIME-Version: 1.0\n";
        $header .= "Content-Type: text/html; charset=\"utf-8\"\n";
        return mb_send_mail($receiver, $subject, $message, $header);
    }
}