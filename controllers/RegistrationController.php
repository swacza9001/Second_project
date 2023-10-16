<?php

class RegistrationController extends Controller {
    /**
     * registrace
     * @param array $parameters
     * @return void
     */
    public function process(array $parameters): void {
        $this->header['title'] = 'Registrace';
        
        if($_POST) {
            try {
                $userManager = new UserManager();
                $userManager->signIn($_POST['name'], $_POST['password'], $_POST['year']);
                $userManager->logIn($_POST['name'], $_POST['password']);
                $this->addMessage('success', 'Byl jste úspěšně zaregistrován.');
                $this->reroute('administration');
            } catch (UserException $ex) {
                $this->addMessage($ex->getMessage());
            }
        }
        
        $this->view = 'registration';
    }
    
}