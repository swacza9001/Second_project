<?php

class AboutController extends Controller {
    /**
     * 
     * @param array $parameters parametry v URL
     * @return void
     */
    public function process(array $parameters): void {
        $this->header = array(
            'title' => 'Úvodní stránka',
            'keywords' => 'úvod, akordy',
            'description' => 'Vítejte na stránce akordy, najděte píseň podle akordů',
        );
        
        
        $this->view = 'about';
    }
}