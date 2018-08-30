<?php

use Resource\Native\Integer;
use Resource\Collection\ArrayList;
use Resource\Utility\Curl;

class LevelupController extends AppController{

    const PARAM = "aid";
	private $adopt;
    private $settings;

    public function __construct(){
        parent::__construct();
        $this->settings = new LevelSetting;
		$mysidia = Registry::get("mysidia");

		if($mysidia->input->action() == "click" or $mysidia->input->action() == "siggy") $this->adopt = new OwnedAdoptable($mysidia->input->get("aid"));
		if($mysidia->user instanceof Member){
		    $status = $mysidia->user->getstatus();   
			if($status->canlevel == "no") throw new InvalidActionException("banned");
		}	
    }
	
	public function index(){
		throw new InvalidActionException("global_action");
	}
	
	public function click(){
	    $mysidia = Registry::get("mysidia");
		$date = new DateTime;
		$ip = secure($_SERVER['REMOTE_ADDR']);

		if($this->settings->system != "enabled") throw new NoPermissionException("disabled");
        elseif($this->adopt->hasVoter($mysidia->user, $date)){
		    $message = ($mysidia->user instanceof Member)?"already_leveled_member":"already_leveled_guest";
			throw new LevelupException($message);		
	    }
		elseif($this->adopt->isFrozen() == "yes") throw new LevelupException("frozen");
        elseif($mysidia->user->getVotes() > $this->settings->number) throw new LevelupException("number");
        elseif($this->settings->owner == "disabled" and $this->adopt->getOwner() == $mysidia->user->username){
 			throw new LevelupException("owner");	           
        }
		else{
		    $newClicks = $this->adopt->getTotalClicks() + 1;
			$this->adopt->setTotalClicks($newClicks, "update");
	        $mysidia->db->insert("vote_voters", array("void" => NULL, "date" => $date->format('Y-m-d'), "username" => $mysidia->user->username, "ip" => $ip, "adoptableid" => $mysidia->input->get("aid")));		 
			
			if($this->adopt->hasNextLevel()){
	            $nextLevel = $this->adopt->getNextLevel();
				$requiredClicks = $nextLevel->getRequiredClicks();
	            if($requiredClicks and $newClicks >= $requiredClicks) $this->adopt->setCurrentLevel($nextLevel->getLevel(), "update");
	        }
			
			$reward = $mysidia->user->clickreward($this->settings->reward);
		    $mysidia->user->changecash($reward);			
            $this->setField("adopt", $this->adopt);
            $this->setField("reward", new Integer($reward));			
		}
	}

	public function siggy(){
	    $mysidia = Registry::get("mysidia");
        // The adoptable is available, let's collect its info
	    $usingimage = "no";
	    $image = $this->adopt->getImage(); 
	  
	    $usegd = $mysidia->settings->gdimages;
	    $imageinfo = @getimagesize($image);
	    $imagemime = $imageinfo["mime"]; // Mime type of the image file, should be a .gif file...

	    if(function_exists('imagegif') and $usegd == "yes" and $imagemime == "image/gif"){
	        $usingimage = "yes"; //Turn the template system off
            $type = $this->adopt->getType();
            list($width, $height, $type, $attr) = getimagesize($image); // The size of the original adoptable image

	        // Lets create the new target image, with a size big enough for the text for the adoptable
	        $newheight = $height + 72;
            $newwidth = ($newwidth < 250)?250:$width;
            $img_temp = imagecreatetruecolor($newwidth, $newheight); 
            $alphablending = true;  
		 
    	    // Lets create the image and save its transparency  
            $img_old = @imagecreatefromgif($image);  
            imagealphablending($img_old, true);  
            imagesavealpha($img_old, true);
   
            // Lets copy the old image into the new image with  
            ImageCopyResampled($img_temp, $img_old, 0, 0, 0, 0, $width, $height, $width, $height);    
	        $textheight = $width + 2;
	        $image = $img_temp;
            $bgi = imagecreatetruecolor($newwidth, $newheight);
            $color = imagecolorallocate($bgi, 51, 51, 51);
		 
		    // Build text for siggy
            $str1 = "Name: ".$this->adopt->getName();
            $str2 = "Owner: ".$this->adopt->getOwner();
	        $str3 = "Click Here to Feed Me!";
	        $str4 = "More Adopts at:";
	        $str5 = "www.".constant("DOMAIN");

            // Renger Image
	        imagestring ($image, 12, 0, $textheight,  $str1, $color);
	        imagestring ($image, 12, 0, $textheight + 13,  $str2, $color);
	        imagestring ($image, 12, 0, $textheight + 26,  $str3, $color);
	        imagestring ($image, 12, 0, $textheight + 42,  $str4, $color);
	        imagestring ($image, 12, 0, $textheight + 55,  $str5, $color);
	        $background = imagecolorallocate($image, 0, 0, 0);  
            ImageColorTransparent($image, $background);  
 
            // At the very last, let's clean up temporary files
	        header("Content-Type: image/GIF");
	        ImageGif ($image);
	        imagedestroy($image);
	        imagedestroy($img_temp);
	        imagedestroy($img_old);
	        imagedestroy($bgi);

	    }
	    else{  	
	            // We are going to try and get this image the old fashioned way...
            $extList = array();
	        $extList['gif'] = 'image/gif';
	        $extList['jpg'] = 'image/jpeg';
	        $extList['jpeg'] = 'image/jpeg';
	        $extList['png'] = 'image/png';

	        //Define the output file type
	        $contentType = 'Content-type: '.$extList[ $imageinfo['extension'] ];

	        if($imageinfo['extension'] =! "image/gif" and $imageinfo['extension'] =! "image/jpeg" and $imageinfo['extension'] =! "image/png"){	         
	            throw new InvalidIDException("The file Extension is not allowed!");
	        }
	        else{
                // File type is allowed, so proceed
	            $status = "";
	            header($contentType);
                $curl = new Curl($image);
				$curl->setHeader();
				$curl->exec();
				$curl->close();
	        } 
	    }
	}
	
	public function daycare(){		
		$daycare = new Daycare;
		$adopts = $daycare->getAdopts();
		$this->setField("daycare", $daycare);
	}
}
?>