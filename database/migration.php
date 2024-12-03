<?php 
require_once __DIR__ .'/../vendor/autoload.php';
require_once __DIR__ .'/../config/app.php';
use App\core\DB;
$db= new DB();
$conn=$db->connect();

//Create tables
$queryUser="
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(50) NOT NULL DEFAULT 'customer', 
        balance INT(12) NOT NULL,
        created_at DATETIME NULL,
        updated_at DATETIME NULL
    )
";

$queryTransactions = "
    CREATE TABLE IF NOT EXISTS transactions (
        id INT AUTO_INCREMENT PRIMARY KEY,            
        userId INT NOT NULL,
        userEmail VARCHAR(255) NOT NULL,              
        userBalance INT(12) NOT NULL,        
        type INT NOT NULL,                            
        amount INT(10) NOT NULL,                
        trxid VARCHAR(255) NOT NULL UNIQUE,                  
        receiverId INT DEFAULT NULL,        
        created_at DATETIME DEFAULT NULL,            
        updated_at DATETIME DEFAULT NULL, 
        CONSTRAINT user_fk FOREIGN KEY(userId) References users(id),            
        CONSTRAINT user_receiver_fk FOREIGN KEY(receiverId) References users(id)
    )
";
try {
    $conn->exec($queryUser);
    $conn->exec($queryTransactions);
    echo "Migration done";
}
catch(\Exception $e)
{
    echo $e->getMessage();
}


?>