<?php 
namespace App\Controllers;

class Home{
    public function index(){
        //dd(App_Url);
       return view('home/index');
    }
}

?>