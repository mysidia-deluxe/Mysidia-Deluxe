<?php

/**
 * The Menu Class, defines a standard HTML Dropdown Menu component.
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

class Menu extends Widget implements Initializable{

	/**
	 * The categories property, stores a list of link categories.
	 * @access protected
	 * @var ArrayObject
    */
    protected $categories;
	
	/**
	 * The links property, defines all links inside the dropdown menu.
	 * @access protected
	 * @var ArrayObject
    */
    protected $links;

	/**
     * Constructor of Menu Class, it initializes basic dropdown menu properties     
     * @access public
     * @return Void
     */
    public function __construct(){
		$this->categories = new ArrayObject;
		$this->links = new ArrayObject;
		$this->initialize();
    }

	/**
     * The initialize method, which handles advanced properties that cannot be initialized without a menu object.
     * It should only be called upon object instantiation, otherwise an exception will be thrown.     
     * @access public
     * @return Void
     */	
	public function initialize(){
        $mysidia = Registry::get("mysidia");
	    if($this->categories->count() != 0) throw new Exception("Initialization process already completed.");
		$menuList = new LinksList("ul");
		
		$stmt = $mysidia->db->select("links", array(), "linktype = 'navlink' and linkparent < 1 ORDER BY linkorder ASC"); 		
		while($category = $stmt->fetchObject()){
		    $menu = new LinksList; 
			$this->setCategories($menu, $category);	
					
			$stmt2 = $mysidia->db->select("links", array(), "linktype = 'navlink' and linkparent='{$category->id}' ORDER BY linkorder ASC");
            if($stmt2->rowCount() > 0){
  			    $linksList = new LinksList("ul");
			    while($item = $stmt2->fetchObject()) $this->setLinks($linksList, $item);
			    $menu->add($linksList);
			}
			$menuList->add($menu);
		}
		$this->setDivision($menuList);
	}
	
	/**
     * The setDivision method, setter method for property $division.
	 * It is set internally upon object instantiation, cannot be accessed in client code.
	 * @param GUIComponent  $menuList
     * @access protected
     * @return Void
     */
    protected function setDivision(GUIComponent $menuList){
	    $this->division = new Division;
		$this->division->setClass("ddmenu");
		$this->division->add($menuList);
    }

	/**
     * The getCategories method, getter method for property $categories.
     * @access public
     * @return ArrayObject
     */
    public function getCategories(){
		return $this->categories;
    }
	
	/**
     * The setCategories method, setter method for property $categories.
	 * It is set internally upon object instantiation, cannot be accessed in client code.
	 * @param LinksList  $menu
	 * @param Object  $category
     * @access protected
     * @return Void
     */
    protected function setCategories(LinksList $menu, $category){
		$parentLink = new Link($category->linkurl);
        $parentLink->setClass("hides");
        $parentLink->setText($category->linktext);
		
		$menu->add($parentLink);
	    $this->categories->offsetSet($category->linktext, $parentLink);
    }
	
	/**
     * The getLinks method, getter method for property $links.
     * @access public
     * @return ArrayObject
     */
    public function getLinks(){
		return $this->links;
    }	
	
	/**
     * The setLinks method, setter method for property $links.
	 * It is set internally upon object instantiation, cannot be accessed in client code.
	 * @param LinksList  $linksList
	 * @param Object  $item
     * @access protected
     * @return Void
     */
	protected function setLinks(LinksList $linksList, $item){
        $url = new URL($item->linkurl, FALSE, FALSE);
		$childLink = new Link($url);
        $childLink->setText($item->linktext);
		$childLink->setListed(TRUE);
		
		$linksList->add($childLink);
	    $this->links->offsetSet($item->linktext, $childLink);
    }
}
?>