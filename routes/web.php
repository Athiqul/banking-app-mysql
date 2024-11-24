<?php

use App\Controllers\admin\Customers;
use App\core\Route;
use App\Controllers\Auth;
use App\Controllers\admin\Dashboard;
use App\Controllers\admin\Transactions;
use App\Controllers\customers\Dashboard as CustomersDash;
use App\Controllers\customers\Deposit;
use App\Controllers\customers\Transfer;
use App\Controllers\customers\Withdraw;

$route=new Route();

// Define your routes here
$route->get('/',\App\Controllers\Home::class,'index');

$route->get('/login', Auth::class,'login');
$route->post('/login-user', Auth::class,'checkLogin');
$route->get('/register',Auth::class,'register');
$route->post('/register', Auth::class,'storeUser');
//Logout 
$route->get('/logout',Auth::class,'logout');
       //Customers Route
    $route->get('/customers-dashboard',CustomersDash::class,'index');
    $route->get('/customers-deposit',Deposit::class,'depositView');
    $route->post('/customers-deposit',Deposit::class,'depositStore');
    $route->get('/customers-withdraw',Withdraw::class,'withdrawView');
    $route->post('/customers-withdraw',Withdraw::class,'withdrawAmount');
    $route->get('/customers-transfer',Transfer::class,'transferView');
    $route->post('/customers-transfer',Transfer::class,'transferAmount');

     //Admin Route
    $route->get('/admin-dashboard',Dashboard::class,'index');
    $route->get('/admin-customer-add',Customers::class,'create');
    $route->post('/admin-customer-add',Customers::class,'store');
    $route->get('/admin-customers-transaction-history',Transactions::class,'allHistory');
    $route->get('/admin-customer-transaction/{id}',Transactions::class,'userHistory');


   




$route->route();

?>