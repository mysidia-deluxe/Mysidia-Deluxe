<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedHashMap;

class ProfileView extends View{
	
	public function index(){
		$pagination = $this->getField("pagination");
		$users = $this->getField("users");		
		$document = $this->document;	
		$document->setTitle($this->lang->title);		
        $document->addLangvar($this->lang->memberlist);
		
		$iterator = $users->iterator();
		while($iterator->hasNext()){
		    $entry = $iterator->next();
			$username = (string)$entry->getKey();
			$usergroup = (string)$entry->getValue();
		    if(cancp($usergroup) == "yes") $document->add(new Image("templates/icons/star.gif"));
			$document->add(new Link("profile/view/{$username}", $username, TRUE));
		}
		$document->addLangvar($pagination->showPage());
	}
	
	public function view(){
		$mysidia = Registry::get("mysidia");
		$user = $this->getField("user");
		$profile = $this->getField("profile");
		$document = $this->document;
		$document->setTitle($this->lang->profile);

        $tabsList = new LinkedHashMap;
        $tabsList->put(new Mystring("Visitor Message"), new Mystring("visitormessage"));
        $tabsList->put(new Mystring("About Me"), new Mystring("aboutme"));
        $tabsList->put(new Mystring("Adoptables"), new Mystring("adopts"));
        $tabsList->put(new Mystring("Friends"), new Mystring("friends"));
        $tabsList->put(new Mystring("Contact Info"), new Mystring("contactinfo"));
        $tabs = new Tab(5, $tabsList, 2);
	    $tabs->createtab();
	 
	    // Here we go with the first tab content: Visitor Message
	    $tabs->starttab(0);
		$vmTitle = new Comment($mysidia->input->get("user").$this->lang->VM_member);
		$vmTitle->setBold();
		$vmTitle->setUnderlined();
		$document->add($vmTitle);
	    $profile->display("vmessages");
	 
	    if(!$mysidia->user->isloggedin) $document->addLangvar($this->lang->VM_guest);
	    elseif(!$mysidia->user->status->canvm) $document->addLangvar($this->lang->VM_banned);
	    else{
			$document->addLangvar($this->lang->VM_post);
		    $vmForm = new Form("vmform", "{$mysidia->input->get("user")}", "post");
			$vmForm->add(new PasswordField("hidden", "user", $user->username));
			$vmForm->add(new TextArea("vmtext", "", 4, 50));
			$vmForm->add(new Button("Post Comment", "submit", "submit"));
		    if($mysidia->input->post("vmtext")){
				$reminder = new Paragraph;
				$reminder->add(new Comment("You may now view your conversation with {$user->username} from ", FALSE));
				$reminder->add(new Link("vmessage/view/{$mysidia->input->post("touser")}/{$mysidia->input->post("fromuser")}", "Here"));
				$document->addLangvar($this->lang->VM_complete);
				$document->add($reminder);
			}	
			else $document->add($vmForm);
	    }
	    $tabs->endtab(0);
	 
	    // Now the second tab: About me...
	    $tabs->starttab(1);
	    $profile->display("aboutme");
	    $tabs->endtab(1);
	 
	    // The third tab: Adopts...	
	    $tabs->starttab(2);
		if($user->getadopts()) $document->addLangvar($this->lang->noadopts);
		else $profile->display("adopts");

	    $tabs->endtab(2);
	 
	    // The fourth tab: Friends...
	    $tabs->starttab(3);
        $profile->display("friends", $user);
        $tabs->endtab(3);

	    // The last tab: Contact Info!	
        $tabs->starttab(4); 
	    $user->getcontacts();
	    $user->formatcontacts();
	    $profile->display("contactinfo", $user->contacts);
	    $tabs->endtab(4);
	}
}
?>