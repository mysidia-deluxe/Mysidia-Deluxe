<?php

use Resource\Collection\ArrayList as ArrayList;

/**
 * The FriendTableHelper Class, extends from UserTableHelper class.
 * It is a specialized helper class to manipulate friend related tables.
 * @category Resource
 * @package Helper
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class FriendTableHelper extends UserTableHelper
{

    /**
     * Constructor of FriendTableHelper Class, it simply serves as a wrap-up.
     * @access public
     * @return Void
     */
    public function __construct()
    {
        parent::__construct();
    }
        
    /**
     * The getAcceptLink method, wraps up the table cell with an accept friend request link.
     * @param String  $param
     * @access protected
     * @return String
     */
    protected function getAcceptLink($param)
    {
        $path = Registry::get("path");
        $url = new URL("{$path->getAbsolute()}friends/edit/{$param}/accept");
        return new Link($url, $this->getYesImage());
    }
    
    /**
     * The getDeclineLink method, wraps up the table cell with an decline friend request link.
     * @param String  $param
     * @access protected
     * @return String
     */
    protected function getDeclineLink($param)
    {
        $path = Registry::get("path");
        $url = new URL("{$path->getAbsolute()}friends/edit/{$param}/decline");
        return new Link($url, new Image("{$path->getAbsolute()}templates/icons/delete.gif"));
    }
    
    /**
     * The getFriendGender method, obtains the gender image of a friend.
     * @param String  $gender
     * @access protected
     * @return String
     */
    protected function getFriendGender($gender)
    {
        $gender = strtolower($gender);
        switch ($gender) {
            case "male":
                $gender = new Image("picuploads/m.png");
                $gender->setLineBreak(true);
                break;
            case "female":
                $gender = new Image("picuploads/f.png");
                $gender->setLineBreak(true);
                break;
            default:
                $gender = new Comment("");
        }
        return $gender;
    }
    
    protected function getFriendOnline($name)
    {
        $mysidia = Registry::get("mysidia");
        $userexist = $mysidia->db->select("online", array("username"), "username='{$name}'")->fetchColumn();
        $online = (!$userexist)?new Image("templates/icons/user_offline.gif", "{$name} is offline")
                               :new Image("templates/icons/user_online.gif", "{$name} is online");
        return $online;
    }
    
    /**
     * The getFriendInfo method, wraps up an entire cell with friend information.
     * @param Friend  $friend
     * @access public
     * @return ArrayList
     */
    public function getFriendInfo(Member $friend)
    {
        $info = new ArrayList;
        $info->add(new Link("profile/view/{$friend->username}", "<strong>{$friend->username}</strong>"));
        $info->add($this->getFriendGender($friend->profile->getGender()));
        $info->add(new Comment($friend->profile->getnickname()));
        $info->add($this->getFriendOnline($friend->username));
        $info->add(new Link($friend->contacts->website, new Image("templates/icons/web.gif")));
        $info->add(new Link("messages/newpm/{$friend->username}", new Image("templates/icons/title.gif")));
        return $info;
    }

    /**
     * Magic method __toString for FriendTableHelper class, it reveals that the object is a friend table helper.
     * @access public
     * @return String
     */
    public function __toString()
    {
        return new Mystring("This is an instance of Mysidia FriendTableHelper class.");
    }
}
