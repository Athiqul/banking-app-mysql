<?php 
namespace App\Models;

use App\core\Contracts\Model;
use App\core\traits\filesystem\FileDbTrait;
//require __DIR__.'/../core/traits/filesystem/FileDbTrait.php';
class User implements Model{
  use FileDbTrait;
  public $schema="user.json";//Table or file name

}

?>