<?php

class UserManager {
    
    public function getHash(string $password): string {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    public function signIn(string $name, string $password, string $year): void {
        if ($year != date('Y'))
            throw new UserException('Špatně jsi vyplnil antispam.');
        $user = array(
            'name' => $name,
            'password' => $this->getHash($password),
        );
        try {
            Db::insert('users', $user);
        } catch (PDOException $ex) {
            throw new UserException('Uživatel s tímto jménem je již zaregistrovaný.');
        }
    }
    
    public function logIn(string $name, string $password): void {
        $user = Db::queryOne('SELECT user_id, name, admin, password '
                . 'FROM users '
                . 'WHERE name = ?', 
                array($name));
        if(!$user || !password_verify($password, $user['password']))
                throw new UserException('Neplatné přihlašovací údaje.');
        $_SESSION['user'] = $user;
    }
    
    public function logOut(): void {
        unset($_SESSION['user']);
    }
    
    public function getUser(): ?array {
        if(isset($_SESSION['user']))
            return $_SESSION['user'];
        return null;
    }
}