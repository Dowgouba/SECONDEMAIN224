<?php

class Database
{
     private static $dbHost = "185.98.131.109";
     private static $dbName = "secon2180201";
     private static $dbUser = "secon2180201";
     private static $dbPassword = "Aminata4@@@@";

     private static $connection = null;

     public static function connect(){
          try{
               // self::$connection = new PDO("mysql:host=". self::$dbHost . ";dbname=" . self::$dbName . ";charset=utf8", self::$dbUser, self::$dbPassword);
               // self::$connection = new PDO("mysql:host=185.98.131.109;dbname=secon2180201;charset=utf8","secon2180201","Aminata4@@@@");
               self::$connection = new PDO("mysql:host=". self::$dbHost . ";dbname=" . self::$dbName . ";charset=utf8", self::$dbUser, self::$dbPassword);
          }catch(PDOException $e){
               die($e->getMessage());
          }
          return self::$connection;
     }
     public static function disconnect(){
          self::$connection = null;
     }
}

?>
