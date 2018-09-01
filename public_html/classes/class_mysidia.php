<?php

use Resource\Native\Mystring;
use Resource\Exception\ClassNotFoundException;

/**
 * The Mysidia Class, also known as the System Class.
 * It acts as an initializer and wrapper for core system objects.
 * It is a final class, no child class may inherit from Mysidia.
 * An instance of Mysidia object is available from Registry, it is easy to use.
 * @category Resource
 * @package Core
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.2
 * @todo Coding on methods such as loadCrons() and loadPlugins().
 *
 */

final class Mysidia extends Core
{

    /**
     * version constant, displays the version of Mysidia Adoptables in String format.
    */
    const version = "1.3.4";
    
    /**
     * vercode constant, reveals the version code of Mysidia Adoptables in Int format.
    */
    const vercode = 134;
    
    /**
     * The path property, which is not yet fully developed at this point.
     * @access public
     * @var Path
    */
    public $path;
    
    /**
     * The file property, it stores information of the current file being processed.
     * @access public
     * @var File
    */
    public $file;
    
    /**
     * The db property, most useful in retrieving/handling of database queries/commands.
     * @access public
     * @var Database
    */
    public $db;
    
    /**
     * The cookies property, which stores mysidia cookie variables in a secure and convenient manner.
     * @access public
     * @var Cookies
    */
    public $cookies;
    
    /**
     * The session property, which stores mysidia session variables in a secure and convenient manner
     * @access public
     * @var Session
    */
    public $session;
    
    /**
     * The creator property, it loads a creator class used for massive object generation.
     * Default creator class loaded is the UserCreator class.
     * @access public
     * @var Creator
    */
    public $creator;
    
    /**
     * The user property, or the current user property to be precise.
     * Current user can be an instance of Member or Visitor class, it depends on circumstances.
     * @access public
     * @var User
    */
    public $user;
    
    /**
     * The usergroup property, also as a sub-property for Mysidia::$user property.
     * The usergroup property is referenced from Mysidia::$user to give it an easier access.
     * @access public
     * @var Usergroup
    */
    public $usergroup;
    
    /**
     * The settings property, it stores information of global settings for Mysidia Adoptables.
     * @access public
     * @var GlobalSetting
    */
    public $settings;
    
    /**
     * The frame property, which contains important details about the frame being browsed.
     * @access public
     * @var Frame
    */
    public $frame;
    
    /**
     * The lang property, loads controller-related language vars from folder /lang.
     * Language class development is still in beta-stage.
     * @access public
     * @var Language
    */
    public $lang;
    
    /**
     * The template property, reference of the template var being used.
     * This is a feature planned but not yet developed in Mysidia Adoptables script.
     * The staff team recommends Smarty as template engine, though Twig is a good candidate too.
     * @access public
     * @var Template
    */
    public $template;
    
    /**
     * The request property, which reveals the request method.
     * @access public
     * @var String
    */
    public $request;
    
    /**
     * The input property, it holds user input values in a secure manner.
     * This property allows user input to be accessed through OO way.
     * @access public
     * @var Input
    */
    public $input;
    
    /**
     * The plugin property, which wraps all available plugins on the system.
     * This feature is planned but not yet developed in current version.
     * @access public
     * @var Plugin
    */
    public $plugin;
    
    /**
     * The debug property, reveals whether the site is in debug mode or not
     * This feature is planned but not yet developed in current version.
     * @access public
     * @var Boolean
    */
    public $debug = false;
    
    
    /**
     * Constructor of Mysidia Class, it initializes basic system properties.
     * @access public
     * @return Void
     */
    public function __construct()
    {
        Registry::set(new Mystring("mysidia"), $this, true, true);
        $this->locatePath();
        $this->loadCurrentFile();
        $this->loadDb();
        $this->getCookies();
        $this->getSession();
        $this->getSettings();
        $this->getCurrentUser();
        $this->getFrame();
        $this->getTemplate();
        $this->parseInput();
        $this->getLanguage();
    }
  
    /**
     * The checkversion method, returns a description of current mysidia Adoptables version.
     * If the version returned is outdated, the admin will have an option to download the latest script from ACP.
     * @access public
     * @return Boolean
     */
    public function checkVersion()
    {
        $versions = trim(file_get_contents("http://www.mysidiaadoptables.com/version.txt"));
        $versions = explode(",", $versions);
        if (self::vercode >= $versions[0]) {
            return true;
        } else {
            return false;
        }
    }
  
    /**
     * The locatePath method, returns a Path object with detailed information.
     * @access public
     * @return Path
     */
    public function locatePath()
    {
        if (!class_exists('Path')) {
            throw new ClassNotFoundException('Cannot load class Path.');
        }
        $this->path = new Path;
        Registry::set(new Mystring("path"), $this->path, true, true);
        return $this->path;
    }

    /**
     * The loadCurrentFile method, gets the current file information from the server.
     * @access public
     * @return File
     */
    public function loadCurrentFile()
    {
        if (!class_exists('File')) {
            throw new ClassNotFoundException('Cannot load class File.');
        }
        $this->file = new File($_SERVER['SCRIPT_FILENAME']);
        Registry::set(new Mystring("file"), $this->file, true, true);
        return $this->file;
    }
  
    /**
     * The loadDb method, creates an instance of the Database Object to be used in the system.
     * @access public
     * @return Database
     */
    public function loadDb()
    {
        if (!class_exists('Database')) {
            throw new ClassNotFoundException('Cannot load class Database');
        }
        try {
            $this->db = new Database(DBNAME, DBHOST, DBUSER, DBPASS, PREFIX);
            Registry::set(new Mystring("database"), $this->db, true, true);
        } catch (PDOException $pe) {
            die("Could not connect to database, the following error has occurred: <br><b>{$pe->getmessage()}</b>");
        }
        return $this->db;
    }
  
    /**
     * The getCookies method, retrieves cookie information from server.
     * @access public
     * @return Cookies
     */
    public function getCookies()
    {
        if (!class_exists('Cookies')) {
            throw new ClassNotFoundException('Cannot load class Cookies.');
        }
        $this->cookies = new Cookies;
        Registry::set(new Mystring("cookies"), $this->cookies, true, true);
        return $this->cookies;
    }
  
    /**
     * The getSession method, acquires session information from server.
     * @access public
     * @return Session
     */
    public function getSession()
    {
        if (!class_exists('Session')) {
            throw new ClassNotFoundException('Cannot load class Session.');
        }
        $this->session = new Session;
        Registry::set(new Mystring("session"), $this->session, true, true);
        return $this->session;
    }
    
    /**
     * The setCreator method, sets the creator property to an instance of creator class ready to generate objects massively.
     * @param Creator $creator   Must be an instance of Creator base-class.
     * @access public
     * @return Void
     */
    public function setCreator(Creator $creator)
    {
        $this->creator = $creator;
    }
    
    /**
     * The getCurrentuser method, gets the current user information and assigns to Mysidia system properties.
     * The currentuser is generated using creator/factory method.
     * @access public
     * @return User
     */
    public function getCurrentUser()
    {
        if (!interface_exists('Creator')) {
            throw new InterfaceNotFoundException('Cannot load interface Creative.');
        }
        if (!class_exists('UserCreator')) {
            throw new ClassNotFoundException('Cannot load class UserCreator');
        }
        $this->creator = (UserCreator::logincheck())?new MemberCreator($this->cookies->getcookies("mysuid")):new VisitorCreator($_SERVER['REMOTE_ADDR']);
        $this->user = $this->creator->create();
        $this->usergroup = $this->user->usergroup;
        Registry::set(new Mystring("user"), $this->user, true, true);
        Registry::set(new Mystring("usergroup"), $this->usergroup, true, true);
        return $this->user;
    }
  
    /**
     * The getSettings method, obtains global settings information from database table prefix.settings.
     * @access public
     * @return GlobalSetting
     */
    public function getSettings()
    {
        if (!class_exists('GlobalSetting')) {
            throw new ClassNotFoundException('Cannot load class GlobalSetting.');
        }
        $this->settings = new GlobalSetting($this->db);
        Registry::set(new Mystring("settings"), $this->settings, true, true);
        return $this->settings;
    }
 
    /**
     * The getFrame method, handles frame object and information creation/processing.
     * If no specific input is provided, the page is a system document. Otherwise it is a custom document.
     * @access public
     * @return Frame
     */
    public function getFrame()
    {
        if (!class_exists('Frame')) {
            throw new ClassNotFoundException('Cannot load class Page.');
        }
        $this->frame = new Frame;
        Registry::set(new Mystring("frame"), $this->frame, true, true);
        return $this->frame;
    }
  
    /**
     * The getLanguage method, retrieves language vars from directory /lang.
     * Initial instantiation of language object only takes care of global language vars.
     * For additional controller-specific language vars to be loaded, use $lang->load() method.
     * @access public
     * @return Language
     */
    public function getLanguage()
    {
        if (!class_exists('Language')) {
            throw new ClassNotFoundException('Cannot load class Language.');
        }
        $this->lang = new Language($this->path, $this->file);
        Registry::set(new Mystring("lang"), $this->lang, true, true);
        return $this->lang;
    }
  
    /**
     * The getTemplate method, will be added later once smarty or another template engine such as Twig is implemented.
     * @access public
     * @return Template
     */
    public function getTemplate()
    {
        $templateClass = "inc/smarty/Smarty.class.php";
        require $this->path->getRoot().$templateClass;
        
        $this->template = new Template($this->path);
        Registry::set(new Mystring("template"), $this->template, true, true);
        return $this->template;
    }
  
    /**
     * The checkRequest method, it determines whether the request emthod is POST, GET or others.
     * This method returns TRUE if request method has been specified, otherwise it returns FALSE.
     * @access public
     * @return Boolean
     */
    public function checkRequest()
    {
        // This method checks if there is user input, and returns the request_method if evaluated to be true
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $this->request = "post";
        } elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
            $this->request = "get";
        }
        
        Registry::set(new Mystring("request"), $this->request, true, true);
        return (!$this->request)?false:true;
    }
  
    /**
     * The parseInput method, which handles user input in secure way and stores them in an ArrayObject.
     * In future the Input class may be incorporated into use, and thus this method will return an instance of Input class.
     * @access public
     * @return Input
     */
    public function parseInput()
    {
        if (!class_exists('Input')) {
            throw new Exception('Cannot load class Input.');
        }
        $this->input = new Input;
        Registry::set(new Mystring("input"), $this->input, true, true);
        return $this->input;
    }
  
    /**
     * The loadCrons method, a feature planned but not yet developed in this version.
     * @access public
     * @return Void
     */
    public function loadCrons()
    {
        return false;
    }
  
    /**
     * The loadPlugins method, a feature planned but not yet developed in this version.
     * @access public
     * @return Void
     */
    public function loadPlugins()
    {
        return false;
    }
  
    /**
     * The displayError method, it shows basic system errors that may appear in any part of the script.
     * @param String  $error
     * @access public
     * @return Void
     */
    public function displayError($error)
    {
        $document = $this->frame->getDocument();
        switch ($error) {
            case "register":
                $document->setTitle($this->lang->global_register_title);
                $document->addLangvar($this->lang->global_register);
                break;
            case "login":
                $document->setTitle($this->lang->global_login_title);
                $document->addLangvar($this->lang->global_login);
                break;
            case "guest":
                $document->setTitle($this->lang->global_guest_title);
                $document->addLangvar($this->lang->global_guest);
                break;
            case "id":
                $document->setTitle($this->lang->global_id_title);
                $document->addLangvar($this->lang->global_id);
                break;
            case "action":
                $document->setTitle($this->lang->global_action_title);
                $document->addLangvar($this->lang->global_action);
                break;
            case "session":
                $document->setTitle($this->lang->global_session_title);
                $document->addLangvar($this->lang->global_session);
                break;
            case "access":
                $document->setTitle($this->lang->global_access_title);
                $document->addLangvar($this->lang->global_access);
                break;
            default:
                $document->setTitle($this->lang->global_error);
                $document->addLangvar($this->lang->global_error);
        }
    }

    /**
     * The exists method, checks if a variable is available or not.
     * It serves an extension to PHP's isset() function, but supports both variable and expression.
     * @access public
     * @return Boolean
     */
    public function exists($var)
    {
        return isset($var);
    }

    /**
     * The isEmpty method, checks if a variable is empty or not.
     * It serves an extension to PHP's empty() function, but supports both variable and expression.
     * @access public
     * @return Boolean
     */
    public function isEmpty($var)
    {
        return empty($var);
    }
  
    /**
     * The output method, the very last method to call in a script to show the output to users.
     * @access public
     * @return Void
     */
    public function output()
    {
        $this->template->output();
    }
}
