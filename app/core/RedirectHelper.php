<?php 
namespace App\core;

class RedirectHelper {
    
    private $url;

   public function route($route)
   {
       $this->url=$route;
       return $this;
   }


    // Redirect to a specific route
    public function withErrors($errors)
    {
        session_start();
        $_SESSION['errors'] = $errors;
        return $this;
        
    }

    public function with(array $data)
    {
       
        session_start();
        $_SESSION['old']=$data;
        return $this;
        
    }

    public function withInput(array $data)
    {
        session_start();
        $_SESSION['old_input']=$data;
        return $this;
    }

    public function __destruct()
    {
        header("Location: {$this->url}");
    }
}

?>