<?php

class LogInController extends Controller {
    
    public function process(array $parameters): void {
        $userManager = new UserManager();
        if($userManager->getUser())
            $this->reroute('administration');
        $this->header['title'] = 'Přihlášení';
        if($_POST) {
            try {
                $userManager->logIn($_POST['name'], $_POST['password']);
                $this->addMessage('success', 'Jste přihlášen.');
                $this->reroute('administration');
            } catch (UserException $ex) {
                $this->addMessage('danger', 'Neplatné přihlašovací údaje.');
            }
        }
        $this->view = 'logIn';
    }
}