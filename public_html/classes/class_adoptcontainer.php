<?php

use Resource\Native\Object;

abstract class AdoptContainer extends Model implements Container
{
    // The abstract ItemContainer class
  
    public function getadoptimage($imageurl = "")
    {
        // This method returns the adoptable image in standard html form
        return new Image($imageurl);
    }
  
    public function getcreator()
    {
        // Will be implemented in future
    }
  
    abstract public function gettotal();
    abstract public function display();
    abstract public function execute($action);
}
