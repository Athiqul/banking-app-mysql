<?php


//dd($_SESSION['errors'][0]);
if(isset($_SESSION['errors']))
{
 // dd($_SESSION('errors'));  
  extract($_SESSION['errors'][0]);
  unset($_SESSION['errors']);
}


?>