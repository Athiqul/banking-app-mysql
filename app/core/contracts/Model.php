<?php 
namespace App\core\Contracts;

interface Model{
    public function save(array $user);
    public function update($needle,array $data);
    public function delete();
    public function findByEmail($email);
    public function all();
    public function paginate($perPage);
    public function count();
    public function where($column, $value);
    public function orderBy($column, $order);
    public function join($table, $foreignKey, $localKey);
    public function with($relations);
    public function whereIn($column, $values);
    public function whereNotIn($column, $values);
    public function first();
    
}

?>