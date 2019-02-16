<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedList;
use Resource\Collection\LinkedHashMap;

class MyadoptsView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
	    $document->setTitle("Your adoptables");
 
        $pagination = $this->getField("pagination");
		$stmt = $this->getField("stmt")->get();
		if($stmt->rowCount() == 0){
		    $document->addLangvar($this->lang->empty);
		    return;
		}
		
		$document->add(new Comment("<table class='table table-responsive'>
			<thead>
				<tr>
					<th>Gender</th>
					<th>Name</th>
					<th>Image</th>
					<th>Clicks</th>
					<th>Level</th>
				</tr>
			</thead>
			<tbody>"));
		
		while($aid = $stmt->fetchColumn()){
		    $adopt = new OwnedAdoptable($aid);
			$document->add(new Comment("
				<tr>
					<td>{$adopt->getGender()}</td>
					<td><em>{$adopt->getName()}</em> the {$adopt->getType()}</td>
					<td><a href='myadopts/manage/{$aid}'><img src='{$adopt->getImage()}' style='min-width:100px; width:300px;' class='img-fluid'></a></td>
					<td>{$adopt->getTotalClicks()}</td>
					<td>{$adopt->getCurrentLevel()}</td>
				</tr>"));
		}
		$document->add(new Comment("
		</tbody></table>", FALSE));
		$document->addLangvar($pagination->showPage());
	}
	
	public function manage(){
		$mysidia = Registry::get("mysidia");
		$aid = $this->getField("aid")->getValue();
		$adopt = new OwnedAdoptable($aid);
		$name = $adopt->name;
		$image = $adopt->getImage();
		
		$document = $this->document;		
		$document->setTitle("Managing {$name} <small class='text-muted'>( ID #{$aid} )</small>");
		//$document->add($image);
		$document->add(new Comment("<p><img src='{$image}' class='img-fluid'></p>"));
		
		$document->add(new Image("templates/icons/add.gif"));
		$document->add(new Link("levelup/click/{$aid}", " Level Up {$name}", TRUE));
		$document->add(new Image("templates/icons/bbcodes.gif"));
		$document->add(new Link("myadopts/bbcode/{$aid}", " Get BBCodes / HTML Codes for {$name}", TRUE));
	   	$document->add(new Image("templates/icons/title.gif"));
		$document->add(new Link("myadopts/rename/{$aid}", " Rename {$name}", TRUE)); 
		$document->add(new Image("templates/icons/trade.gif"));
		$document->add(new Link("myadopts/trade/{$aid}", " Change Trade status for {$name}", TRUE)); 
		$document->add(new Image("templates/icons/freeze.gif"));
		$document->add(new Link("myadopts/freeze/{$aid}", " Freeze or Unfreeze {$name}", TRUE)); 
		$document->add(new Image("templates/icons/delete.gif"));
		$document->add(new Link("pound/pound/{$aid}", " Pound {$name}", TRUE)); 
		
		$document->add(new Comment("
			<hr>
			<div class='card'>
				<div class='card-header'>Info</div>
				<div class='card-body'>
					<ul class='list-group'>
						<li class='list-group-item'>Level: {$adopt->currentlevel}<br> EXP: {$adopt->totalclicks}</li>
						<li class='list-group-item'>Dapibus ac facilisis in</li>
						<li class='list-group-item'>Morbi leo risus</li>
						<li class='list-group-item'>Porta ac consectetur ac</li>
						<li class='list-group-item'>Vestibulum at eros</li>
					</ul>
				</div>
			</div>
			<br></br>
			<a class='btn btn-danger' data-toggle='collapse' href='#dangerzone' role='button' aria-expanded='false' aria-controls='dangerzone'>
				<i class='fas fa-exclamation-triangle'></i> Danger Zone
			</a> 
			<div class='collapse' id='dangerzone'>
				<div class='card card-body'>
					Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
				</div>
			</div>"));
	}
	
	public function stats(){
		$mysidia = Registry::get("mysidia");
		$adopt = $this->getField("adopt");		
		$stmt = $this->getField("stmt")->get();
		
		$document = $this->document;			
        $document->setTitle($adopt->getName().$this->lang->stats);
		$document->add($adopt->getStats());					   				       
        $document->addLangvar("<h2>{$adopt->getName()}'s Voters:</h2><br>{$this->lang->voters}<br><br>");	
		
        $fields = new LinkedHashMap;
		$fields->put(new Mystring("username"), new Mystring("getUsername"));
		$fields->put(new Mystring("date"), NULL);
		$fields->put(new Mystring("username::profile"), new Mystring("getProfileImage"));
		$fields->put(new Mystring("username::message"), new Mystring("getPMImage"));
		
	    $voterTable = new TableBuilder("voters", 500);
		$voterTable->setAlign(new Align("center"));
		$voterTable->buildHeaders("User", "Date Voted", "Profile", "PM");
		$voterTable->setHelper(new UserTableHelper);
		$voterTable->buildTable($stmt, $fields);
		$document->add($voterTable);
	}
	
	public function bbcode(){
		$mysidia = Registry::get("mysidia");
		$adopt = $this->getField("adopt");			
		$document = $this->document;
		$document->setTitle($this->lang->bbcode.$adopt->getName()); 
		$document->addLangvar($this->lang->bbcode_info);
		$document->add(new Comment("<br>"));
		
        $forumComment = new Comment("Forum BBCode: ");		
		$forumComment->setUnderlined();
        $forumcode = "[url={$mysidia->path->getAbsolute()}levelup/click/{$adopt->getAdoptID()}][img]{$mysidia->path->getAbsolute()}levelup/siggy/{$adopt->getAdoptID()}[/img][/url]";		
	    $forumArea = new TextArea("forumcode", $forumcode, 4, 50);
		$forumArea->setReadOnly(TRUE);
		
		$altComment = new Comment("Alternative BBCode: ");		
		$altComment->setUnderlined();
        $altcode = "[url={$mysidia->path->getAbsolute()}levelup/click/{$adopt->getAdoptID()}][img]{$mysidia->path->getAbsolute()}get/{$adopt->getAdoptID()}.gif\"[/img][/url]";
	    $altArea = new TextArea("altcode", $altcode, 4, 50);
		$altArea->setReadOnly(TRUE);
		
		$htmlComment = new Comment("HTML BBCode: ");		
		$htmlComment->setUnderlined();
        $htmlcode = "<a href='{$mysidia->path->getAbsolute()}levelup/click/{$adopt->getAdoptID()}' target='_blank'>
	                 <img src='{$mysidia->path->getAbsolute()}levelup/siggy/{$adopt->getAdoptID()}' border=0></a>";
	    $htmlArea = new TextArea("htmlcode", $htmlcode, 4, 50);
		$htmlArea->setReadOnly(TRUE);
		
		$document->add($forumComment);
		$document->add($forumArea);
		$document->add($altComment);
		$document->add(($mysidia->settings->usealtbbcode == "yes")?$altArea:new Comment("The Admin has disabled Alt BBCode for this site."));
		$document->add($htmlComment);
		$document->add($htmlArea);
	}
	
	public function rename(){
		$mysidia = Registry::get("mysidia");
		$adopt = $this->getField("adopt");		
		$image = $this->getField("image");		
		$document = $this->document;
		
		if($mysidia->input->post("submit")){
			$document->setTitle($this->lang->rename_success_title);
			$document->add($image);
			$message = "<br>{$this->lang->rename_success}{$mysidia->input->post("adoptname")}. 
					    You can now manage {$mysidia->input->post("adoptname")} on the";
			$document->addLangvar($message);
			$document->add(new Link("myadopts/manage/{$adopt->getAdoptID()}", "My Adopts Page"));
			return;
		}
		
		$document->setTitle($this->lang->rename.$adopt->getName());
		$document->add($image);
		$document->addLangvar("<br />{$this->lang->rename_default}{$adopt->getName()}{$this->lang->rename_details}<br />");
		
		$renameForm = new FormBuilder("renameform", "", "post");
		$renameForm->buildTextField("adoptname")->buildButton("Rename Adopt", "submit", "submit");
		$document->add($renameForm);		   
	}
	
	public function trade(){
		$mysidia = Registry::get("mysidia");
		$aid = $this->getField("aid")->getValue();		
		$image = $this->getField("image");	
        $message = $this->getField("message")->getValue();		
		$document = $this->document;
        $document->setTitle($this->lang->trade);
		$document->add($image);
		$document->addLangvar($message);
	}
	
	public function freeze(){
		$mysidia = Registry::get("mysidia");
		$adopt = $this->getField("adopt");		
		$image = $this->getField("image");	
        $message = $this->getField("message")->getValue();			
		$document = $this->document;		
		$document->setTitle($this->lang->freeze);	
		
		if($mysidia->input->get("confirm") == "confirm"){
			 $document->addLangvar($message);
			 $document->add(new Link("myadopts/manage/{$adopt->getAdoptID()}", "My Adopts Page"));        
	    }	 
	    else{
		    $document->add($image);
			$document->add(new Comment("<br /><b>{$adopt->getName()}'s Current Status: "));
			
		    if($adopt->isfrozen() == "yes"){			    
			    $document->add(new Image("templates/icons/freeze.gif", "Frozen"));
				$document->add(new Comment("Frozen<br<br>"));
				$document->add(new Comment($this->lang->freeze));
				$document->add(new Image("templates/icons/unfreeze.gif", "Unfreeze"));
				$document->add(new Link("myadopts/freeze/{$adopt->getAdoptID()}/confirm", "Unfreeze this Adoptable", TRUE));
			}
			else{
			    $document->add(new Image("templates/icons/unfreeze.gif", "Not Frozen"));
				$document->add(new Comment("Not Frozen<br><br>"));
				$document->add(new Comment($this->lang->freeze));
				$document->add(new Image("templates/icons/freeze.gif", "Greeze"));
				$document->add(new Link("myadopts/freeze/{$adopt->getAdoptID()}/confirm", "Freeze this Adoptable", TRUE));
			}
            $document->add(new Comment("<br><br>"));
            $document->add(new Image("templates/icons/warning.gif"));
			$document->addLangvar($this->lang->freeze_warning);
	    }
	}
}
?>