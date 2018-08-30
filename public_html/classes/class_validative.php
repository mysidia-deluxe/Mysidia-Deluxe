<?php

interface Validative{
  // The Validator interface for Mysidia Adoptables

  public function validate();
  public function seterror($error, $overwrite);
} 
?>