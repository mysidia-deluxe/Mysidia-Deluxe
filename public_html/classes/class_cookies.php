<?php

/**
 * The Cookies Class, it is one of Mysidia system core classes.
 * It acts as an initializer and wrapper for Mys-related cookies.
 * Cookies is a final class, no child class shall derive from it.
 * An instance of Cookies class is generated upon Mysidia system object's creation.
 * This specific instance is available from Registry, just like any other Mysidia core objects.
 * @category Resource
 * @package Core
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.2
 * @todo better naming of cookies methods.
 */

final class Cookies extends Core
{

    /**
     * The mysuid property, which stores the id of the current user.
     * For guest, this id is 0.
     * @access private
     * @var Int
    */
    private $mysuid;
  
    /**
     * The myssession property, which stores the session var of the current user.
     * @access private
     * @var String
    */
    private $myssession;
   
    /**
     * The mysactivity property, which stores the timestamp for the current user's last activity.
     * @access private
     * @var Int
    */
    private $mysactivity;
  
    /**
     * The mysloginattempt property, which stores how many failed login attempt made by this particular user.
     * @access private
     * @var Int
    */
    private $mysloginattempt;

    
    /**
     * Constructor of Cookies Class, it loads mys-related cookie vars from $_COOKIE superglobals.
     * @access public
     * @return Void
     */
    public function __construct()
    {
        $keyarray = array("mysuid", "myssession", "mysactivity", "mysloginattempt");
        foreach ($_COOKIE as $key => $val) {
            if (in_array($key, $keyarray)) {
                $this->$key = $val;
            }
        }
    }
    
    /**
     * The get method, which retrieves private cookie item from Cookies object.
     * If supplied argument is invalid, an exception will be thrown.
     * @param String  $prop
     * @access public
     * @return Boolean
     */
    public function getcookies($prop)
    {
        if (!property_exists('Cookies', $prop)) {
            throw new Exception('The specified cookie is invalid...');
        }
        return $this->$prop;
    }
  
    /**
     * The set method, which handles the four basic cookies vars for user who has just successfully logged in.
     * If operation is successful, the method returns a Boolean value True, so it can be used in conditional statement.
     * @access public
     * @return Boolean
     */
    public function setcookies($username)
    {
        $mysidia = Registry::get("mysidia");
        ob_start();
        $Month = 2592000 + time();
        $this->mysuid = $mysidia->db->select("users", array("uid"), "username = '{$username}'")->fetchColumn();
        setcookie("mysuid", $this->mysuid, $Month, "/", $_SERVER['HTTP_HOST']);
        $session = $mysidia->session->getid();
        $this->myssession = md5($this->mysuid.$session);
        setcookie("myssession", $this->myssession, $Month, "/", $_SERVER['HTTP_HOST']);
        $this->mysactivity = time();
        setcookie("mysactivity", $this->mysactivity, $Month, "/", $_SERVER['HTTP_HOST']);
        $this->mysloginattempt = 0;
        setcookie("mysloginattempt", $this->mysloginattempt, $Month, "/", $_SERVER['HTTP_HOST']);
        ob_flush();
        return true;
    }
    
    /**
     * The setadmincookie method, which handles admincp related cookies.
     * If operation is successful, the method returns a Boolean value True, so it can be used in conditional statement.
     * @access public
     * @return Boolean
     */
    public function setAdminCookies()
    {
        $mysidia = Registry::get("mysidia");
        ob_start();
        $Month = 2592000 + time();
        $session = $mysidia->session->getid();
        $this->mysadmsession = sha1($this->mysuid.$session);
        setcookie("mysadmsession", $this->mysadmsession, $Month, "/", $_SERVER['HTTP_HOST']);
        $this->mysadmloginattempt = 0;
        setcookie("mysadmloginattempt", $this->mysadmloginattempt, $Month, "/", $_SERVER['HTTP_HOST']);
        ob_flush();
        return true;
    }

    /**
     * The delete method, which gets rid of cookies to enable users to log out of the site.
     * If operation is successful, the method returns a Boolean value True, so it can be used in conditional statement.
     * @access public
     * @return Boolean
     */
    public function deletecookies()
    {
        $expire = time() - 2592000;
        ob_start();
        setcookie("mysuid", "", $expire, "/", $_SERVER['HTTP_HOST']);
        setcookie("myssession", "", $expire, "/", $_SERVER['HTTP_HOST']);
        setcookie("mysactivity", "", $expire, "/", $_SERVER['HTTP_HOST']);
        setcookie("mysloginattempt", "", $expire, "/", $_SERVER['HTTP_HOST']);
        ob_flush();
        return true;
    }

    /**
     * The login method, which evaluates the login attempt of a guest user.
     * @access public
     * @return Void
     */
    public function logincookies($reset = false)
    {
        if (!$reset) {
            $this->mysloginattempt++;
        } else {
            $this->mysloginattempt = 0;
        }
        ob_start();
        $Month = 2592000 + time();
        setcookie("mysloginattempt", $this->mysloginattempt, $Month, "/", $_SERVER['HTTP_HOST']);
        ob_flush();
    }

    /**
     * The admLogin method, which evaluates the login attempt from admin control panel.
     * @access public
     * @return Void
     */
    public function loginAdminCookies($reset = false)
    {
        if (!$reset) {
            $this->mysadmloginattempt++;
        } else {
            $this->mysadmloginattempt = 0;
        }
        ob_start();
        $Month = 2592000 + time();
        setcookie("mysadmloginattempt", $this->mysadmloginattempt, $Month, "/", $_SERVER['HTTP_HOST']);
        ob_flush();
    }
}
