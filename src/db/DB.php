<?php

namespace App\Db; 

use PDO;
use PDOException;

class DB{
    private static function connect(){
        $servername = $_ENV['DB_SERVER'];
        $username   = $_ENV['DB_USERNAME'];
        $password   = $_ENV['DB_USERPASS'];
        $dbname     = $_ENV['DB_NAME'];

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }

    public static function query($query, $params=array()){
        $exploded = explode(' ', $query)[0];
        $conn = self::connect();
        $statement = $conn->prepare($query);
        try { 
            $statement->execute($params); 
            if($exploded == 'select' || $exploded == 'Select' || $exploded == 'SELECT'){
                $data = $statement->fetchAll();
                return [
                    'status' => '1',
                    'count'  => count($data),
                    'data'    => $data                 
                ];
            }
            return [
                'status' => '1',
                'msg'    => 'Operation Done Successfully.',                 
            ];
        } catch (PDOException $e) {
            return [
                'status' => '0',
                'code'  => $e->getCode(),
                'msg'   => $e->errorInfo[2],
                'e_msg'  => $e->getMessage()
            ];
        }  
    
    }
}