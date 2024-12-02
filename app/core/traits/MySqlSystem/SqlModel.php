<?php
namespace App\core\traits\MySqlSystem;

use Exception;
trait SqlModel{
    public function sqlSave(array $arrayData)
    {
        $columns=implode(',',array_keys($arrayData)).',created_at,updated_at';
        $values=':'.implode(',:',array_keys($arrayData)).',:created_at,:updated_at';
       $sql="INSERT INTO ".$this->schema. " ($columns) values($values)";

       $this->conn->prepare($sql);
       $arrayData['created_at']=date('Y-m-d');
       $arrayData['updated_at']=date('Y-m-d');
       $this->conn->execute($arrayData);

       $this->conn->lastInsertId();

    }

    public function sqlFind(string $id)
    {
        $sql="SELECT * FROM ".$this->schema;    
    }
    public function sqlUpdate($userEmail, array $arrayData)
    {
       
      
    }
   
    public function sqlFindByEmail($email)
    {
      
    }
    public function sqlAll($column = '', $value = '')
    {
        
       
    }
 
    public function sqlWhere($column, $value)
    {

       
    }
 


  
  
}
?>