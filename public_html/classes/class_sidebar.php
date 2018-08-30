<?php

/**
 * The Sidebar Class, defines a standard HTML Sidebar component.
 * It extends from the Widget class, while adding its own implementation.
 * @category Resource
 * @package Widget
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class Sidebar extends Widget{

	/**
	 * The moneyBar property, specifies the money/donation bar for members.
	 * @access protected
	 * @var Paragraph
    */
    protected $moneyBar;
	
	/**
	 * The linksBar property, stores all useful links for members.
	 * @access protected
	 * @var Paragraph
    */
    protected $linksBar;
	
	/**
	 * The wolBar property, determines the who's online url in the sidebar.
	 * @access protected
	 * @var Link
    */
    protected $wolBar;
	
	/**
	 * The loginBar property, specifies the loginBar for guests.
	 * @access protected
	 * @var FormBuilder
    */
    protected $loginBar;

	/**
     * Constructor of Sidebar Class, it initializes basic sidebar properties     
     * @access public
     * @return Void
     */
    public function __construct(){
        parent::__construct(4, "sidebar");
    }
	
	/**
     * The setDivision method, setter method for property $division.
	 * It is set internally upon object instantiation, cannot be accessed in client code.
	 * @param GUIComponent  $module
     * @access protected
     * @return Void
     */
    protected function setDivision(GUIComponent $module){
	    if(!$this->division){
		    $this->division = new Division;
		    $this->division->setClass("sidebar");
		}	
		$this->division->add($module);
    }
	
	/**
     * The getMoneyBar method, getter method for property $moneyBar.
     * @access public
     * @return Paragraph
     */
    public function getMoneyBar(){
		return $this->moneyBar;
    }
	
	/**
     * The setMoneyBar method, setter method for property $moneyBar.
	 * It is set internally upon object instantiation, cannot be accessed in client code.
     * @access protected
     * @return Void
     */
    protected function setMoneyBar(){
	    $mysidia = Registry::get("mysidia");
        $this->moneyBar = new Paragraph;
		$this->moneyBar->add(new Comment("You have {$mysidia->user->money} {$mysidia->settings->cost}."));
		
		$donate = new Link("donate");
        $donate->setText("Donate Money to Friends");
        $this->moneyBar->add($donate);
        $this->setDivision($this->moneyBar);		
    }

	/**
     * The getLinksBar method, getter method for property $linksBar.
     * @access public
     * @return Paragraph
     */
    public function getLinksBar(){
		return $this->linksBar;
    }
	
	/**
     * The setLinksBar method, setter method for property $linksBar.
	 * It is set internally upon object instantiation, cannot be accessed in client code.
     * @access protected
     * @return Void
     */
    protected function setLinksBar(){
	    $mysidia = Registry::get("mysidia");
        $this->linksBar = new Paragraph;
		$linkTitle = new Comment("{$mysidia->user->username}'s Links:");
		$linkTitle->setBold();
		$this->linksBar->add($linkTitle);
		
		$linksList = new LinksList("ul");
        $this->setLinks($linksList);
		
        $this->linksBar->add($linksList);
        $this->setDivision($this->linksBar);    
    }

	/**
     * The setLinks method, append all links to the LinksBar.
	 * It is set internally upon object instantiation, cannot be accessed in client code.
     * @access protected
     * @return Void
     */
	protected function setLinks(LinksList $linksList){
		$mysidia = Registry::get("mysidia");
		$stmt = $mysidia->db->select("links", array("id", "linktext", "linkurl"), "linktype = 'sidelink' ORDER BY linkorder");
		if($stmt->rowCount() == 0) Throw new Exception("There is an error with sidebar links, please contact the admin immediately for help.");
		
		while($sideLink = $stmt->fetchObject()){
		    $link = new Link($sideLink->linkurl);
			$link->setText($sideLink->linktext);
			if($sideLink->linkurl == "messages"){
			    $num = $mysidia->db->select("messages", array("touser"), "touser='{$mysidia->user->username}' and status='unread'")->rowCount();
				if($num > 0) $link->setText("<b>{$link->getText()} ({$num})</b>");
			}
			$link->setListed(TRUE);
		    $linksList->add($link);   
		}
		
		if($mysidia->user instanceof Admin){
		    $adminCP = new Link("admincp/", FALSE, FALSE);
		    $adminCP->setText("Admin Control Panel");
		    $adminCP->setListed(TRUE);  
            $linksList->add($adminCP);			
		}
	}
	
	/**
     * The getWolBar method, getter method for property $wolBar.
     * @access public
     * @return LinksList
     */
    public function getWolBar(){
		return $this->wolBar;
    }
	
	/**
     * The setWolBar method, setter method for property $wolBar.
	 * It is set internally upon object instantiation, cannot be accessed in client code.
     * @access protected
     * @return Void
     */
    protected function setWolBar(){
	    $mysidia = Registry::get("mysidia");
		$this->wolBar = new Link("online");
        $online = $mysidia->db->select("online", array(), "username != 'Visitor'")->rowCount();
	    $offline = $mysidia->db->select("online", array(), "username = 'Visitor'")->rowCount();
        $this->wolBar->setText("This site has {$online} members and {$offline} guests online.");
        $this->setDivision($this->wolBar); 		
    }
	
	/**
     * The getLoginBar method, getter method for property $loginBar.
     * @access public
     * @return FormBuilder
     */
    public function getLoginBar(){
		return $this->loginBar;
    }
	
	/**
     * The setLoginBar method, setter method for property $loginBar.
	 * It is set internally upon object instantiation, cannot be accessed in client code.
     * @access protected
     * @return Void
     */
    protected function setLoginBar(){
	    $this->loginBar = new FormBuilder("login", "login", "post");
        $loginTitle = new Comment("Member Login:");
        $loginTitle->setBold();
        $loginTitle->setUnderlined();
        $this->loginBar->add($loginTitle);

        $this->loginBar->buildComment("username: ", FALSE)
                       ->buildTextField("username")
                       ->buildComment("password: ", FALSE)
                       ->buildPasswordField("password", "password", "", TRUE)	
					   ->buildButton("Log In", "submit", "submit")
					   ->buildComment("Don't have an account?"); 
					   
        $register = new Link("register");
        $register->setText("Register New Account");
        $register->setLineBreak(TRUE);
        $forgot = new Link("forgotpass");
		$forgot->setText("Forgot Password?");
		
		$this->loginBar->add($register);
		$this->loginBar->add($forgot);
		$this->setDivision($this->loginBar); 	
    }
}
?>