<?php 
namespace App\Controllers\admin;
use App\Models\User;

class Dashboard{
    private $userModel;
    
    public function __construct(){
        middleware('admin');
        $this->userModel = new User();
    }
    public function index(){
       

        //Get All the customers
        $customers = $this->userModel->all('role','customer');
        //Make title dynamic for headers
        $titleHeaders="Customers";
        
        return view('admin/dashboard',compact('customers','titleHeaders'));
    }

    
}

?>