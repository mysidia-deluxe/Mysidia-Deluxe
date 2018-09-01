<?php

use Resource\Collection\ArrayList;

class TradeValidator extends Validator
{
    private $trade;
    private $settings;
    private $validations;
    private $status;

    public function __construct(TradeOffer $trade, TradeSetting $settings, ArrayList $validations)
    {
        $this->trade = $trade;
        $this->settings = $settings;
        $this->validations = $validations;
    }
    
    public function getValidations()
    {
        return $this->validations;
    }
    
    public function setValidations(ArrayList $validations, $overwrite = false)
    {
        if ($overwrite) {
            $this->validations = $validations;
        } else {
            $iterator = $validations->iterator();
            while ($iterator->hasNext()) {
                $this->validations->append($iterator->next());
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
    }

    public function validate()
    {
        $iterator = $this->validations->iterator();
        while ($iterator->hasNext()) {
            $validation = $iterator->next();
            $method = "check{$validation->capitalize()}";
            $this->$method();
        }
        return true;
    }
    
    private function checkRecipient()
    {
        if (!$this->trade->getRecipient()) {
            throw new TradeInvalidException("recipient_empty");
        } else {
            $sender = $this->trade->getSender("model");
            $recipient = $this->trade->getRecipient("model");
            if ($sender->username == $recipient->username) {
                throw new TradeInvalidException("recipient_duplicate");
            }
            $options = $recipient->getoptions();
            if ($options->tradestatus == 1) {
                $friendlist = new FriendList($recipient);
                $friend = new Friend($sender, $friendlist);
                if (!$friend->isfriend) {
                    throw new TradeInvalidException("recipient_privacy");
                }
            }
            return true;
        }
    }

    private function checkPublic()
    {
        if ($this->trade->getRecipient()) {
            throw new TradeInvalidException("recipient_public");
        }
        return true;
    }

    private function checkPartial()
    {
        if (!$this->trade->hasAdoptOffered() and !$this->trade->hasAdoptWanted() and
           !$this->trade->hasItemOffered() and !$this->trade->hasItemWanted() and !$this->trade->hasCashOffered()) {
            throw new TradeInvalidException("recipient_partial");
        }
        return true;
    }
  
    private function checkOffered()
    {
        if (!$this->trade->hasAdoptOffered() and !$this->trade->hasItemOffered() and !$this->trade->hasCashOffered()) {
            throw new TradeInvalidException("offers");
        }
        return true;
    }
    
    private function checkWanted()
    {
        if (!$this->trade->hasAdoptWanted() and !$this->trade->hasItemWanted()) {
            throw new TradeInvalidException("wanted");
        }
        return true;
    }
    
    private function checkAdoptOffered()
    {
        if (!$this->trade->hasAdoptOffered()) {
            return true;
        }
        try {
            $adoptOffered = $this->trade->getAdoptOffered();
            $adoptIterator = $adoptOffered->iterator();
            while ($adoptIterator->hasNext()) {
                $aid = $adoptIterator->next()->getValue();
                $adopt = new OwnedAdoptable($aid, $this->trade->getSender());
            }
        } catch (AdoptNotfoundException $ane) {
            throw new TradeInvalidException("adoptoffered");
        }
        return true;
    }
    
    private function checkAdoptWanted()
    {
        if (!$this->trade->hasAdoptWanted()) {
            return true;
        }
        try {
            $adoptWanted = $this->trade->getAdoptWanted();
            $adoptIterator = $adoptWanted->iterator();
            while ($adoptIterator->hasNext()) {
                $aid = $adoptIterator->next()->getValue();
                $adopt = new OwnedAdoptable($aid, $this->trade->getRecipient());
            }
        } catch (AdoptNotfoundException $ane) {
            throw new TradeInvalidException("adoptwanted");
        }
        return true;
    }

    private function checkAdoptPublic()
    {
        if (!$this->trade->hasAdoptWanted()) {
            return true;
        }
        try {
            $adoptWanted = $this->trade->getAdoptWanted();
            $adoptIterator = $adoptWanted->iterator();
            while ($adoptIterator->hasNext()) {
                $id = $adoptIterator->next()->getValue();
                $adopt = new Adoptable($id);
            }
        } catch (AdoptNotfoundException $ane) {
            throw new TradeInvalidException("public_adopt");
        }
        return true;
    }

    private function checkItemOffered()
    {
        if (!$this->trade->hasItemOffered()) {
            return true;
        }
        $itemOffered = $this->trade->getItemOffered();
        $itemIterator = $itemOffered->iterator();
        while ($itemIterator->hasNext()) {
            $iid = $itemIterator->next()->getValue();
            $item = new PrivateItem($iid, $this->trade->getSender());
            if ($item->iid = 0) {
                throw new TradeInvalidException("itemoffered");
            }
        }
        return true;
    }
    
    private function checkItemWanted()
    {
        if (!$this->trade->hasItemWanted()) {
            return true;
        }
        $itemWanted = $this->trade->getItemWanted();
        $itemIterator = $itemWanted->iterator();
        while ($itemIterator->hasNext()) {
            $iid = $itemIterator->next()->getValue();
            $item = new PrivateItem($iid, $this->trade->getRecipient());
            if ($item->iid = 0) {
                throw new TradeInvalidException("itemwanted");
            }
        }
        return true;
    }

    private function checkItemPublic()
    {
        if (!$this->trade->hasItemWanted()) {
            return true;
        }
        try {
            $itemWanted = $this->trade->getItemWanted();
            $itemIterator = $itemWanted->iterator();
            while ($itemIterator->hasNext()) {
                $id = $itemIterator->next()->getValue();
                $item = new Item($id);
            }
        } catch (ItemException $ine) {
            throw new TradeInvalidException("public_item");
        }
        return true;
    }

    private function checkCashOffered()
    {
        if (!$this->trade->hasCashOffered()) {
            return true;
        }
        $cashOffered = $this->trade->getCashOffered();
        $cashLeft = $this->trade->getSender("model")->getcash() - ($cashOffered + $this->settings->tax);
        if ($cashLeft < 0) {
            throw new TradeInvalidException("cashoffered");
        }
        return true;
    }
 
    private function checkStatus()
    {
        $status = $this->trade->getStatus();
        if ($status != "pending" and $status != "moderate") {
            throw new TradeInvalidException("status");
        }
        return true;
    }
 
    private function checkSpecies()
    {
        if (empty($this->settings->species)) {
            return true;
        }
        if ($this->trade->hasAdoptOffered()) {
            $this->checkMultipleSpecies($this->trade->getAdoptOffered());
        }
        if ($this->trade->hasAdoptWanted()) {
            $this->checkMultipleSpecies($this->trade->getAdoptWanted());
        }
        return true;
    }
    
    private function CheckMultipleSpecies(ArrayList $adopts)
    {
        foreach ($this->settings->species as $type) {
            $adoptIterator = $adopts->iterator();
            while ($adoptIterator->hasNext()) {
                $aid = $adoptIterator->next()->getValue();
                $adopt = new OwnedAdoptable($aid);
                if ($adopt->getType() == $type) {
                    throw new TradeInvalidException("species");
                }
            }
        }
        return true;
    }
    
    private function checkInterval()
    {
        $mysidia = Registry::get("mysidia");
        if ($mysidia->input->action() != "offer") {
            return true;
        }
        $current = new DateTime;
        $validTime = $current->getTimestamp() - ($this->settings->interval * 60 * 60 * 24);
        $lastDate = $mysidia->db->select("trade", array("date"), "sender ='{$this->trade->getSender()}' ORDER BY date DESC LIMIT 3")->fetchColumn();
        $lastDate = new DateTime($lastDate);
        $lastTime = $lastDate->getTimestamp();
        if ($lastTime > $validTime) {
            throw new TradeInvalidException("interval");
        }
        return true;
    }
     
    private function checkNumber()
    {
        if ($this->settings->number == 0) {
            throw new TradeInvalidException("number");
        }
        if ($this->trade->hasAdoptOffered()) {
            $this->checkNumbers($this->trade->getAdoptOffered());
        }
        if ($this->trade->hasAdoptWanted()) {
            $this->checkNumbers($this->trade->getAdoptWanted());
        }
        if ($this->trade->hasItemOffered()) {
            $this->checkNumbers($this->trade->getItemOffered());
        }
        if ($this->trade->hasItemWanted()) {
            $this->checkNumbers($this->trade->getItemWanted());
        }
        return true;
    }
    
    private function checkNumbers(ArrayList $list)
    {
        if ($this->settings->number < $list->size()) {
            throw new TradeInvalidException("number");
        }
        return true;
    }

    private function checkDuration()
    {
        $current = new DateTime;
        $expirationTime = $current->getTimestamp() - (($this->settings->duration) * 24 * 60 * 60);
        if ($this->trade->getDate() > $expirationTime) {
            throw new TradeInvalidException("duration");
        }
        return true;
    }
    
    private function checkUsergroup()
    {
        if ($this->settings->usergroup == "all") {
            return true;
        }
        foreach ($this->settings->usergroup as $usergroup) {
            if ($this->trade->getSender()->usergroup == $usergroup or $this->trade->getRecipient()->usergroup == $usergroup) {
                return true;
            }
        }
        throw new TradeInvalidException("usergroup");
    }
    
    private function checkItem()
    {
        if (!$this->settings->item) {
            return true;
        }
        if ($this->trade->hasItemOffered()) {
            $this->checkMultipleItem($this->trade->getItemOffered());
        }
        if ($this->trade->hasItemWanted()) {
            $this->checkMultipleItem($this->trade->getItemWanted());
        }
        return true;
    }
    
    private function checkMultipleItem(ArrayList $items)
    {
        foreach ($this->settings->item as $item) {
            $itemIterator = $items->iterator();
            while ($itemIterator->hasNext()) {
                $iid = $itemIterator->next()->getValue();
                $item = new PrivateItem($iid);
                if ($item->iid == 0 or $item->tradable != "yes") {
                    throw new TradeInvalidException("item");
                }
            }
        }
        return true;
    }
}
