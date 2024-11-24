<?php 
namespace App\Controllers\customers;
use App\Models\Transactions;
use App\Models\User;

class Deposit{
    private $trxModel,$userModel;
    public function __construct()
    {
        middleware('customer');
        $this->trxModel = new Transactions();
        $this->userModel = new User();
    }

    //For Deposit View
    public function depositView()
    {
         $userEmail=$_SESSION['user']['email'];
         $user = $this->userModel->findByEmail($userEmail);
         return view('customers/deposit',['title'=>'Deposit Balance','user'=>$user]);
    }

    //Store Deposit Amount
    public function depositStore()
    {
        unset($_SESSION['old']);

        try{

            $amount=$_POST['amount'];
        //Validation 
        $errors=[];
        if(!is_numeric($amount)||$amount<1)
        {
          $errors[] = ['amount'=>'Amount should be numeric and positive value'];
          return redirect()->route('/customers-deposit')->withErrors($errors)->withInput($_POST);
        }
        
        $userEmail=$_SESSION['user']['email'];
        $user = $this->userModel->findByEmail($userEmail);
        if(empty($user))
        {
            http_response_code(404);
            echo "Operation not allowed";
            exit();
        }

        $user['balance'] += $amount;

        //Save Transactions

        $transaction=[
            'userEmail'=> $userEmail,
            'userBalance'=>$user['balance'],
            'type'=>1,
            'amount'=>$amount,
            'trxid'=>uniqid('DEP'),
            'receiverName'=>'',
            'receiverEmail'=>'',
        ];

        $this->trxModel->save($transaction);
        //Update User Balance
        $this->userModel->update($userEmail,$user);

        return redirect()->route('/customers-dashboard')->with(['success'=>"\$".number_format($amount,2)." deposit request successfully accepted and added to your account balance "]);

        }catch(\Exception $e)

        {
            dd($e->getMessage());
        }
        


    }
}

?>