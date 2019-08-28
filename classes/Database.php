<?php
class DB {

    private static function connect() {
        $pdo = new PDO('mysql:host=localhost;dbname=hcd', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }    

    public static function query($query, $params = array()) {
        $pdo = self::connect();
        $obj = $pdo->prepare($query);
        $obj->execute($params);

        if (explode(' ', $query)[0] == 'SELECT') {
            $data = $obj->fetchAll(PDO::FETCH_ASSOC);
            
            return $data;
        }
    }
}