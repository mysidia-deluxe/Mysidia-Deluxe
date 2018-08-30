<?php

use Resource\Native\Object;

abstract class MessageContainer extends Object implements Container{
  // The abstract MessageContainer class
  
  private function format($text){ 
         $text = html_entity_decode($text); 
         $text = str_replace("\r\n","",$text); 
         $text = stripslashes($text); 
         return $text; 
    }
  
  public function getcreator(){
     // Will be implemented in future
  }
  
  public abstract function display();
  public abstract function post();
} 
?>