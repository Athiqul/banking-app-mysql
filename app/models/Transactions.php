<?php 
namespace App\Models;

class Transactions extends Model{

    public $schema='transactions';

    public function __construct()
  {
      if(DB=='file')
      {
        $this->schema.='.json';
      }
  }
}

?>