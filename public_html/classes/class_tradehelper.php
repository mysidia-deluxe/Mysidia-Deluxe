<?php

use Resource\Native\Mynull;
use Resource\Collection\ArrayList;

class TradeHelper extends Helper{

	private $settings;
    private $controller;
    private $view;
	private $gui;

	public function __construct(TradeSetting $settings, Controller $controller, View $view = NULL){
	    $this->controller = $controller;
		$this->settings = $settings;
		$this->view = $view;
	}
	
	public function getController(){
	    return $this->controller;
	}
	
	public function setController(Controller $controller){
	    $this->controller = $controller;
	}
	
	public function getView(){
	    return $this->view;
	}
	
	public function setView(View $view){
	    $this->view = $view;
	}
	
	public function getGUI(){
	    return $this->gui;
	}
	
	public function getRecipient(){
	    $lang = $this->view->getLangvars();
		$recipient = $this->view->getField("recipient");
        $this->gui = new Division(NULL, "recipient");
        $this->gui->add(new Image("templates/icons/warning.gif"));

		if($recipient instanceof Mynull) $this->gui->add(new Comment($lang->recipient_none, TRUE, "b"));
		else{
            $this->gui->add(new Comment($lang->recipient.$recipient->username, TRUE, "b"));
            $this->gui->add(new PasswordField("hidden", "recipient", $recipient->username));
        }
        return $this->gui;
	}
	
	public function getAdoptOffered(ArrayList $adopts = NULL){
	    $lang = $this->view->getLangvars();
		$adoptOffered = $this->view->getField("adoptOffered");
        $this->gui = new Division(Mynull, "adoptoffered");

		if($adoptOffered instanceof Mynull) $this->gui->add(new Comment($lang->adopt_offered_none));
		else{
		    $list = ($this->settings->multiple == "enabled")?new SelectionList("adoptOffered[]", TRUE):new DropdownList("adoptOffered");
            $list->add(new Option("None Selected", "none"));          
            $list->fill($adoptOffered);
            if($adopts) $this->selectOptions($list, $adopts);

            $this->gui->add(new Image("templates/icons/next.gif"));
            $this->gui->add(new Comment($lang->adopt_offered));
            $this->gui->add($list);  			
		}
        return $this->gui;
	}
	
	public function getAdoptWanted(ArrayList $adopts = NULL){
	    $lang = $this->view->getLangvars();
        $recipient = $this->view->getField("recipient");
	    $adoptWanted = $this->view->getField("adoptWanted");
        $this->gui = new Division(Mynull, "adoptwanted");

		if($adoptWanted instanceof Mynull) $this->gui->add(new Comment($lang->adopt_wanted_none));
        else{
 		    $list = ($this->settings->multiple == "enabled")?new SelectionList("adoptWanted[]", TRUE):new DropdownList("adoptWanted");
            $list->add(new Option("None Selected", "none"));            
            $list->fill($adoptWanted);
            if($adopts) $this->selectOptions($list, $adopts); 

            $this->gui->add(new Image("templates/icons/next.gif"));
            $this->gui->add(new Comment($lang->adopt_wanted)); 
            $this->gui->add($list);				      
        }
		return $this->gui;     		
	}

	public function getAdoptOfferedPublic(){
	    $lang = $this->view->getLangvars();
        $recipient = $this->view->getField("recipient");
	    $adoptOffered = $this->view->getField("adoptOffered");
        $this->gui = new Division(Mynull, "adoptoffered");

		if($recipient instanceof Mynull or $adoptOffered instanceof Mynull) $this->gui->add(new Comment($lang->adopt_offered_none));
        else{
		    $list = ($this->settings->multiple == "enabled")?new SelectionList("adoptOffered[]", TRUE):new DropdownList("adoptOffered");
            $list->add(new Option("None Selected", "none"));          
            $list->fill($adoptOffered);

            $this->gui->add(new Image("templates/icons/next.gif"));
            $this->gui->add(new Comment($lang->adopt_offered));
            $this->gui->add($list); 			      
        }
		return $this->gui;     		
	}

	public function getAdoptWantedPublic(){
	    $lang = $this->view->getLangvars();
        $recipient = $this->view->getField("recipient");
	    $adoptWanted = $this->view->getField("adoptWanted");
        $this->gui = new Division(Mynull, "adoptwanted");

		if($adoptWanted instanceof Mynull) $this->gui->add(new Comment($lang->adopt_wanted_none));
        else{
            $this->gui->add(new Image("templates/icons/next.gif"));
            $this->gui->add(new Comment($lang->adopt_wanted_public));
 	        $adoptIterator = $adoptWanted->iterator();
            while($adoptIterator->hasNext()){
		        $aid = $adoptIterator->next();
                $adopt = new OwnedAdoptable($aid);
			    $image = $adopt->getImage("gui");
			    $this->gui->add($image);
                $this->gui->add(new PasswordField("hidden", "adoptWanted[]", $aid));
            }      		    			      
        }
        $this->gui->add(new Comment("<br>"));   
		return $this->gui;     		
	}
	
	public function getItemOffered(ArrayList $items = NULL){
	    $lang = $this->view->getLangvars();
		$itemOffered = $this->view->getField("itemOffered");
        $this->gui = new Division(Mynull, "itemoffered");

		if($itemOffered instanceof Mynull) $this->gui->add(new Comment($lang->item_offered_none));
		else{
		    $list = ($this->settings->multiple == "enabled")?new SelectionList("itemOffered[]", TRUE):new DropdownList("itemOffered");
            $list->add(new Option("None Selected", "none"));            
            $list->fill($itemOffered);
            if($items) $this->selectOptions($list, $items); 

            $this->gui->add(new Image("templates/icons/next.gif"));
            $this->gui->add(new Comment($lang->item_offered)); 
            $this->gui->add($list);				
		}
		return $this->gui;
	}
	
	public function getItemWanted(ArrayList $items = NULL){
	    $lang = $this->view->getLangvars();
		$recipient = $this->view->getField("recipient");
	    $itemWanted = $this->view->getField("itemWanted");
        $this->gui = new Division(Mynull, "itemwanted");

        if($itemWanted instanceof Mynull) $this->gui->add(new Comment($lang->item_wanted_none));
        else{
 		    $list = ($this->settings->multiple == "enabled")?new SelectionList("itemWanted[]", TRUE):new DropdownList("itemWanted");
            $list->add(new Option("None Selected", "none"));            
            $list->fill($itemWanted);
            if($items) $this->selectOptions($list, $items); 

            $this->gui->add(new Image("templates/icons/next.gif"));
            $this->gui->add(new Comment($lang->item_wanted));
            $this->gui->add($list); 			        
        }
		return $this->gui;   		
	}

	public function getItemOfferedPublic(){
	    $lang = $this->view->getLangvars();
        $recipient = $this->view->getField("recipient");
	    $itemOffered = $this->view->getField("itemOffered");
        $this->gui = new Division(Mynull, "itemwanted");

		if($recipient instanceof Mynull or $itemOffered instanceof Mynull) $this->gui->add(new Comment($lang->item_offered_none));
        else{
		    $list = ($this->settings->multiple == "enabled")?new SelectionList("itemOffered[]", TRUE):new DropdownList("itemOffered");
            $list->add(new Option("None Selected", "none"));          
            $list->fill($itemOffered);

            $this->gui->add(new Image("templates/icons/next.gif"));
            $this->gui->add(new Comment($lang->item_offered));
            $this->gui->add($list); 			      
        }
		return $this->gui;     		
	}

	public function getItemWantedPublic(){
	    $lang = $this->view->getLangvars();
        $recipient = $this->view->getField("recipient");
	    $itemWanted = $this->view->getField("itemWanted");
        $this->gui = new Division(Mynull, "itemwanted");

		if($recipient instanceof Mynull or $itemWanted instanceof Mynull) $this->gui->add(new Comment($lang->item_wanted_none));
        else{
            $this->gui->add(new Image("templates/icons/next.gif"));
            $this->gui->add(new Comment($lang->item_wanted_public));
 	        $itemIterator = $itemWanted->iterator();
            while($itemIterator->hasNext()){
		        $iid = $itemIterator->next()->getValue();
                $item = new PrivateItem($iid);
			    $image = new Image($item->imageurl);
			    $this->gui->add($image);
                $this->gui->add(new PasswordField("hidden", "itemWanted[]", $iid));
            }        		    			      
        }
        $this->gui->add(new Comment("<br>")); 
		return $this->gui;     		
	}

    public function getPublicOffer(){
	    $lang = $this->view->getLangvars();
        $recipient = $this->view->getField("recipient");
        if($this->settings->public != "enabled" or !($recipient instanceof Mynull)) return new Comment;
        $checkbox = new CheckBox("This is a public trade offer", "public", "yes");
        if($recipient instanceof Mynull) $checkbox->setChecked(TRUE);

        $this->gui = new Division(NULL, "publics");
		$this->gui->add($checkbox);
        $this->gui->add(new Image("templates/icons/warning.gif"));
		$this->gui->add(new Comment($lang->public_offer));
        return $this->gui;
    }

    public function getPartialOffer(){
	    $lang = $this->view->getLangvars();
        $recipient = $this->view->getField("recipient");
        if($this->settings->partial != "enabled" or $recipient instanceof Mynull) return new Comment;
        $checkbox = new CheckBox("This is a partial trade offer", "partial", "yes");

        $this->gui = new Division(NULL, "partials");
		$this->gui->add($checkbox);
        $this->gui->add(new Image("templates/icons/warning.gif"));
		$this->gui->add(new Comment($lang->partial_offer));
        return $this->gui;
    }
	
	public function getAdoptImages(ArrayList $adopts = NULL, $resize = TRUE){
	    $this->gui = new Division(NULL, "adopts");
		if(!$adopts){
		    $this->gui->add(new Comment("N/A"));
			return $this->gui;
		}
	
		$size = $adopts->size();		
		$rows = round(sqrt($size));
		$columns = ceil($size/$rows);
	    $adoptIterator = $adopts->iterator();
        while($adoptIterator->hasNext()){
		     $aid = $adoptIterator->next();
             try{
                 $adopt = new OwnedAdoptable($aid);
			     $image = $adopt->getImage("gui");
             }
             catch(AdoptNotfoundException $ane){
                 $image = new Image("templates/icons/no.gif");
             }
			 if($resize) $image->resize(1/$columns, TRUE);
			 $this->gui->add($image);
        }
        return $this->gui;		
	}
	
	public function getItemImages(ArrayList $items = NULL, $resize = TRUE){
	    $this->gui = new Division(NULL, "items");
		if(!$items){
		    $this->gui->add(new Comment("N/A"));
			return $this->gui;
		}
	
		$size = $items->size();		
		$rows = round(sqrt($size));
		$columns = ceil($size/$rows);
	    $itemIterator = $items->iterator();
        while($itemIterator->hasNext()){
		     $iid = $itemIterator->next();
             $item = new PrivateItem($iid->getValue());
			 $image = ($item->iid == 0)?new Image("templates/icons/no.gif"):new Image($item->imageurl);
			 if($resize) $image->resize(1/$columns, TRUE);
			 $this->gui->add($image);
        }
        return $this->gui;		
	}

	public function getAdoptList(ArrayList $adopts = NULL){
	    $this->gui = new Division(NULL, "adopts");
		if(!$adopts){
		    $this->gui->add(new Comment("N/A"));
			return $this->gui;
		}	
		
	    $adoptIterator = $adopts->iterator();
        while($adoptIterator->hasNext()){
		     $id = $adoptIterator->next()->getValue();
             $adopt = new Adoptable($id);
			 $this->gui->add(new Comment($adopt->getType()));
        }
        return $this->gui;		
	}
	
	public function getItemList(ArrayList $items = NULL){
	    $this->gui = new Division(NULL, "items");
		if(!$items){
		    $this->gui->add(new Comment("N/A"));
			return $this->gui;
		}	
		
	    $itemIterator = $items->iterator();
        while($itemIterator->hasNext()){
		     $id = $itemIterator->next()->getValue();
             $item = new Item($id);
			 $this->gui->add(new Comment($item->itemname));
        }
        return $this->gui;		
	}

    private function selectOptions(DropdownList $list, ArrayList $options){
        $optionsIterator = $options->iterator();
		while($optionsIterator->hasNext()){
		    $option = $optionsIterator->next();
			$list->select($option);
		}
    }	
}
?>