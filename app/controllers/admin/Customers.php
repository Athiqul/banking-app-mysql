<?php 
namespace App\Controllers\admin;
use App\Models\User;

class Customers {
    private $userModel;
    //Create Customer 
    //Customer Create View page
    public function __construct()
    {
        middleware('admin');
        $this->userModel=new User();

    }
    public function create()
    {
        $titleHeaders="Add Customers";
        return view('admin/add_customer',compact('titleHeaders'));
    }
    //Customer Store 
    public function store()
    {
          extract($_POST);
          //Validation part
          $errors=[];
          $name=htmlspecialchars(trim($first_name.' '.$last_name));
          if(!isset($name)||strlen($name)<3||strlen($name)>255)
          {
            $errors[] = ['name'=>'Invalid name please provide correct name'];
            return redirect()->route('/admin-customer-add')->withErrors($errors)->withInput($_POST);
          }



          if(!isset($password)||strlen($password)<8)
      {
           // Password field is empty
           $errors[]=['password'=>'Provide valid password! OR password must be at least 8 characters'];
           return redirect()->route('/admin-customer-add')->withErrors($errors)->withInput($_POST);
      }

  
       //Check password contain at least one digits or not
      if(!preg_match('/[0-9]/',$password))
      {
        $errors[]=['password'=>'Password must contain one digits at least']; 
        return redirect()->route('/admin-customer-add')->withErrors($errors)->withInput($_POST);
      }

      if(!preg_match('/[a-z]/',$password))
      {
        $errors[]=['password'=>'Password must contain one lowercase letter at least'];  
        return redirect()->route('/admin-customer-add')->withErrors($errors)->withInput($_POST);
      }

      if(!preg_match('/[A-Z]/',$password))
      {
        $errors[]=['password'=>'Password must contain one uppercase letter at least'];  
        return redirect()->route('/admin-customer-add')->withErrors($errors)->withInput($_POST);
      }

      if(!isset($email)||!filter_var($email, FILTER_VALIDATE_EMAIL))
      {
        $errors[]=['email'=> 'Please provide valid email address'];
        return redirect()->route('/admin-customer-add')->withErrors($errors)->withInput($_POST);
      }


      //Check email is exist or not
      $check=$this->userModel->where('email',$email);
      if($check)
      {
        $errors[]=['email'=> 'This email address already registered!'];
        return redirect()->route('/admin-customer-add')->withErrors($errors)->withInput($_POST);
      }

      //Store into file 
      try{
       if( $this->userModel->save([
            'id'=>uniqid(),
            'name'=>$name,
            'email'=>$email,
            'password'=>password_hash($password,PASSWORD_DEFAULT),
            'role'=>'customer',
            'balance'=>0,
          ]))

          {
            return redirect()->route('/admin-dashboard')->with(['success'=>'Successfully account Registered into system'])->withInput($_POST);
          }
        
      }catch(\Exception $e)
      {
        dd($e->getMessage());  
      }
     
    }
}