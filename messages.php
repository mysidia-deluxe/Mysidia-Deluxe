<?php 

use Resource\Native\String; 

class MessagesController extends AppController{ 

    const PARAM = "id"; 
    private $message; 

    public function __construct(){ 
        parent::__construct("member");     
        $mysidia = Registry::get("mysidia");         
        $mysidia->user->getstatus();     
        if($mysidia->user->usergroup->getpermission("canpm") == "no"){ 
            throw new NoPermissionException("banned"); 
        } 
    } 
     
    public function index(){ 
        $mysidia = Registry::get("mysidia"); 
        try{ 
            $total = $mysidia->user->getallpms(); 
            $pagination = new Pagination($total, 10, "messages"); 
            $pagination->setPage($mysidia->input->get("page"));     
            $stmt = $mysidia->db->select("messages", array(), "touser='{$mysidia->user->username}' ORDER BY id DESC LIMIT {$pagination->getLimit()},{$pagination->getRowsperPage()}");         
            $this->setField("pagination", $pagination); 
            $this->setField("stmt", new DatabaseStatement($stmt)); 
        } 
        catch(MessageNotfoundException $pne){ 
            $this->setFlags("nonexist_title", "nonexist"); 
        }    
    } 
     
    public function read(){ 
        $mysidia = Registry::get("mysidia"); 
        try{ 
            $this->message = new PrivateMessage($mysidia->input->get("id")); 
        } 
        catch(MessageNotfoundException $pne){ 
            $this->setFlags("nonexist_title", "nonexist"); 
            return; 
        }     

        if ($this->message->touser != $mysidia->user->username) { 
            throw new NoPermissionException('This is NOT your message to read.'); 
            return; 
        } 
         
        $this->setField("message", $this->message); 
        if(!empty($this->message->status) and $this->message->status != "read"){ 
            $this->message->status = "read"; 
            $this->message->setRead($this->message->status); 
        }         
    } 
     
    public function newpm(){ 
        $mysidia = Registry::get("mysidia");     
        if($mysidia->input->post("submit")){ 
            try{ 
                $recipient = new Member($mysidia->input->post("recipient")); 
                $recipient->getoptions(); 
            } 
            catch(MemberNotfoundException $mne){ 
                $this->setFlags("error", "error_user"); 
                return;                 
            } 
             
            $this->validate($recipient); 
              $message = new PrivateMessage; 
            $message->setrecipient($recipient->username); 
            if($mysidia->input->post("draft") == "yes"){ 
                $message->folder = "draft"; 
                $message->postDraft(); 
            } 
            elseif($mysidia->input->post("draftedit") == "yes"){ 
                $message->setmessage($mysidia->input->post("mtitle"), $mysidia->input->post("mtext")); 
                $message->editDraft(); 
            } 
            else $message->post(); 
        } 
    } 
     
    public function delete(){ 
        $mysidia = Registry::get("mysidia"); 
        try{ 
            $this->message = new PrivateMessage($mysidia->input->get("id")); 
            if ($this->message->touser != $mysidia->user->username) { 
                throw new NoPermissionException('This is NOT your message to delete.'); 
                return; 
            } 
            $this->message->remove(); 
        } 
        catch(MessageNotfoundException $pne){ 
            $this->setFlags("nonexist_title", "nonexist"); 
        }     
    } 
     
    public function outbox(){ 
        $mysidia = Registry::get("mysidia"); 
        try{ 
            $total = $mysidia->user->getallpms("outbox"); 
            $pagination = new Pagination($total, 10, "messages/outbox"); 
            $pagination->setPage($mysidia->input->get("page")); 
            $folder = $mysidia->user->getFolder("outbox", $pagination);         
            $this->setField("pagination", $pagination); 
            $this->setField("folder", $folder); 
        } 
        catch(MessageNotfoundException $pne){ 
            $this->setFlags("message_error", "outbox_empty"); 
        }    
    } 
     
    public function outboxread(){ 
        $mysidia = Registry::get("mysidia"); 
        try{ 
            $this->message = new PrivateMessage($mysidia->input->get("id"), "outbox"); 
            if ($this->message->fromuser != $mysidia->user->username) { 
                throw new NoPermissionException('This is NOT your message to read.'); 
                return; 
            } 
            $this->setField("message", $this->message); 
        } 
        catch(MessageNotfoundException $pne){ 
            $this->setFlags("nonexist_title", "nonexist"); 
            return; 
        }     
    } 
     
    public function outboxdelete(){ 
        $mysidia = Registry::get("mysidia"); 
        try{ 
            $this->message = new PrivateMessage($mysidia->input->get("id"), "outbox"); 
            if ($this->message->fromuser != $mysidia->user->username) { 
                throw new NoPermissionException('This is NOT your message to delete.'); 
                return; 
            } 
            $this->message->remove(); 
        } 
        catch(MessageNotfoundException $pne){ 
            $this->setFlags("nonexist_title", "nonexist"); 
        }     
    } 
     
    public function draft(){ 
        $mysidia = Registry::get("mysidia");  
        try{ 
            $total = $mysidia->user->getallpms("draft"); 
            $pagination = new Pagination($total, 10, "messages/draft"); 
            $pagination->setPage($mysidia->input->get("page")); 
            $folder = $mysidia->user->getFolder("draft", $pagination); 
            $this->setField("pagination", $pagination); 
            $this->setField("folder", $folder); 
        } 
        catch(MessageNotfoundException $pne){ 
            $this->setFlags("message_error", "draft_empty"); 
        }      
    } 
     
    public function draftedit(){ 
        $mysidia = Registry::get("mysidia"); 
        try{ 
            $this->message = new PrivateMessage($mysidia->input->get("id"), "draft"); 
            if ($this->message->fromuser != $mysidia->user->username) { 
                throw new NoPermissionException('This is NOT your message to edit.'); 
                return; 
            } 
            $this->setField("message", $this->message);             
        } 
        catch(MessageNotfoundException $pne){ 
            $this->setFlags("nonexist_title", "nonexist"); 
        } 
    } 
     
    public function draftdelete(){ 
        $mysidia = Registry::get("mysidia"); 
        try{ 
            $this->message = new PrivateMessage($mysidia->input->get("id"), "draft"); 
            if ($this->message->fromuser != $mysidia->user->username) { 
                throw new NoPermissionException('This is NOT your message to delete.'); 
                return; 
            } 
            $this->message->remove();             
        } 
        catch(MessageNotfoundException $pne){ 
            $this->setFlags("nonexist_title", "nonexist"); 
        } 
    } 
     
    public function report(){ 
        $mysidia = Registry::get("mysidia"); 
        try{ 
            $this->message = new PrivateMessage($mysidia->input->get("id")); 
        } 
        catch(MessageNotfoundException $pne){ 
            $this->setFlags("nonexist_title", "nonexist"); 
            return; 
        } 

        if($mysidia->input->post("submit")){         
            $this->message->report(); 
            return; 
        }         
        $admin = new Admin($mysidia->settings->systemuser); 
        $this->setField("message", $this->message); 
        $this->setField("admin", $admin); 
    } 
     
    protected function validate(User $recipient){ 
        $mysidia = Registry::get("mysidia"); 
        if(!empty($recipient->friends)) $friends = explode(",", $recipient->friends); 
        $isfriend = (empty($recipient->friends) or !in_array($mysidia->user->uid, $friends))?"no":"yes";             
        if($recipient->options->pmstatus == 1 and $isfriend == "no") throw new InvalidActionException("error_friend"); 
        if(!$mysidia->input->post("mtitle") or !$mysidia->input->post("mtext")) throw new InvalidActionException("error_blank"); 
        if($mysidia->input->post("outbox") == "yes" and $mysidia->input->post("draft")) throw new InvalidActionException("draft_conflict");      
    } 
}
