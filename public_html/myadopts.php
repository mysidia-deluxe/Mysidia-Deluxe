<?php

use Resource\Native\Integer;
use Resource\Native\Mystring;

class MyadoptsController extends AppController{

    const PARAM = "aid";
    const PARAM2 = "confirm";
	private $adopt;
	private $image;

    public function __construct(){
        parent::__construct("member");
		$mysidia = Registry::get("mysidia");
        if($this->action != "index"){
		    try{
                $this->adopt = new OwnedAdoptable($mysidia->input->get("aid"));	
                if($this->adopt->getOwner() != $mysidia->user->username) throw new NoPermissionException("permission");		
		        $this->image = $this->adopt->getImage("gui");
			}
            catch(AdoptNotfoundException $pne){
		        $this->setFlags("nonexist_title", "nonexist");
            }              			
        }
    }
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$total = $mysidia->db->select("owned_adoptables", array("aid"), "owner = '{$mysidia->user->username}'")->rowCount();
		$pagination = new Pagination($total, 10, "myadopts");
        $pagination->setPage($mysidia->input->get("page"));	
		$stmt = $mysidia->db->select("owned_adoptables", array("aid"), "owner = '{$mysidia->user->username}' ORDER BY totalclicks LIMIT {$pagination->getLimit()},{$pagination->getRowsperPage()}");		
		$this->setField("pagination", $pagination);
        $this->setField("stmt", new DatabaseStatement($stmt));
	}
	
	public function manage(){
	    $this->setField("aid", new Integer($this->adopt->getAdoptID()));
        $this->setField("name", new Mystring($this->adopt->getName()));	
		$this->setField("image", $this->image);		
	}
	
	public function stats(){
		$mysidia = Registry::get("mysidia");				
        $stmt = $mysidia->db->select("vote_voters", array(), "adoptableid='{$this->adopt->getAdoptID()}' ORDER BY date DESC LIMIT 10");
        $this->setField("adopt", $this->adopt);		
		$this->setField("image", $this->image);		
		$this->setField("stmt", new DatabaseStatement($stmt));
	}
	
	public function bbcode(){
		$this->setField("adopt", $this->adopt);	
	}
	
	public function rename(){
		$mysidia = Registry::get("mysidia");		
		if($mysidia->input->post("submit")){
		    $poundsettings = getpoundsettings();
		    $poundpet = $mysidia->db->select("pounds", array(), "aid='{$this->adopt->getAdoptID()}'")->fetchObject();
			if($poundpet and $poundsettings->rename->active == "yes"){
			    if(!empty($poundpet->firstowner) and $mysidia->user->username != $poundpet->firstowner){
				    $this->setFlags("rename_error", "rename_owner");
                    return;	
                }				
            }			
			$this->adopt->setName($mysidia->input->post("adoptname"), "update");
		}
        $this->setField("adopt", $this->adopt);		
		$this->setField("image", $this->image);			
	}
	
	public function trade(){
		$mysidia = Registry::get("mysidia");		
		if($mysidia->input->get("confirm") == "confirm"){
			switch($this->adopt->getTradeStatus()){
		        case "fortrade":
			        $this->adopt->setTradeStatus("notfortrade", "update");
			        $message = $mysidia->lang->trade_disallow;
			        break;
			    case "notfortrade":
			        $this->adopt->setTradeStatus("fortrade", "update");
			        $message = $mysidia->lang->trade_allow;
	                break;
			    default:
			        throw new InvalidActionException("global_action");
		    }
		}
		else{
		    $message = "Are you sure you wish to change the trade status of this adoptable?
					    <center><b><a href='{$this->adopt->getAdoptID()}/confirm'>Yes I'd like to change its trade status</a></b><br /><br />
					    <b><a href='../../myadopts'>Nope I change my mind! Go back to the previous page.</a></b></center><br />";
		}
        $this->setField("aid", new Integer($this->adopt->getAdoptID()));
		$this->setField("image", $this->image);				
        $this->setField("message", new Mystring($message));				
	}
	
	public function freeze(){
		$mysidia = Registry::get("mysidia");		
		if($mysidia->input->get("confirm") == "confirm"){
		    switch($this->adopt->isFrozen()){
		        case "no":
			        $frozen = "yes";
			        $message = $this->adopt->getName().$mysidia->lang->freeze_success;
                    break;
                case "yes":
                    $frozen = "no";
			        $message = $this->adopt->getName().$mysidia->lang->freeze_reverse;
                    break;
                default:
                    throw new InvalidActionException("global_action");			
		     }
             $this->adopt->setFrozen($frozen, "update");
		     $message .= "<br>You may now manage {$this->adopt->getName()} on the ";			       
	    }	 
        $this->setField("adopt", $this->adopt);
		$this->setField("image", $this->image);	
        $this->setField("message", new Mystring($message));			
	}
}
?>