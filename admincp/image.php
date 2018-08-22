<?php

use Resource\Native\Integer;
use Resource\Native\Mystring;
use Resource\Collection\LinkedHashMap;

class ACPImageController extends AppController{

	const PARAM = "iid";
	
	public function __construct(){
        parent::__construct();
		$mysidia = Registry::get("mysidia");
		if($mysidia->usergroup->getpermission("canmanagesettings") != "yes"){
		    throw new NoPermissionException("You do not have permission to manage promocode.");
		}		
    }
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		throw new InvalidActionException("global_action");
	}
	
	public function upload(){
	    $mysidia = Registry::get("mysidia");
		
	    if($mysidia->input->post("submit")){
            $filename = htmlentities($_FILES['uploadedfile']['name']);
            $filesize = htmlentities($_FILES['uploadedfile']['size']);
            $mimetype = htmlentities($_FILES['uploadedfile']['type']);
				
			$uploaddir = "../picuploads/gif";
            $filetype = "";
            $whitelist = array(".gif");
			$date = date('Y-m-d');
			$hashstring = constant("PREFIX")."".$filename."_".$date;
            $hashedfilename = md5($hashstring);
			
			foreach ($whitelist as $ending) {
                if(substr($filename, -(strlen($ending))) == $ending) $filetype = "gif";
            }
			
			if($filetype != "gif") {
                $whitelist = array(".png");
                foreach ($whitelist as $ending) {
                    if(substr($filename, -(strlen($ending))) == $ending) $filetype = "png";
                }
            }
			
			if($filetype != "gif" and $filetype != "png"){
                $whitelist = array(".jpg");
                foreach ($whitelist as $ending) {
                    if(substr($filename, -(strlen($ending))) == $ending) $filetype = "jpg";
					else throw new UnsupportedFileException("extension");
                }
            }
			
			switch($filetype){
			    case "gif":
                    $hashedfilename = $hashedfilename.".gif";
                    $target_path = "../picuploads/gif/";
                    $uploaddir = "../picuploads/gif";
					break;
				case "png":
                    $hashedfilename = $hashedfilename.".png";
                    $target_path = "../picuploads/png/";
                    $uploaddir = "../picuploads/png";
                    break;
                case "jpg":                
                    $hashedfilename = $hashedfilename.".jpg";
                    $target_path = "../picuploads/jpg/";
                    $uploaddir = "../picuploads/jpg";
                    break;
                default:
                    throw new UnsupportedFileException("extension");				
			}
			
			$target_path = $target_path . basename( $filename );
			if(empty($hashedfilename)) throw new InvalidIDException("file_notexist");
            $existname = $uploaddir."/".$hashedfilename;
            if(file_exists($existname)) throw new DuplicateIDException("file_exist");    
			if($filesize > 156000) throw new UnsupportedFileException("file_size");
			if($mimetype != "image/gif" and $mimetype != "image/jpeg" and $mimetype != "image/png") throw new UnsupportedFileException("file_type");
			$imageInfo = getimagesize($_FILES["uploadedfile"]["tmp_name"]);
			if($imageInfo["mime"] != "image/gif" and $imageInfo["mime"] != "image/jpeg" and $imageInfo["mime"] != "image/png") throw new UnsupportedFileException("file_type");
						
			if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $uploaddir."/".$hashedfilename) and @file_exists($uploaddir."/".$hashedfilename)){
			    $this->setField("upload", new Mystring("success"));
			}
			else throw new InvalidActionException("error");
			
			$ffn = preg_replace("/[^a-zA-Z0-9\\040.]/", "", $mysidia->input->post("ffn"));
			$ffn = secure($ffn);
			if(empty($ffn)) throw new UnsupportedFileException("Unknown image");
			
			$serverpath = $uploaddir."/".$hashedfilename;
            $serverpath = str_replace("../","","{$uploaddir}/{$hashedfilename}");
			$wwwpath = $mysidia->path->getAbsolute().$serverpath;
			$mysidia->db->insert("filesmap", array("id" => NULL,  "serverpath" => $serverpath, "wwwpath" => $wwwpath, "friendlyname" => $ffn));
			return;
		}	
	}

	public function manage(){
	    $mysidia = Registry::get("mysidia");
		$stmt = $mysidia->db->select("filesmap", array("id", "wwwpath"));
		$filesMap = new LinkedHashMap;
		while($file = $stmt->fetchObject()){
		    $filesMap->put(new Integer($file->id), new Image($file->wwwpath));
		}
		$this->setField("filesMap", $filesMap);
	}
	
	public function delete(){
	    $mysidia = Registry::get("mysidia");	
        if(!$mysidia->input->post("iid")){
		    // A promocode has yet been selected, return to the index page.
		    $this->manage();
			return;
		}
		elseif(is_numeric($mysidia->input->post("iid"))){
		    $file = $mysidia->db->select("filesmap", array(), "id='{$mysidia->input->post("iid")}'")->fetchObject();
			if(!is_object($file)) throw new InvalidIDException("nonexist");
            $serverpath = "../{$file->serverpath}";
			if(!is_writable($serverpath)) throw new NoPermissionException("notwritable");
			unlink($serverpath);	
			$mysidia->db->delete("filesmap", "id='{$mysidia->input->post("iid")}'");
		}
		else throw new InvalidIDException("noid");
	}
	
	public function settings(){
	    $mysidia = Registry::get("mysidia");
	    if($mysidia->input->post("submit")){
			$mysidia->db->update("settings", array("value" => $mysidia->input->post("enablegd")), "name='gdimages'");
			$mysidia->db->update("settings", array("value" => $mysidia->input->post("altbb")), "name='usealtbbcode'");
		}
	}	
}	
?>