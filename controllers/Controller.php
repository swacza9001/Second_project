<?php

abstract class Controller {
        
    protected array $data = array();
    
    protected string $view = "";
    
    protected array $header = array("title" => "", "keywords" => "", "description" => "");
    
    abstract function process (array $parameters) : void;
    
    public function renderView() : void {
        if ($this->view) {
            extract($this->safeEntities($this->data));
            extract($this->data, EXTR_PREFIX_ALL, "");
            require("views/" . $this->view . ".phtml");
        }
    }
    
    public function reroute(string $url): never
    {
        header("Location: /$url");
        header("Connection: close");
        exit;
    }
    
    private function safeEntities(mixed $x = null): mixed {
        if(!isset($x))
            return null;
        elseif(is_string($x))
            return htmlspecialchars($x, ENT_QUOTES);
        elseif(is_array($x)) {
            foreach($x as $k => $v) {
                $x[$k] = $this->safeEntities($v);
            }
            return $x;
        } else 
            return $x;
    }
    
    public function verifyUser(bool $admin = false): void {
        $userManager = new UserManager();
        $user = $userManager->getUser();
        if(!$user || ($admin && !$user['admin'])) {
            $this->addMessage('Nemáte dostatečná oprávnění.');
            $this->reroute('signIn');
        }
    }
    
    public function addMessage(string $style, string $message): void {
        if (isset($_SESSION['messages'])){
            $_SESSION['messages'][] = array('style' => $style, 'message' => $message);
        }else{
            $_SESSION['messages'] = array(array('style' => $style, 'message' => $message));
            
        }
    }
    
    public function getMessages(): array
    {
        if (isset($_SESSION['messages'])) {
            $messages = $_SESSION['messages'];
            unset($_SESSION['messages']);
            return $messages;
        } else 
            return array();
    }
}