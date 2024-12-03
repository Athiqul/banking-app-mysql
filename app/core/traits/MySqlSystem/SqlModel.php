<?php

namespace App\core\traits\MySqlSystem;

use Exception;
use PDO;
use PDOException;

trait SqlModel
{

    public function sqlSave(array $arrayData)
    {
        unset($arrayData['id']);
       
        try {
            $columns = implode(',', array_keys($arrayData)) . ',created_at,updated_at';
            $values = ':' . implode(',:', array_keys($arrayData)) . ',:created_at,:updated_at';
            $sql = "INSERT INTO " . $this->schema . " ($columns) values($values)";

            $stmt=$this->conn->prepare($sql);
            $arrayData['created_at'] = date('Y-m-d');
            $arrayData['updated_at'] = date('Y-m-d');
            $stmt->execute($arrayData);

            $lastId = $this->conn->lastInsertId();
            return $this->sqlFind($lastId);
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    public function sqlFind(string $id)
    {
        try {
            $sql = "SELECT * FROM " . $this->schema . " WHERE id=:id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }
    public function sqlUpdate(string $id, array $arrayData)
    {
        //dd($arrayData);
        try {
            if(filter_var($id,FILTER_VALIDATE_EMAIL))
            {
                $check=$this->sqlFindByEmail($id);
            }else{
                $check = $this->sqlFind($id);
            }
            
            if ($check == null) {
                return $check;
            }

            unset($arrayData['updated_at']);

            //dd($arrayData);

            $columns = array_keys($arrayData);
            $setClause = implode(',', array_map(fn($col) => "$col=:$col", $columns));
            $sql = "UPDATE $this->schema SET $setClause,updated_at=:updated_at WHERE id=:id";
            $arrayData['updated_at'] = date('Y-m-d');
            $arrayData['id'] = $check['id'];
           // dd($sql);
            $stmt=$this->conn->prepare($sql);
            $stmt->execute($arrayData);
            if ($stmt->rowCount() > 0) {
                return $this->sqlFind($id);
            }
            return null;
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    public function sqlFindByEmail($email)
    {
        try {
            $sql = "SELECT * FROM " . $this->schema . " WHERE email=:email";
           $stmt=$this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC)?:null;
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }
    public function sqlAll($column = '', $value = '')
    {
       
        
        try {
            $sql = "SELECT * FROM " . $this->schema;
            if ($column !== '') {
                $sql .= " WHERE $column=:$column";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([":$column"=>$value]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } 
            
            //dd($sql);

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    public function sqlWhere($column, $value)
    {
        // dd($column.' '.$value);

        try {
            $sql = "SELECT * FROM " . $this->schema . " WHERE $column=:$column";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([":$column" => $value]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }
}
