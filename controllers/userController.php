<?php

class userController extends userModel
{
  
  function __construct() {
    $this->DynamicCall();
  }
  
  
  public function Login()
  {
    $this->Query();
    return false;
  }
  
  public function Register()
  {
    $this->Query();
    return true;
  }
  
  public function LoadUser()
  {
    $this->sql = "SELECT * FROM users";
    $this->Query();
    $this->Load();

    return true;
  }
}

?>
