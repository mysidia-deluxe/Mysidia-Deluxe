<?php

use Resource\Native\Object;

abstract class UserDecorator extends Object implements Decorator{
  // The abstract class UserDecorator used in Mysidia Adoptables
  protected $user;
  
  public function __construct(User $user){
      $this->user = $user;
  }
  
  public function __call($method, $param){
      // This magic method triggers when a method is called on the decorated user object
	  
	  if(!method_exists($this->user, $method)) return FALSE;
	  $this->user->$method($param);
  }
  
 public abstract function decorate();
} 
?>