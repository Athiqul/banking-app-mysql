<?php 
namespace App\Controllers\customers;
use App\Models\Transactions;
use App\Models\User;

class Transfer{
    private $trxModel,$userModel;
    public function __construct()
    {
        middleware('customer');
        $this->trxModel = new Transactions();
        $this->userModel = new User();
    }

    //For Transfer View
    public function transferView()
    {
         $userEmail=$_SESSION['user']['email'];
         $user = $this->userModel->findByEmail($userEmail);
         return view('customers/transfer',['title'=>'Transfer Balance','user'=>$user]);
    }

    //Store Transfer Amount
    public function transferAmount()
    {

        unset($_SESSION['old']);

        try{

            $amount=$_POST['amount'];
            $recipientEmail=$_POST['email'];
        //Validation 
        $errors=[];
        if(!is_numeric($amount)||$amount<1)
        {
          $errors[] = ['amount'=>'Amount should be numeric and positive value'];
          return redirect()->route('/customers-transfer')->withErrors($errors)->withInput($_POST);
        }

        //check recipient email address
        if(filter_var($recipientEmail,FILTER_VALIDATE_EMAIL)==false)
        {
            $errors[] = ['email'=>'Please provide valid email address for recipients'];
          return redirect()->route('/customers-transfer')->withErrors($errors)->withInput($_POST);
        }

       
        $recUser= $this->userModel->findByEmail($recipientEmail);
        if(!$recUser)
        {
            $errors[] = ['email'=>'No valid account found this email address'];
          return redirect()->route('/customers-transfer')->withErrors($errors)->withInput($_POST);
        }
        
        $userEmail=$_SESSION['user']['email'];
        if($userEmail==$recipientEmail)
        {
            $errors[] = ['email'=>'You can\'t transfer your own email address'];
          return redirect()->route('/customers-transfer')->withErrors($errors)->withInput($_POST);
        }
        $user = $this->userModel->findByEmail($userEmail);
       // dd($recUser);
        if(empty($user))
        {
            http_response_code(404);
            echo "Operation not allowed";
            exit();
        }

        //Check transfer amount is less than balance or not
        if($amount>$user['balance'])
        {
            $errors[] = ['amount'=>'Amount should be less than main balance'];
            return redirect()->route('/customers-transfer')->withErrors($errors)->withInput($_POST);
        }

        $user['balance'] -= $amount;
        $recUser['balance']+=$amount;

        //Save Transactions

        $transactionSender=[
            'userEmail'=> $userEmail,
            'userBalance'=>$user['balance'],
            'type'=>3,
            'amount'=>$amount,
            'trxid'=>uniqid('TR'),
            'receiverName'=>$recUser['name'],
            'receiverEmail'=>$recUser['email'],
            'balance_added'=>0,
        ];

        $transactionReceiver=[
            'userEmail'=> $recUser['email'],
            'userBalance'=>$recUser['balance'],
            'type'=>3,
            'amount'=>$amount,
            'trxid'=>uniqid('TR'),
            'receiverName'=>$user['name'],
            'receiverEmail'=>$user['email'],
            'balance_added'=>1,
        ];

        $this->trxModel->save($transactionSender);
        $this->trxModel->save($transactionReceiver);
        //Update User Balance
        $this->userModel->update($userEmail,$user);
        $this->userModel->update($recipientEmail,$recUser);

        return redirect()->route('/customers-dashboard')->with(['success'=>"\$".number_format($amount,2)."Your transfer request has been successfully processed, and the amount  has been transferred from your account balance."]);

        }catch(\Exception $e)

        {
            dd($e->getMessage());
        }
        


    }
}

?>