<?php

/**
 * The CustomDocument Class, specifies user generated custom documents in ACP.
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

class CustomDocument extends Widget implements Initializable{

	/**
	 * The name property, specifies the name of this document.
	 * @access protected
	 * @var String
    */
	protected $name;
	
	/**
	 * The title property, holds the information of the document title.
	 * @access protected
	 * @var String
    */
	protected $title;
	
	/**
	 * The content property, stores the html elements inside this document.
	 * @access protected
	 * @var String
    */
	protected $content;
	
	/**
	 * The date property, defines the date the custom document is created.
	 * @access protected
	 * @var String
    */
	protected $date = "";
	
	/**
	 * The code property, determines the promocode required to see this document.
	 * @access protected
	 * @var String
    */
    protected $code;
	
	/**
	 * The item property, specifies the item required to see this document.
	 * @access protected
	 * @var String
    */
    protected $item;
	
	/**
	 * The time property, specifies the time requirement for this document to be available.
	 * @access protected
	 * @var String
    */
    protected $time;
	
	/**
	 * The group property, determines which usergroup can see this document.
	 * @access protected
	 * @var String
    */
    protected $group;

	/**
     * Constructor of Menu Class, it initializes basic dropdown menu properties     
     * @access public
     * @return Void
     */
    public function __construct($document = ""){
	    $mysidia = Registry::get("mysidia"); 
		$page = $mysidia->db->select("content", array(), "page ='{$document}'")->fetchObject();
	    if(!is_object($page)) throw new PageNotFoundException($mysidia->lang->nonexist);	    
		
		$this->name = $document;
		$this->title = stripslashes($page->title);
	    $this->content = stripslashes($page->content);
	    $this->date = $page->date;
        $this->code = $page->code;	 
        $this->item = $page->item;
        $this->time = $page->time;
        $this->group = $page->group;
		$this->initialize();	
    }

	/**
     * The initialize method, which handles advanced properties that cannot be initialized without a menu object.
     * It should only be called upon object instantiation, otherwise an exception will be thrown.     
     * @access public
     * @return Void
     */	
	public function initialize(){
		$this->getAccess();
		$this->setDivision(new Comment($this->content));
	}
	
	/**
     * The setDivision method, setter method for property $division.
	 * It is set internally upon object instantiation, cannot be accessed in client code.
	 * @param GUIComponent  $document
     * @access protected
     * @return Void
     */
    protected function setDivision(GUIComponent $document){
	    $this->division = new Division;
		$this->division->setName("document");
		$this->division->add($document);
    }
	
		/**
     * The getTitle method, obtain the title of this document.	 
     * @access public
     * @return String
     */
	public function getTitle(){
	    if(!$this->title) throw new GUIException("This document has no title yet.");
	    return $this->title;
	}
	
	/**
     * The getContent method, obtain the content of this document.	 
     * @access public
     * @return String
     */
	public function getContent(){
	    if(!$this->content) $this->content = $this->render();
	    return $this->content;
	}

	/**
     * The getDate method, getter method for property $date.
     * @access public
     * @return String
     */
    public function getDate(){
		return $this->date;
    }

	/**
     * The getAccess method, determines if the user can access the custom document or not.
     * @access protected
     * @return Boolean
     */
    protected function getAccess(){
        $mysidia = Registry::get("mysidia"); 
        if($this->code){
            if($mysidia->input->post("promocode")){
                // A promocode has been entered, now process the request.
                if($this->code != $mysidia->input->post("promocode")) throw new NoPermissionException($mysidia->lang->wrongcode);     
           
                $promo = new Promocode($mysidia->input->post("promocode"));
                if($promo->pid == 0 or !$promo->validate($mysidia->input->post("promocode"))) throw new NoPermissionException($mysidia->lang->nocode);          
           
                // Now execute the action of using this promocode.
                if(!$mysidia->input->post("item")) $promo->execute();
            }
            else{
                // Show a basic form for user to enter promocode.
                $promoform = "<br><form name='form1' method='post' action='{$this->name}'><p>Your Promo Code: 
                              <input name='promocode' type='text' id='promocode'></p>
                              <p><input type='submit' name='submit' value='Enter Code'></p></form>";
                $this->title = $mysidia->lang->code_title;
                $this->content = $mysidia->lang->code.$promoform;
                return FALSE;
            }
        }    
        if($this->item){
            if($mysidia->input->post("item")){
                // An item has been selected, now process the request.
                if($mysidia->input->post("item") != $this->item) throw new NoPermissionException($mysidia->lang->wrongitem);
           
                $item = new PrivateItem($this->item, $mysidia->user->username);
                if($item->iid == 0 or $item->quantity < 1) throw new NoPermissionException($mysidia->lang->noitem);
           
                // Consume one quantity of this item if it is consumable.
                if($item->consumable == "yes") $item->remove();
            }
            else{
                // Show a basic form for user to choose an item.
                $itemform = "<form name='form1' method='post' action='{$this->name}'><br>
                             <b>Choose an Item:</b>
                             (The quantity of each item you own is shown inside the parentheses)<br> 
                             <select name='item' id='item'><option value='none' selected>None Selected</option>";
                $stmt = $mysidia->db->select("inventory", array("itemname", "quantity"), "owner = '{$mysidia->user->username}'");
                while($items = $stmt->fetchObject()){
		             $itemform .= "<option value='{$items->itemname}'>{$items->itemname} ({$items->quantity})</option>";	
                } 
                $itemform .= "</select></p><input name='promocode' type='hidden' id='promocode' value='{$this->code}'>
                              <p><input type='submit' name='submit' value='Use Item'></p></form>";

                $this->title = $mysidia->lang->item_title;
                $this->content = $mysidia->lang->item.$itemform;
                return FALSE;
            }
        }
        if($this->time){
            $time = strtotime($this->time);
            $current = time();
            if($current < $time) throw new NoPermissionException($mysidia->lang->wrongtime);
        }
        if($this->group){
            $group = $mysidia->usergroup->gid;
            if($group != $this->group) throw new NoPermissionException($mysidia->lang->notgroup);
        }
        return TRUE;
    }    
	
	/**
     * The render method for Menu class, it renders the division component and thus all subcomponents.
     * @access public
     * @return String
     */	
	public function render(){
	    return $this->division->render();
	}
}
?>