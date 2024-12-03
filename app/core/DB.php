<?php
namespace App\core;

use PDO;

class DB{
   private $conn=null;

   public function connect()
   {
       try {
        if($this->conn!=null)
        {
            return $this->conn;//already connected
        }
        $dsn="mysql:host=".DB_HOST.";charset=utf8mb4"  ;
        $this->conn= new PDO($dsn,DB_USER,DB_PASS);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
        $this->checkAndCreateDb();

        $this->conn->exec("USE ".DB_NAME);

        return $this->conn;

       }
       catch(\PDOException $e)
       {
         dd($e->getMessage());
       }
   }

   private function checkAndCreateDb()
   {
       try {

        $sql="CREATE DATABASE IF NOT EXISTS ".DB_NAME;
        $this->conn->exec($sql);
       }

       catch(\PDOException $e)
       {
           dd($e->getMessage());
       }
     

   }
}
?>