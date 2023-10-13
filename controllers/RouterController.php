<?php

class RouterController extends Controller {
    
    protected Controller $controller;
    
    public function process(array $parameters): void {
        $parsedURL = $this->parseURL($parameters[0]);
        
        if (empty($parsedURL[0]))
            $this->reroute('about'); // vytvořit about stránku
        $controllerClass = $this->dashToCamel(array_shift($parsedURL)) . 'Controller';
        if (file_exists('controllers/' . $controllerClass . '.php'))
                $this->controller = new $controllerClass;
        else
            $this->reroute('error');
        
        $this->controller->process($parsedURL);
        
        $this->data['title'] = $this->controller->header['title'];
        $this->data['description'] = $this->controller->header['description'];
        $this->data['keywords'] = $this->controller->header['keywords'];
        $this->data['messages'] = $this->getMessages();
        $this->view = 'template';
    }
    
    private function parseURL(string $url): array {
        $parsedURL = parse_url($url);
        $parsedURL["path"] = ltrim($parsedURL["path"], "/");
        $parsedURL["path"] = trim($parsedURL["path"]);
        $explodedPath = explode("/", $parsedURL["path"]);
        return $explodedPath;
    }
    
    private function dashToCamel(string $text): string {
        $sentence = str_replace('-', ' ', $text);
        $sentence = ucwords($sentence);
        $sentence = str_replace(' ', '', $sentence);
        return $sentence;
    }
    
}