<?php

class BreedAdoptable extends Adoptable
{
    protected $bid;
    protected $offspring;
    protected $parent;
    protected $mother;
    protected $father;
    protected $probability;
    protected $survival;
    protected $level;
    protected $available;
  
    public function __construct($bid)
    {
        $mysidia = Registry::get("mysidia");
        $row = $mysidia->db->select("breeding", array(), "bid ='{$bid}'")->fetchObject();
        if (!is_object($row)) {
            throw new AdoptNotfoundException("Adoptable {$adoptinfo} does not exist...");
        }
        
        parent::__construct($row->offspring);
        foreach ($row as $key => $val) {
            $this->$key = $val;
        }
    }

    public function getBreedID()
    {
        return $this->bid;
    }

    public function getOffspring()
    {
        return $this->offspring;
    }
    
    public function getParent($fetchMode = "")
    {
        if ($fetchMode == Model::MODEL) {
            return new Adoptable($this->parent);
        } else {
            return $this->parent;
        }
    }
    
    public function getMother($fetchMode = "")
    {
        if ($fetchMode == Model::MODEL) {
            return new Adoptable($this->mother);
        } else {
            return $this->mother;
        }
    }
  
    public function getFather($fetchMode = "")
    {
        if ($fetchMode == Model::MODEL) {
            return new Adoptable($this->father);
        } else {
            return $this->father;
        }
    }
    
    public function getProbability()
    {
        return $this->probability;
    }
    
    public function getSurvivalRate()
    {
        return $this->survival;
    }
        
    public function getRequiredLevel()
    {
        return $this->level;
    }
    
    public function isAvailable()
    {
        return $this->available;
    }
    
    protected function save($field, $value)
    {
        $mysidia = Registry::get("mysidia");
        $mysidia->db->update("breeding", array($field => $value), "bid='{$this->bid}'");
    }
}
