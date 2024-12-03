<?php 
require_once __DIR__ .'/../vendor/autoload.php';
require_once __DIR__ .'/../config/app.php';

use App\core\DB;
$db = new DB();
$conn = $db->connect();

// Start a transaction
try {
    $conn->beginTransaction();

    // Insert users
    $users = [
        ['name' => 'Athiqul Hasan', 'email' => 'jbc.athiqul@gmail.com', 'password' => '$2y$10$PEFSHXfeZENDmH/eRt23XOIp4uL8qk.79AWIRYrfFnxbEfA7a.hju', 'role' => 'customer', 'balance' => 199, 'created_at' => '2024-12-03 00:00:00', 'updated_at' => '2024-12-03 00:00:00'],
        ['name' => 'Test1233', 'email' => 'test@info.com', 'password' => '$2y$10$0NopSDXHLLuuZW.cwjDM/.Ng3G7T/S6I7X5lTPwLMdILTahQVOD4y', 'role' => 'customer', 'balance' => 947, 'created_at' => '2024-12-03 00:00:00', 'updated_at' => '2024-12-03 00:00:00'],
        ['name' => 'Super Admin', 'email' => 'admin@info.com', 'password' => '$2y$10$mAs6FWEBM..vL5C7tfykzeBNXqEEKhjrAoEK2BftFGYrEMY3qBg4S', 'role' => 'admin', 'balance' => 0, 'created_at' => NULL, 'updated_at' => NULL],
        ['name' => 'Test  Customer', 'email' => 'hell@yah.com', 'password' => '$2y$10$qN1pYf0.5CNV3fkTDLqdXesns5Apfpvnm1teBPaAGWlCGJmlOANYO', 'role' => 'customer', 'balance' => 0, 'created_at' => '2024-12-03 00:00:00', 'updated_at' => '2024-12-03 00:00:00']
    ];
    
    $usersQuery = "INSERT INTO users (name, email, password, role, balance, created_at, updated_at) VALUES (:name, :email, :password, :role, :balance, :created_at, :updated_at)";
    
    $stmt = $conn->prepare($usersQuery);
    
    foreach ($users as $user) {
        $stmt->execute($user);
    }
    
    // Insert transactions
    $transactions = [
        ['userEmail' => 'test@info.com', 'userBalance' => 1234, 'type' => 1, 'amount' => 1234, 'trxid' => 'DEP674eeafe231d3', 'receiverName' => '', 'receiverEmail' => '', 'balance_added' => 0, 'created_at' => '2024-12-03 00:00:00', 'updated_at' => '2024-12-03 00:00:00'],
        ['userEmail' => 'test@info.com', 'userBalance' => 1146, 'type' => 2, 'amount' => 88, 'trxid' => 'WD674eeb0774959', 'receiverName' => '', 'receiverEmail' => '', 'balance_added' => 0, 'created_at' => '2024-12-03 00:00:00', 'updated_at' => '2024-12-03 00:00:00'],
        ['userEmail' => 'test@info.com', 'userBalance' => 1046, 'type' => 3, 'amount' => 100, 'trxid' => 'TR674eeb21e92ae', 'receiverName' => 'Athiqul Hasan', 'receiverEmail' => 'jbc.athiqul@gmail.com', 'balance_added' => 0, 'created_at' => '2024-12-03 00:00:00', 'updated_at' => '2024-12-03 00:00:00'],
        ['userEmail' => 'jbc.athiqul@gmail.com', 'userBalance' => 100, 'type' => 3, 'amount' => 100, 'trxid' => 'TR674eeb21e92b4', 'receiverName' => 'Test1233', 'receiverEmail' => 'test@info.com', 'balance_added' => 1, 'created_at' => '2024-12-03 00:00:00', 'updated_at' => '2024-12-03 00:00:00'],
        ['userEmail' => 'test@info.com', 'userBalance' => 917, 'type' => 3, 'amount' => 129, 'trxid' => 'TR674eeb4407930', 'receiverName' => 'Athiqul Hasan', 'receiverEmail' => 'jbc.athiqul@gmail.com', 'balance_added' => 0, 'created_at' => '2024-12-03 00:00:00', 'updated_at' => '2024-12-03 00:00:00'],
        ['userEmail' => 'jbc.athiqul@gmail.com', 'userBalance' => 229, 'type' => 3, 'amount' => 129, 'trxid' => 'TR674eeb4407934', 'receiverName' => 'Test1233', 'receiverEmail' => 'test@info.com', 'balance_added' => 1, 'created_at' => '2024-12-03 00:00:00', 'updated_at' => '2024-12-03 00:00:00'],
        ['userEmail' => 'jbc.athiqul@gmail.com', 'userBalance' => 199, 'type' => 3, 'amount' => 30, 'trxid' => 'TR674eec16475f1', 'receiverName' => 'Test1233', 'receiverEmail' => 'test@info.com', 'balance_added' => 0, 'created_at' => '2024-12-03 00:00:00', 'updated_at' => '2024-12-03 00:00:00'],
        ['userEmail' => 'test@info.com', 'userBalance' => 947, 'type' => 3, 'amount' => 30, 'trxid' => 'TR674eec16475f8', 'receiverName' => 'Athiqul Hasan', 'receiverEmail' => 'jbc.athiqul@gmail.com', 'balance_added' => 1, 'created_at' => '2024-12-03 00:00:00', 'updated_at' => '2024-12-03 00:00:00']
    ];
    
    $transactionsQuery = "INSERT INTO transactions (userEmail, userBalance, type, amount, trxid, receiverName, receiverEmail, balance_added, created_at, updated_at) 
    VALUES (:userEmail, :userBalance, :type, :amount, :trxid, :receiverName, :receiverEmail, :balance_added, :created_at, :updated_at)";
    
    $stmt = $conn->prepare($transactionsQuery);
    
    foreach ($transactions as $transaction) {
        $stmt->execute($transaction);
    }
    
    // Commit the transaction
    $conn->commit();
    
    echo "Data inserted successfully.";
}
catch (PDOException $e)
{
    $conn->rollback();
    echo $e->getMessage();
}


?>
