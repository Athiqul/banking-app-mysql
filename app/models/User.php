<?php 
namespace App\Models;


class User extends Model{

  public $schema="users";//Table or file name

  public function __construct()
  {
      if(DB=='file')
      {
        $this->schema.='.json';
      }

      parent::__construct();
  }
}

?>