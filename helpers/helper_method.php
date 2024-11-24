<?php 

//For display data and die 

use App\core\RedirectHelper;


function dd($data):void
{
    echo '<pre>';
    die(print_r($data, true));
    echo '</pre>';
}

function view(string $view,array $data=[]):void
{
    $viewPath =__DIR__. "/../views/{$view}.php";
    //dd($viewPath);
    if (file_exists($viewPath)) {
        extract($data);
       require_once $viewPath;
       return;
    } else {
        dd("View not found: {$viewPath}");
    }
}

//redirect 

function redirect(){
    return new RedirectHelper();
}

function storage_path($path = '') {
    return __DIR__ . '/../storage/file/' . $path;
}

function middleware($role)
{
    if (!isset($_SESSION['user'])) {
        return redirect()->route('/login')->with(['error','You must be logged in']);
    }

    if($_SESSION['user']['role']!==$role) {

        return redirect()->route('/login')->with(['error','You do not have permission to access this page']);
    }


    return true;
}

function old($field,$value='')
{
    //dd('hi');
   if(!isset($_SESSION['old_input'])||!isset($_SESSION['old_input'][$field]))
   {
     echo $value;
     
   }else{
    echo $_SESSION['old_input'][$field];
   }
   

}

if(!function_exists('nameShort'))
{
    function nameShort(string $name)
    {
        $endIndex=strlen($name)-1;
        return strtoupper($name[0].$name[$endIndex]);
    }
}

if(!function_exists('transactionType'))
{
    function transactionType(string $type)
    {
        return match($type){
            '1'=>'DEPOSIT',
            '2'=> 'WITHDRAW',
            '3'=> 'TRANSFER',
            default => ''
        };

    }
    function isTransferType(string $type)
    {
        return $type=='3'? true : false;
    }

    function isBalanceAdded(string $type,bool $isBalanceAdded=false)
    {
        if($type== '1')
        {
            return true;
        }else if($type== '2')
        {
            return false;
        }else {
             return $isBalanceAdded;
        }

    }


    function navbarActive($href):bool
    {
         $currentPath=trim($_SERVER['REQUEST_URI'],'/');
        // dd($currentPath);
         if($currentPath==$href)
         {
            return true;
         }
         return false;
    }

}



?>