<?php

interface Message{  
  // The interface for message system, using strategy pattern
  
  public function gettitle();
  public function getcontent();
  public function getnotifier();
  public function post($user);
  public function remove();
}
?> 