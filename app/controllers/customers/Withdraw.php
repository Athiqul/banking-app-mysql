<?php 
namespace App\Controllers\customers;
use App\Models\Transactions;
use App\Models\User;

class Withdraw{
    private $trxModel,$userModel;
    public function __construct()
    {
        middleware('customer');
        $this->trxModel = new Transactions();
        $this->userModel = new User();
    }

    //For withdraw View
    public function withdrawView()
    {
         $userEmail=$_SESSION['user']['email'];
         $user = $this->userModel->findByEmail($userEmail);
         return view('customers/withdraw',['title'=>'Withdraw Balance','user'=>$user]);
    }

    //Store withDraw Amount
    public function withdrawAmount()
    {
        unset($_SESSION['old']);

        try{

            $amount=$_POST['amount'];
        //Validation 
        $errors=[];
        if(!is_numeric($amount)||$amount<1)
        {
          $errors[] = ['amount'=>'Amount should be numeric and positive value'];
          return redirect()->route('/customers-withdraw')->withErrors($errors)->withInput($_POST);
        }
        
        $userEmail=$_SESSION['user']['email'];
        $user = $this->userModel->findByEmail($userEmail);
        if(empty($user))
        {
            http_response_code(404);
            echo "Operation not allowed";
            exit();
        }

        //Check withdraw amount is less than balance or not
        if($amount>$user['balance'])
        {
            $errors[] = ['amount'=>'Amount should be less than main balance'];
            return redirect()->route('/customers-withdraw')->withErrors($errors)->withInput($_POST);
        }

        $user['balance'] -= $amount;

        //Save Transactions

        $transaction=[
            'userEmail'=> $userEmail,
            'userBalance'=>$user['balance'],
            'type'=>2,
            'amount'=>$amount,
            'trxid'=>uniqid('WD'),
            'receiverName'=>'',
            'receiverEmail'=>'',
        ];

        $this->trxModel->save($transaction);
        //Update User Balance
        $this->userModel->update($userEmail,$user);

        return redirect()->route('/customers-dashboard')->with(['success'=>"\$".number_format($amount,2)." Your withdrawal request has been successfully processed, and the amount has been deducted from your account balance. "]);

        }catch(\Exception $e)

        {
            dd($e->getMessage());
        }
        


    }
}

?>