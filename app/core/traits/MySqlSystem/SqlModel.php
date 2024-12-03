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
        try {

            $check = $this->sqlFind($id);
            if ($check == null) {
                return $check;
            }

            $columns = array_keys($arrayData);
            $setClause = implode(',', array_map(fn($col) => "$col=:$col", $columns));
            $sql = "UPDATE TABLE $this->schema SET $setClause,updated_at=:updated_at WHERE id=:id";
            $arrayData['updated_at'] = date('Y-m-d');
            $arrayData['id'] = $id;
            $stmt=$this->conn->prepare($sql);
             $result=$stmt->execute($arrayData);
            if ($result->rowCount() > 0) {
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
            return $stmt->fetch(PDO::FETCH_ASSOC);
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
            } 

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
