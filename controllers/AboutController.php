<?php

class AboutController extends Controller {
    
    public function process(array $parameters): void {
        $this->header = array(
            'title' => 'Úvodní stránka',
            'keywords' => 'úvod, akordy',
            'description' => 'Vítejte na stránce akordy, najděte píseň podle akordů',
        );
        
        
        $this->view = 'about';
    }
}