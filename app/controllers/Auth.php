<?php 
namespace App\Controllers;

use App\Models\User;

class Auth{
    public function login(){
       return view('auth/login');
    }

    

    public function checkLogin(){
        extract($_POST);

        $errors=[];
        // Implement login validation and authentication
        if(!isset($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
        {
             // Email field is not valid
             $errors[]=['email'=>'Provide valid email address!'];
             // Redirect to login page with errors
             return redirect()->route('/login')->withErrors($errors);
        }

        if(!isset($password))
        {
             // Password field is empty
             $errors[]=['password'=>'Provide valid password!'];
             return redirect()->route('/login')->withErrors($errors);
        }


        // Implement password encryption and authentication
        // Check if user exists in the file system
        $userModel=new User();
        $user=$userModel->where('email',$email);
       // dd($user);
        if(!$user)
        {
         return redirect()->route('/login')->with(['error','Wrong credentials']); 
        }

       // dd($user);
        if(!password_verify($password,$user['password']))
        {

         //dd($password,$user['password']);
         return redirect()->route('/login')->with(['error','Wrong credentials']); 
        }
        // If user exists, log them in and redirect to dashboard
        // If user does not exist, display an error message and redirect to login page
        // Redirect to dashboard if successful
        // Redirect to login page if failed

        session_start();
        $_SESSION['user'] = $user;
        //dd($user);
        if($user['role']=='admin')
        {
          return redirect()->route('/admin-dashboard')->with(['success','Successfully Logged in']);
        } 

   
        return redirect()->route('/customers-dashboard')->with(['success','Successfully Logged in']);
    }

    public function register(){
       return view('auth/register');
    }

    public function storeUser(){
      extract($_POST);
     
      $errors=[];
      // Implement login validation and authentication
      if(!isset($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
      {
           // Email field is not valid
           $errors[]=['email'=>'Provide valid email address!'];
           // Redirect to login page with errors
           return redirect()->route('/register')->withErrors($errors);
      }

      if(!isset($password)||strlen($password)<8)
      {
           // Password field is empty
           $errors[]=['password'=>'Provide valid password! OR password must be at least 8 characters'];
           return redirect()->route('/register')->withErrors($errors);
      }

      //check name
      if(!isset($name) || strlen($name)<3)
      {
           // Name field is empty or too short
           $errors[]=['name'=>'Provide valid name!'];
           // Redirect to login page with errors
           return redirect()->route('/register')->withErrors($errors);
      }

      //check email address already exists
      $userModel= new User();
      $checkEmail= $userModel->where('email',$email);
      if($checkEmail)
      {
         // Email already exists
         $errors[]=['email'=>'Email already exists!'];
         // Redirect to login page with errors
         return redirect()->route('/register')->withErrors($errors);
      }

      //Prepare for saving data 
      $user=[
         'id'=>uniqid(),
        'name'=>$name,
        'email'=>$email,
        'password'=>password_hash($password,PASSWORD_DEFAULT),
        'role'=>'customer',
        'balance'=>0,
      ];
      //dd($user);
      // Save user to the database
      $userModel->save($user);
      // Redirect to login page with success message
      return redirect()->route('/login')->with(['success','Successfully Registered']);
    }

    

    public function logout ()
    {

      session_destroy();
      return redirect()->route('/login');
    }
}

?>