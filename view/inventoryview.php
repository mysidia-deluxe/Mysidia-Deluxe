<?php

use Resource\Collection\LinkedList;

class InventoryView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		$document->setTitle($mysidia->lang->inventory);
		
		$inventory = $this->getField("inventory");
	    $inventoryTable = new TableBuilder("inventory");
	    $inventoryTable->setAlign(new Align("center", "middle"));
	    $inventoryTable->buildHeaders("Image", "Category", "Name", "Description", "Quantity", "Use", "Sell", "Toss");	
	    $inventoryTable->setHelper(new ItemTableHelper);
	  
	    $iids = $inventory->getiids();
		for($i = 0; $i < $iids->length(); $i++){
	        $item = $inventory->getitem($iids[$i]);
		    $cells = new LinkedList;
		    $cells->add(new TCell($inventory->getitemimage($item->imageurl)));
		    $cells->add(new TCell($item->category));
		    $cells->add(new TCell($item->itemname));
		    $cells->add(new TCell($item->description));
		    $cells->add(new TCell($item->quantity));
		    $cells->add(new TCell($inventoryTable->getHelper()->getUseForm($item)));
		    $cells->add(new TCell($inventoryTable->getHelper()->getSellForm($item)));
		    $cells->add(new TCell($inventoryTable->getHelper()->getTossForm($item)));
		    $inventoryTable->buildRow($cells);		
		}
 	    $document->add($inventoryTable);
	}
			
	public function uses(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;	
		if($mysidia->input->post("aid")){
		    $message = (string)$this->getField("message");
		    $document->setTitle($mysidia->lang->global_action_complete);
            $document->addLangvar($message);
            return;		
		}
		
		$petMap = $this->getField("petMap");
		$document->setTitle($mysidia->lang->select_title);
        $document->addLangvar($mysidia->lang->select);		
		$chooseFrom = new Form("chooseform", "uses", "post");
		
		$adoptable = new DropdownList("aid");
		$adoptable->add(new Option("None Selected", "none"));
        if($petMap->size() > 0){
            $iterator = $petMap->iterator();
            while($iterator->hasNext()){
                $adopt = $iterator->nextEntry();
                $adoptable->add(new Option($adopt->getValue(), $adopt->getKey()));
            }
        }		
		$chooseFrom->add($adoptable);
		
		$chooseFrom->add(new PasswordField("hidden", "itemname", $mysidia->input->post("itemname")));
		$chooseFrom->add(new PasswordField("hidden", "validation", "valid"));
		$chooseFrom->add(new Button("Choose this Adopt", "submit", "submit"));
        $document->add($chooseFrom);
	}
	
	public function sell(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;
		$document->setTitle($this->lang->global_transaction_complete);
		$document->addLangvar("{$this->lang->sell}{$mysidia->input->post("quantity")} {$mysidia->input->post("itemname")} {$this->lang->sell2}");
	}
	
	public function toss(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		if($mysidia->input->get("confirm")){
			$document->setTitle($this->lang->global_action_complete);
	        $document->addLangvar("{$this->lang->toss}{$mysidia->input->post("itemname")}{$this->lang->toss2}");
	        return;
		}
	
		$document->setTitle($this->lang->toss_confirm);
		$document->addLangvar($this->lang->toss_warning);	

		$confirmForm = new FormBuilder("confirmform", "toss/confirm", "post");
		$confirmForm->buildPasswordField("hidden", "action", "toss")
		            ->buildPasswordField("hidden", "itemname", $mysidia->input->post("itemname"))
					->buildButton("Please Toss", "confirm", "confirm");
		$document->add($confirmForm);			
	}
}
?>