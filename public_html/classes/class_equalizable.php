<?php

interface Equalizable
{
    // The Equalizable interface, class implementing this interface must inherit Classname::equals() method.
  
    public function equals(Object $object);
}
