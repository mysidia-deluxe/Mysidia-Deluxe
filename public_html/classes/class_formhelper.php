<?php

/**
 * The FormHelper Class, extends from abstract GUIHelper class.
 * It is a standard helper for tables to aid certain form construction operations.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class FormHelper extends GUIHelper{
	
    /**
     * Constructor of FormHelper Class, which assigns basic helper properties	 
     * @access public
     * @return Void
     */
	public function __construct(){

	}

	/**
     * The getField method, returns the data field to be used by FormBuilder.   
     * @param String  $field
     * @access public
     * @return String
     */
    public function getField($field){
		if(strpos($field, "::") !== FALSE){
		    $field = explode("::", $field);
            $field	= $field[0];					
		}
        return $field;
    }

	/**
     * The execMethod method, returns the field content after executing the method. 
     * @param String  $field
     * @access public
     * @return String
     */
    public function execMethod($field, $method){
        if(!$this->resource->getParams()) return $this->$method($field);
        else{
            $params = $this->resource->getMethods->offsetGet($field);
            return $this->$method($field, $params);
        }
    }
	
	/**
     * The buildImageList method, builds a dropdown list for admin uploaded images.
	 * @param String  $name
     * @access public
     * @return DropdownList
     */		
	public function buildImageList($name){
        $mysidia = Registry::get("mysidia");
		$imageList = new DropdownList($name);
	    $stmt = $mysidia->db->select("filesmap", array("friendlyname", "wwwpath"), "1 ORDER BY id");
		$images = $mysidia->db->fetchMap($stmt);
	    $imageList->add(new Option("Nothing Selected", "none"));
	    $imageList->fill($images);
		return $imageList;
	}
	
	/**
     * The buildAdoptTypeList method, builds a dropdown list for available adoptable types.
	 * @param String  $name
     * @access public
     * @return DropdownList
     */		
	public function buildAdoptTypeList($name){
        $mysidia = Registry::get("mysidia");
		$typeList = new DropdownList($name);
	    $stmt = $mysidia->db->select("adoptables", array("type"), "1 ORDER BY id");
		$types = $mysidia->db->fetchList($stmt);		
	    $typeList->add(new Option("Select an Adoptable...", "select"));
	    $typeList->fill($types);
		return $typeList;
	}
	
	/**
     * The buildUsergroupList method, builds a dropdown list for available usergroups.
	 * @param String  $name
     * @access public
     * @return DropdownList
     */		
	public function buildUsergroupList($name){
        $mysidia = Registry::get("mysidia");
		$groupList = new DropdownList($name);
	    $stmt = $mysidia->db->select("groups", array("groupname", "gid"));
		$groups = $mysidia->db->fetchMap($stmt);
	    $groupList->add(new Option("No Group Selected", "none"));
	    $groupList->fill($groups);
		return $groupList;
	}
	
	/**
     * The buildAdoptShopList method, builds a dropdown list for available adoptable shops.
	 * @param String  $name
     * @access public
     * @return DropdownList
     */		
	public function buildAdoptShopList($name){
        $mysidia = Registry::get("mysidia");
		$shopList = new DropdownList($name);
	    $stmt = $mysidia->db->select("shops", array("shopname"), "shoptype = 'adoptshop'");
		$shops = $mysidia->db->fetchList($stmt);		
	    $shopList->add(new Option("No Shop Selected", "none"));
	    $shopList->fill($shops);
		return $shopList;
	}
	
	/**
     * The buildItemFunctionList method, builds a dropdown list for available item functions.
	 * @param String  $name
     * @access public
     * @return DropdownList
     */		
	public function buildItemFunctionList($name){
        $mysidia = Registry::get("mysidia");
		$functionList = new DropdownList($name);
	    $stmt = $mysidia->db->select("items_functions", array("function"), "1 ORDER BY ifid");
		$functions = $mysidia->db->fetchList($stmt);		
	    $functionList->fill($functions);
		return $functionList;
	}
	
	/**
     * The buildParentLinkList method, builds a dropdown list for available parent links.
	 * @param String  $name
     * @access public
     * @return DropdownList
     */		
	public function buildParentLinkList($name){
        $mysidia = Registry::get("mysidia");
		$linkList = new DropdownList($name);
	    $stmt = $mysidia->db->select("links", array("linktext", "id"), "1 ORDER BY id");
		$links = $mysidia->db->fetchMap($stmt);
		$linkList->add(new Option("No Link Selected", "none"));
	    $linkList->fill($links);
		return $linkList;
	}
	
	/**
     * The buildThemeList method, builds a dropdown list for available themes.
	 * @param String  $name
     * @access public
     * @return DropdownList
     */		
	public function buildThemeList($name){
        $mysidia = Registry::get("mysidia");
		$themeList = new DropdownList($name);
		$stmt = $mysidia->db->select("themes", array("themename", "themefolder"), "1 ORDER BY id");	
		$themes = $mysidia->db->fetchMap($stmt);
		$themeList->add(new Option("Select a Theme", "none"));
	    $themeList->fill($themes);
		return $themeList;
	}

	/**
     * Magic method __toString for FormHelper class, it reveals that the object is a form helper.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia FormHelper class.");
	}    
} 
?>