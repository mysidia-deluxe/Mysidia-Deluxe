<?php

class AdoptLevel extends Model
{
    protected $lvid;
    protected $adoptiename;
    protected $thisislevel;
    protected $requiredclicks;
    protected $primaryimage;
    protected $alternateimage;
    protected $rewarduser;
    protected $promocode;
  
    public function __construct($adopt, $level)
    {
        $mysidia = Registry::get("mysidia");
        $row = $mysidia->db->select("levels", array(), "adoptiename='{$adopt}' and thisislevel='{$level}'")->fetchObject();
        if (!is_object($row)) {
            throw new LevelNotfoundException("The level {$level} for {$adopt} does not exist...");
        }
        foreach ($row as $key => $val) {
            $this->$key = $val;
        }
    }
    
    public function getAdopt($fetchMode = "")
    {
        if ($fetchMode == Model::MODEL) {
            return new Adoptable($this->adoptiename);
        } else {
            return $this->adoptiename;
        }
    }

    public function getLevel()
    {
        return $this->thisislevel;
    }

    public function getRequiredClicks()
    {
        return $this->requiredclicks;
    }
  
    public function getPrimaryImage($fetchMode = "")
    {
        if ($fetchMode == Model::GUI) {
            return new Image($this->primaryimage);
        }
        return $this->primaryimage;
    }
    
    public function getAlternateImage($fetchMode = "")
    {
        if ($fetchMode == Model::GUI) {
            return new Image($this->alternateimage);
        }
        return $this->alternateimage;
    }
    
    public function getNextLevel($fetchMode = "")
    {
        if ($fetchMode == Model::MODEL) {
            return new Self($this->adoptiename, $this->thisislevel + 1);
        } else {
            return ($this->thisislevel + 1);
        }
    }
    
    protected function save($field, $value)
    {
        $mysidia = Registry::get("mysidia");
        $mysidia->db->update("levels", array($field => $value), "adoptiename='{$this->adoptiename}' and thisislevel='{$this->thisislevel}'");
    }
}
