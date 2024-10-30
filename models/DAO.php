<?php
define("DB_HOST","mysql:host=localhost;dbname=phpproejct");
define("DB_USER","root");
define("DB_PASS", "123456789");


abstract class DAO{
   public $host   = DB_HOST;
   public $user   = DB_USER;
   public $pass   = DB_PASS;
 
   public $link;
   public $error;
   public function __construct() {
      try {
          $this->link = new PDO($this->host, $this->user, $this->pass);
          $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
      } catch (PDOException $e) {
          $this->error = "Connection failed: " . $e->getMessage();
          
      }
  }
 abstract public function getById(int $objectid): Object ;
 abstract public function addObject(Object $object): bool ;
 abstract public function deleteObject(int $objectid): bool;
 abstract public function updateObject(Object $object): bool;
 }




  
 

?>
 