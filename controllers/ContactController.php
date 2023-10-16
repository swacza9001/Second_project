<?php

class ContactController extends Controller {
    /**
     * Kontaktní formulář
     * @param array $parameters parametry v URL
     * @return void
     */
    public function process(array $parameters): void {
        $this->header = array(
            'title' => 'Kontaktní formulář',
            'keywords' => 'formulář, email, zpráva',
            'description' => 'Kontaktní formulář - pošlete nám zprávu',
        );
        
        if (isset($_POST['email'])) {
            if ($_POST['year'] == date("Y")) {
                $mailSender = new MailSender();
                $mailSender->sendMail("tomas.swaczyna@gmail.com", "Mail z webu akordů", $_POST['message'], $_POST['email']);
            }
        }
        
        $this->view = 'contact';
    }
}