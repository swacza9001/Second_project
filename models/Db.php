<?php

class Db {
    
    private static PDO $connection;
    
    private static array $settings = array (
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,
    );
    
    public static function connect (string $host, string $user, string $password, string $dbName): void {
        if (!isset(self::$connection)) {
            self::$connection = new PDO ("mysql:host=$host;dbname=$dbName", $user, $password, self::$settings);
        }
    }
    
    public static function queryOne(string $query, array $parameters = array()): array|bool {
        $return = self::$connection->prepare($query);
        $return->execute($parameters);
        return $return->fetch();
    }
    
    public static function queryAll(string $query, array $parameters = array()): array|bool {
        $return = self::$connection->prepare($query);
        $return->execute($parameters);
        return $return->fetchAll();
    }
    
    public static function fetchColumn(string $query, array $parameters = array()): array|bool {
        $return = self::$connection->prepare($query);
        $return->execute($parameters);
        return $return->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public static function fetchAssociated(string $query, array $parameters = array()): array|bool {
        $return = self::$connection->prepare($query);
        $return->execute($parameters);
        return $return->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function query(string $query, array $parameters = array()): int {
        $return = self::$connection->prepare($query);
        $return->execute($parameters);
        return $return->rowCount();
    }
    
    public static function lastId(): int {
        return self::$connection->lastInsertId();
    }
    
    public static function insert(string $table, array $parameters = array()): bool {
        return self::query("INSERT INTO $table (". 
                implode(', ', array_keys($parameters)).
                ") VALUES (". str_repeat('?, ', sizeof($parameters)-1)."?)",
                array_values($parameters));
    }
    
    public static function update(string $table, array $values, string $condition, array $parameters = array()) : bool {
        return self::query("UPDATE $table SET ".
                implode(' = ?, ', array_keys($values)).
                " = ? " . $condition,
                array_merge(array_values($values), $parameters));
    }
}