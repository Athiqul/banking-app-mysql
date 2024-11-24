<?php 
namespace App\Models;

use App\core\Contracts\Model;
use App\core\traits\filesystem\FileDbTrait;
class Transactions implements Model{

    use FileDbTrait;
    public $schema='transactions.json';
}

?>