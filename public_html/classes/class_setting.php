<?php

abstract class Setting extends Core
{
    // The setting class, the base class for all setting objects
  
    protected $cfsetting = false;
    protected $dbsetting = false;
  
    public function __construct($object)
    {
        $mode = $this->getmode($object);
        switch ($mode) {
        case "config":
           $cfsetting = true;
           $this->fetch();
           break;
        case "database":
           $dbsetting = true;
           $this->fetch($object);
           break;
        default:
           throw new Exception("Settings fetch mode not recognized.");
     }
    }
  
    final private function getmode($object)
    {
        if ($object instanceof SplFileInfo) {
            return "config";
        } elseif ($object instanceof Database) {
            return "database";
        } else {
            return null;
        }
    }

    abstract public function fetch($object);
}
