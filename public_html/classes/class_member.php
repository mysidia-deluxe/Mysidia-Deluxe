<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedHashMap;

class Member extends User
{
    protected $salt;
    protected $password;
    protected $session;
    protected $email;
    public $birthday;
    public $membersince;
    public $money;
    public $friends;
    public $isloggedin;
    public $profile;
    public $contacts;
    public $options;
    public $status;
  
    public function __construct($userinfo)
    {
        // Fetch the basic member properties for users
      
        $mysidia = Registry::get("mysidia");
        if ($userinfo instanceof Mystring) {
            $userinfo = $userinfo->getValue();
        }
        $userinfo = ($userinfo == "SYSTEM")?$mysidia->settings->systemuser:$userinfo;
        $whereclause = (is_numeric($userinfo))?"uid ='{$userinfo}'":"username ='{$userinfo}'";
        $row = $mysidia->db->select("users", array(), $whereclause)->fetchObject();
        // loop through the anonymous object created to assign properties
        if (!is_object($row)) {
            throw new MemberNotfoundException("The specified user {$userinfo} does not exist...");
        }
        foreach ($row as $key => $val) {
            // For field usergroup, instantiate a Usergroup Object
            $this->$key = $val;
            if ($key == "usergroup") {
                $this->usergroup = new Usergroup($val);
            }
        }
        $this->lastactivity = new DateTime();
        $this->isloggedin = UserCreator::logincheck();
    }

    public function iscurrentuser()
    {
        $mysidia = Registry::get("mysidia");
        $iscurrent = ($mysidia->user->username == $this->username)?true:false;
        return $iscurrent;
    }
  
    public function register()
    {
        throw new AlreadyLoggedinException($mysidia->lang->global_login);
    }
  
    public function login($username = "")
    {
        throw new AlreadyLoggedinException($mysidia->lang->global_login);
    }
  
    public function logout()
    {
        $mysidia = Registry::get("mysidia");
        $mysidia->session->destroy();
        if ($mysidia->cookies->getcookies("mysuid") and $mysidia->cookies->getcookies("myssession")) {
            $mysidia->cookies->deletecookies();
            $this->isloggedin = "no";
            include("inc/config_forums.php");
            if ($mybbenabled == 1) {
                include("functions/functions_forums.php");
                mybblogout();
            }
        } else {
            throw new Exception('The user is already logged out');
        }
    }

    public function getpassword()
    {
        return $this->password;
    }

    public function getsalt()
    {
        return $this->salt;
    }

    public function getemail()
    {
        return $this->email;
    }
  
    public function getonlineimg()
    {
        $mysidia = Registry::get("mysidia");
        $online = $mysidia->db->select("online", array(), "username = '{$this->username}'")->fetchObject();
        if (is_object($online)) {
            $onlineimg = "<img src='templates/icons/user_online.gif'>";
        } else {
            $onlineimg = "<img src='templates/icons/user_offline.gif'>";
        }
        return $onlineimg;
    }
  
    public function getavatar($dimension = 40)
    {
        $mysidia = Registry::get("mysidia");
        $profile = $mysidia->db->select("users_profile", array("uid", "avatar"), "username = '{$this->username}'")->fetchObject();
        $avatar = new Image($profile->avatar, "avatar", $dimension);
        return $avatar;
    }
  
    public function getcash()
    {
        return $this->money;
    }
  
    public function changecash($amount)
    {
        $mysidia = Registry::get("mysidia");
        if (!is_numeric($amount)) {
            throw new Exception('Cannot change user money by a non-numeric value!');
        }
      
        $this->money += $amount;
        if ($this->money >= 0) {
            $mysidia->db->update("users", array("money" => $this->money), "username = '{$this->username}'");
            return true;
        } else {
            throw new InvalidActionException("It seems that {$this->username} cannot afford this transaction.");
        }
    }

    public function getVotes($time = "today")
    {
        $mysidia = Registry::get("mysidia");
        $date = new DateTime($time);
        $votes = $mysidia->db->select("vote_voters", array("void"), "username = '{$this->username}' and date = '{$date->format('Y-m-d')}'")->rowCount();
        return $votes;
    }
  
    public function clickreward($amount)
    {
        $randamount = mt_rand($amount[0], $amount[1]);
        return $randamount;
    }
  
    public function donate(User $recipient, $amount)
    {
        $mysidia = Registry::get("mysidia");
        // First thing first, let's update the money field for the two users
        $this->changecash(-$amount);
        $recipient->changecash($amount);
      
        // Then attempt to send an email to the recipient
        $recipient->getoptions();
        if ($recipient->options->newmessagenotify == 1) {
            // We are sending this user an email about the donation
            $headers = "From: {$mysidia->settings->systememail}";
            $sitename = $mysidia->settings->sitename;
            $message = "Hello {$recipient->username};\n\nYou have received {$amount} {$mysidia->settings->cost} donation from {$this->username} at {$sitename}. 
						Thank You.  The {$siteName} team.";
                        
            mail($recipient->email, $sitename." - You Have Received a {$mysidia->settings->cost} Donation", $message, $headers);
        }
    }

    public function gettheme()
    {
        $mysidia = Registry::get("mysidia");
        $option = $mysidia->db->select("users_options", array("theme"), "username = '{$this->username}'")->fetchObject();
        return $option->theme;
    }
  
    public function getadopts()
    {
        return false;
    }

    public function getalladopts()
    {
        $mysidia = Registry::get("mysidia");
        $totals = $mysidia->db->select("owned_adoptables", array(), "owner = '{$this->username}'")->rowCount();
        return $totals;
    }
  
    public function getallpms($folder = "inbox")
    {
        $mysidia = Registry::get("mysidia");
        $table = ($folder == "inbox")?"messages":"folders_messages";
        $whereclause = ($folder == "inbox")?"touser='{$this->username}'":"touser='{$this->username}' AND folder='{$folder}' ORDER BY mid DESC";
        $totalRows = $mysidia->db->select($table, array(), $whereclause)->rowCount();
        return $totalRows;
    }
  
    public function getFolder($folder, Pagination $pagination)
    {
        $mysidia = Registry::get("mysidia");
        $stmt = $mysidia->db->select("folders_messages", array(), "fromuser='{$this->username}' AND folder='{$folder}' ORDER BY mid DESC LIMIT {$pagination->getLimit()},{$pagination->getRowsperPage()}");
        if ($stmt->rowCount() == 0) {
            throw new MessageNotfoundException;
        } else {
            $fields = new LinkedHashMap;
            $fields->put(new Mystring("messagetitle"), null);
            $fields->put(new Mystring("fromuser"), new Mystring("getProfile"));
            $fields->put(new Mystring("touser"), new Mystring("getProfile"));
            $fields->put(new Mystring("datesent"), null);
            $fields->put(new Mystring("mid::read"), new Mystring(($folder == "outbox")?"getOutboxReadLink":"getDraftReadLink"));
            $fields->put(new Mystring("mid::delete"), new Mystring(($folder == "outbox")?"getOutboxDeleteLink":"getDraftDeleteLink"));
          
            $folderTable = new TableBuilder($folder);
            $folderTable->setAlign(new Align("center"));
            $folderTable->buildHeaders("Message Title", "FromUser", "Recipient", "Date Appeared", "Access", "Delete");
            $folderTable->setHelper(new MessageTableHelper);
            $folderTable->buildTable($stmt, $fields);
            return $folderTable;
        }
    }
  
    public function getfriends()
    {
        return $this->friends;
    }
  
    public function getprofile()
    {
        // This method instantiate a user profile object, only called in profile.php page
        if ($this->profile) {
            return $this->profile;
        } else {
            $this->profile = new UserProfile($this->uid);
            return $this->profile;
        }
    }
  
    public function getcontacts()
    {
        $mysidia = Registry::get("mysidia");
        if (empty($this->contacts)) {
            $this->contacts = $mysidia->db->select("users_contacts", array(), "uid = '{$this->uid}'")->fetchObject();
        }
        return $this->contacts;
    }
  
    public function formatcontacts()
    {
        $sites = array("website", "facebook", "twitter");
        $ims = array("msn", "aim", "yim", "skype");
        foreach ($sites as $site) {
            $this->contacts->$site = (empty($this->contacts->$site))?"No {$site} Information Given":$this->contacts->$site;
        }
        foreach ($ims as $im) {
            $this->contacts->$im = (empty($this->contacts->$im))?"No {$im} Information Given":$this->contacts->$im;
        }
    }
    
    public function getoptions()
    {
        $mysidia = Registry::get("mysidia");
        if (empty($this->options)) {
            $this->options = $mysidia->db->select("users_options", array(), "username = '{$this->username}'")->fetchObject();
        }
        return $this->options;
    }
  
    public function getstatus()
    {
        $mysidia = Registry::get("mysidia");
        if (empty($this->status)) {
            $this->status = $mysidia->db->select("users_status", array(), "username = '{$this->username}'")->fetchObject();
        }
        return $this->status;
    }
}
