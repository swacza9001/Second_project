<?php

class AdministrationController extends Controller {
    
    public function process(array $parameters): void {
        $this->verifyUser();
        
        $this->header['title'] = 'Přihlášení';
        
        $userManager = new UserManager();
        
        if(!empty($parameters[0]) && $parameters[0] == 'logOut') {
            $userManager->logOut();
            $this->reroute('logIn');
        }
        
        $user = $userManager->getUser();
        $this->data['name'] = $user['name'];
        $this->data['admin'] = $user['admin'];
        
        $this->view = 'administration';    
    }
    
}