<?php 
namespace App\core\Contracts;

interface Model{
    public function save(array $user);
    public function update($needle,array $data);
    public function findByEmail($email);
    public function all();
    public function where($column, $value);
    
}

?>