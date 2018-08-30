<?php

class Promocode{
  public $pid = 0;
  private $type;
  private $user;
  private $code;
  private $availability;
  private $fromdate;
  private $todate;
  private $reward;
  private $valid;
  
  public function __construct($code = ""){
      // Fetch the database info into object property
  
      $mysidia = Registry::get("mysidia");
	  $stmt = $mysidia->db->select("promocodes", array(), "code ='{$code}'");
      if($row = $stmt->fetchObject()){
         // loop through the anonymous object created to assign properties
         foreach($row as $key => $val){
            // Assign properties to our promocode instance
            $this->$key = $val;		 
         }
		 if(empty($this->user)) $this->user = $mysidia->user->username;
      }
      else return FALSE;
  }
  
  public function validate($code = ""){
      // This method checks if the promocode entered by user is valid	  
	  
	  $mysidia = Registry::get("mysidia");
	  if(!empty($code) and $code == $this->code){
         $uservalid = $this->checkuser();
		 $numvalid = $this->checknumber();
		 $datevalid = $this->checkdate();
		 $this->valid = (!$uservalid or !$numvalid or !$datevalid)?FALSE:TRUE;	 
	  }
	  else{
	     throw new InvalidIDException($mysidia->lang->invalid);
	  }
	  return $this->valid;      
  }
  
  private function checkuser($user = ""){
      // This method check if the specific user can use this promocode, it must be used after the promocode's existence has been confirmed.
	  $mysidia = Registry::get("mysidia");
	  $user = (empty($user))?$mysidia->user->username:$user;
	  if(empty($this->user) or $this->user == "SYSTEM" or $user == $this->user) $uservalid = TRUE;
	  else{
	     // The user has entered a promocode that matches our database, but it does not belong to him/her. We're having a hacking attempt!
         $ban = banuser($mysidia->user->username);
		 throw new NoPermissionException($mysidia->lang->owner);
	  }
	  return $uservalid;
  }

  private function checknumber(){
      $mysidia = Registry::get("mysidia");

      if($this->availability == 0){
	     // The promocode has been used, so it is unavailable now...
		 throw new NoPermissionException($mysidia->lang->unavail);
	  }
	  else return TRUE;
  }

  private function checkdate(){
      // This method check if the current time is within the time range for promocode's availability, it must be used after the promocode's existence has been confirmed.
      $mysidia = Registry::get("mysidia");
	  $currenttime = time();
	  if(empty($this->fromdate) and empty($this->todate)) return TRUE;
	  else{
	     $timerange = array(strtotime($this->fromdate), strtotime($this->todate));
		 if(!empty($timerange[0]) and $currenttime < $timerange[0]){
		     // The promocode cannot be used yet, it's way too early...
			 throw new NoPermissionException($mysidia->lang->early);
		 }
		 elseif(!empty($timerange[1]) and $currenttime > $timerange[1]){
		     // The promocode has expired, OMG...
			 throw new NoPermissionException($mysidia->lang->expired);	 
		 }
		 else return TRUE;
      }
      // That's the end of it, a bit tedious I'd say...
  }

  public function execute(){
      // This method will execute the promocode and give users their desired adoptables or items, need to be used after validation is completed
	  $mysidia = Registry::get("mysidia");
      $document = $mysidia->frame->getDocument();
	  if($this->valid != TRUE) throw new NoPermissionException($mysidia->lang->validate);
	  
	  switch($this->type){
	     case "Adopt":
		    // The user will receive an adoptable from the promocode now.
		    $code = codegen(10, 0);
			$genders = array('f', 'm');
			$rand = rand(0,1);
	        $mysidia->db->insert("owned_adoptables", array("aid" => NULL, "type" => $this->reward, "name" => $this->reward, "owner" => $this->user, "currentlevel" => 0, "totalclicks" => 0, "code" => $code, 
			                                               "imageurl" => NULL, "usealternates" => 'no', "tradestatus" => 'fortrade', "isfrozen" => 'no', "gender" => $genders[$rand], "lastbred" => 0));
			$document->addLangvar("Congrats, you have acquired the adoptable {$this->reward} by entering promocode.");
			$this->usepromo();
		    break;
		 case "Item":
		    // The user will receive an item from the promocode now.
    	
			$item = new StockItem($this->reward, 1);
			$item->assign($this->user);
			$newquantity = $item->getoldquantity() + 1;
			if($item->cap != 0 and $newquantity > $item->cap){
                throw new NoPermissionException("It appears that you cannot add one more of item {$this->reward} to your inventory, its quantity has already exceeded the upper limit.");
			}
			else{
			   $item->append();
			   $document->addLangvar("Congrats, you have acquired the item {$this->reward} by entering promocode.");
			   $this->usepromo();
			}  
		    break;
         case "Page":
            $this->usepromo();
            break;
		 default:
		    throw new InvalidIDException($mysidia->lang->type);	 
	  }
	  // All done, we're good to go!
  }

  private function usepromo(){
      $mysidia = Registry::get("mysidia");
      if($this->availability == 0) throw new NoPermissionException($mysidia->lang->fatalerror);
      $this->availability--;
      $mysidia->db->update("promocodes", array("availability" => $this->availability), "pid='{$this->pid}'");
      return TRUE;	  
  }  
}
?> 