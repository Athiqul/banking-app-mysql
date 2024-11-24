<?php 
namespace App\Controllers\customers;
use App\Models\Transactions;
use App\Models\User;

class Dashboard{
    private $userModel,$trxModel;
    public function __construct(){
        middleware('customer');
        $this->userModel = new User();
        $this->trxModel = new Transactions();
    }
    public function index(){
       // dd($_SESSION['old']);
        $userEmail=$_SESSION['user']['email'];
        $user=$this->userModel->findByEmail($userEmail);
        $transactions=$this->trxModel->all('userEmail',$userEmail);
        //Make descending sort
        usort($transactions,function($a, $b){
            return strtotime($b['created_at']) <=> strtotime($a['created_at']);
        });
        //dd($transactions);
        return view('customers/dashboard',compact('user','transactions'));
    }

    


}

?>