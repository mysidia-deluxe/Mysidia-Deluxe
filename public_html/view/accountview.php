<?php

class AccountView extends View{
	
	public function index(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;		
        $document->setTitle($mysidia->user->username.$this->lang->title);
        $document->addLangvar($this->lang->manage, TRUE);
   
        $settings = new Comment("Account Settings");
        $settings->setBold();
        $settings->setUnderlined();
        $document->add(new Comment);
        $document->add($settings);
   
        $document->add(new Link("myadopts", "Manage Adoptables", TRUE));
        $document->add(new Link("profile/view/{$mysidia->user->username}", "View Profile", TRUE));
        $document->add(new Link("account/password", "Change Password", TRUE));
        $document->add(new Link("account/email", "Change Email Address", TRUE));
        $document->add(new Link("account/friends", "View and Manage FriendList", TRUE));
        $document->add(new Link("account/profile", "More Profile Settings", TRUE));
        $document->add(new Link("account/contacts", "Change Other Settings"));	
	}
	
	public function password(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;		
	    if($mysidia->input->post("submit")){		    
  	        $document->setTitle($this->lang->password_updated_title);
	        $document->addLangvar($this->lang->password_updated, TRUE);	 
            return;			
		}
	
		$document->setTitle($this->lang->password_title);
        $document->addLangvar($this->lang->password);
						  
        $formbuilder = new FormBuilder("password", "password", "post");
        $formbuilder->buildComment("Your Current Password: ", FALSE)
                    ->buildPasswordField("password", "cpass", "", TRUE)
			        ->buildComment("Your New Password: ", FALSE)
			        ->buildPasswordField("password", "np1", "", TRUE)
			        ->buildComment("Confirm Your Password: ", FALSE)
			        ->buildPasswordField("password", "np2", "", TRUE)
			        ->buildPasswordField("hidden", "action", "password")
                    ->buildComment("")
			        ->buildButton("Change Password", "submit", "submit");
        $document->add($formbuilder);
	}
	
	public function email(){
	    $mysidia = Registry::get("mysidia");	
		$document = $this->document;
	    if($mysidia->input->post("submit")){			
	        $document->setTitle($this->lang->email_update_title);
	        $document->addLangvar($this->lang->email_update);
		    return;
		}
		
		$document->setTitle($this->lang->email_title);
        $document->addLangvar($this->lang->email, TRUE);
        $formbuilder = new FormBuilder("email", "email", "post");
        $formbuilder->buildComment("New Email Address: ", FALSE)
                    ->buildPasswordField("email", "email")
			        ->buildPasswordField("hidden", "action", "changeemail", TRUE)
			        ->buildButton("Update Email Address", "submit", "submit");
        $document->add($formbuilder); 		
	}
	
	public function friends(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;
	    $friendlist = $this->getField("friendlist");
        $document->setTitle($mysidia->user->username.$this->lang->friendlist);   
        $document->add(new Paragraph(new Comment("You currently have {$friendlist->gettotal()} friends.")));
        $document->add(new Link("friends/edit", "View My Friend Request", TRUE));
        $document->add(new Link("friends/option", "Set Friend-based Options", TRUE));				
        $friendlist->display();
	}
	
	public function profile(){
		$mysidia = Registry::get("mysidia");  
	    $document = $this->document;	
	    if($mysidia->input->post("submit")){
            $document->setTitle($this->lang->profile_updated_title);
            $document->addLangvar($this->lang->profile_updated);
			return;
		}
		
		$profile = $this->getField("profile");
		$petMap = $this->getField("petMap");
	    $document->setTitle($this->lang->profile_title);  
        $document->addLangvar($this->lang->profile);
        $profileForm = new Form("profile", "profile", "post");
	    $formTitle = new Comment("Profile Details: ");
        $formTitle->setBold();
	    $formTitle->setUnderlined();
	   
	    $profileForm->add($formTitle);
	    $profileForm->add(new Comment("Avatar: ", FALSE));
	    $profileForm->add(new TextField("avatar", $profile->getAvatar()));
	    $profileForm->add(new Comment("Nickname: ", FALSE));
	    $profileForm->add(new TextField("nickname", $profile->getNickname()));
	    $profileForm->add(new Comment("Gender: "));
	     
	    $genderList = new RadioList("gender");
	    $genderList->add(new RadioButton("Male", "gender", "male"));
	    $genderList->add(new RadioButton("Female", "gender", "female"));
	    $genderList->add(new RadioButton("Unknown", "gender", "unknown"));
	    $genderList->check($profile->getGender());
	   
	    $profileForm->add($genderList);
	    $profileForm->add(new Comment("Favorite Color", FALSE));
	    $profileForm->add(new TextField("color", $profile->getColor()));
	    $profileForm->add(new Comment("Bio: "));
	    $profileForm->add(new TextArea("bio", $profile->getBio()));
	    $profileForm->add(new Comment($lang->bio));
	   
	    $petSpotLight = new Comment("Pet Spotlight Details: ");
        $petSpotLight->setBold();
	    $petSpotLight->setUnderlined();
	    $profileForm->add($petSpotLight);
	    $profileForm->add(new Comment("Favorite Pet ID: ", FALSE));

	    $favPet = new DropdownList("favpet");
	    $favPet->add(new Option("None Selected", "none"));
        $favPet->fill($petMap, $profile->getFavpetID());	  
	    $profileForm->add($favPet);
	    $profileForm->add(new Comment("Favorite Pet Bio: "));
	    $profileForm->add(new TextArea("about", $profile->getFavpetInfo()));
	    $profileForm->add(new Comment($lang->favpet));	   
	    $profileForm->add(new PasswordField("hidden", "action", "moreprofile"));
	    $profileForm->add(new Button("Edit My Profile", "submit", "submit"));
	    $document->add($profileForm);
	}
	
	public function contacts(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;		
	    if($mysidia->input->post("submit")){
            $document->setTitle($this->lang->settings_updated_title);
            $document->addLangvar($this->lang->settings_updated);
		    return;
		}
		
		$document->setTitle($this->lang->settings_title);
        $document->addLangvar($this->lang->settings);  
        $contacts = $mysidia->user->getcontacts();
        $options = $mysidia->user->getoptions();  
		
        $optionsForm = new Form("contacts", "contacts", "post");
        $optionsForm->add(new CheckBox(" Notify me via email when I receive a new message or reward code", "newmsgnotify", 1, $options->newmessagenotify));
        $details = new Comment("Publically Viewable Details: ");
        $details->setUnderlined();   
        $optionsForm->add($details);
		
 		$contactList = $this->getField("contactList"); 		
        $iterator = $contactList->iterator();
		while($iterator->hasNext()){
		    $contact = $iterator->next()->getValue();
		    $comment = new Comment("{$contact} Account: ");
	        $optionsForm->add($comment);
	        $optionsForm->add(new TextField($contact, $contacts->$contact)); 
		}
   
        $optionsForm->add(new PasswordField("hidden", "action", "changesettings"));
        $optionsForm->add(new Button("Change Settings", "submit", "submit"));
        $document->add($optionsForm);	
	}
}
?>