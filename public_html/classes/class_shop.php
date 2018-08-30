<?php

interface Shop{
  // The shop interface used by any subtypes of shops

  public function getshop();
  public function display();
  public function purchase($name);
  public function rent($name, $period);
}

?>