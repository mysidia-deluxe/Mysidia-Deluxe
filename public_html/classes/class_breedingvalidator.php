<?php

class BreedingValidator extends Validator
{
    private $female;
    private $male;
    private $settings;
    private $validations;
    private $status;

    public function __construct(OwnedAdoptable $female, OwnedAdoptable $male, BreedingSetting $settings, ArrayObject $validations)
    {
        $this->female = $female;
        $this->male = $male;
        $this->settings = $settings;
        $this->validations = $validations;
    }
    
    public function getValidations()
    {
        return $this->validations;
    }
    
    public function setValidations(ArrayObject $validations, $overwrite = false)
    {
        if ($overwrite) {
            $this->validations = $validations;
        } else {
            foreach ($validations as $validation) {
                $this->validations->append($validations);
            }
        }
    }
    
    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status = "")
    {
        $this->status = $status;

        if ($this->status == "chance" or $this->status == "complete") {
            $mysidia = Registry::get("mysidia");
            $date = new DateTime;
            $mysidia->user->changecash(-$this->settings->cost);

            $this->female->setOffsprings($this->female->getOffsprings() + 1, "update");
            $this->female->setLastBred($date->getTimestamp(), "update");
            $this->male->setOffsprings($this->male->getOffsprings() + 1, "update");
            $this->male->setLastBred($date->getTimestamp(), "update");
        }
    }

    public function validate()
    {
        foreach ($this->validations as $validation) {
            $method = "check".ucfirst($validation);
            $this->$method();
        }
        return true;
    }
  
    private function checkClass()
    {
        $femaleClass = explode(",", $this->female->getClass());
        $maleClass = explode(",", $this->male->getClass());
        foreach ($femaleClass as $fclass) {
            foreach ($maleClass as $mclass) {
                if ($fclass == $mclass) {
                    return true;
                }
            }
        }
        throw new BreedingException("class");
    }
    
    private function checkGender()
    {
        $mysidia = Registry::get("mysidia");
        if ($this->female->getGender() != "f" or $this->male->getGender() != "m") {
            banuser($mysidia->user->username);
            throw new BreedingException("gender");
        }
        return true;
    }
  
    private function checkOwner()
    {
        $mysidia = Registry::get("mysidia");
        if ($this->female->getOwner() != $mysidia->user->username or $this->male->getOwner() != $mysidia->user->username) {
            banuser($mysidia->user->username);
            throw new BreedingException("owner");
        }
        return true;
    }
  
    private function checkSpecies()
    {
        if (empty($this->settings->species)) {
            return true;
        }
        foreach ($this->settings->species as $type) {
            if ($this->female->getType() == $type or $this->male->getType() == $type) {
                throw new BreedingException("species");
            }
        }
        return true;
    }
    
    private function checkInterval()
    {
        $current = new DateTime;
        $expirationTime = $current->getTimestamp() - (($this->settings->interval) * 24 * 60 * 60);
        
        if ($this->female->getLastBred() > $expirationTime or $this->male->getLastBred() > $expirationTime) {
            throw new BreedingException("interval");
        }
        return true;
    }
    
    private function checkLevel()
    {
        if ($this->female->getCurrentLevel() < $this->settings->level or $this->male->getCurrentLevel() < $this->settings->level) {
            throw new BreedingException("level");
        }
        return true;
    }
  
    private function checkCapacity()
    {
        if ($this->female->getOffsprings() >= $this->settings->capacity or $this->male->getOffsprings() >= $this->settings->capacity) {
            throw new BreedingException("capacity");
        }
        return true;
    }
     
    private function checkNumber()
    {
        if ($this->settings->number == 0) {
            throw new BreedingException("number");
        }
        return true;
    }

    private function checkChance()
    {
        $rand = rand(0, 99);
        if ($rand < $this->settings->chance) {
            return true;
        }
        throw new BreedingException("chance");
    }

    private function checkCost()
    {
        $mysidia = Registry::get("mysidia");
        if ($mysidia->user->money < $this->settings->cost) {
            throw new BreedingException("cost");
        }
        return true;
    }
    
    private function checkUsergroup()
    {
        if ($this->settings->usergroup == "all") {
            return true;
        }
        $mysidia = Registry::get("mysidia");
        
        foreach ($this->settings->usergroup as $usergroup) {
            if ($mysidia->user->usergroup == $usergroup) {
                return true;
            }
        }
        throw new BreedingException("usergroup");
    }
    
    private function checkItem()
    {
        if (!$this->settings->item) {
            return true;
        }
        $mysidia = Registry::get("mysidia");
        
        foreach ($this->settings->item as $item) {
            $item = new PrivateItem($item, $mysidia->user->username);
            if ($item->iid == 0) {
                throw new BreedingException("item");
            }
            if ($item->consumable == "yes") {
                $item->remove();
            }
        }
        return true;
    }
}
