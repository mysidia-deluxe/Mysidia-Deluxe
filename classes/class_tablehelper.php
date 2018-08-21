<?php

/**
 * The TableHelper Class, extends from abstract GUIHelper class.
 * It is a standard helper for tables to aid certain table construction operations.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class TableHelper extends GUIHelper{

	/**
	 * The frontController property, stores a reference of the frontController to be used later.
	 * @access protected
	 * @var String
    */	
    protected $frontController;
	
	/**
	 * The appController property, stores a reference of the appController to be used later.
	 * @access protected
	 * @var String
    */	
	protected $appController;

    /**
     * Constructor of TableHelper Class, it simply serves as a wrap-up.
     * @access public
     * @return Void
     */
	public function __construct(){
        $mysidia = Registry::get("mysidia");
	    $this->frontController = ($mysidia->input->get("frontcontroller")->getValue() == "index")?"":"{$mysidia->input->get("frontcontroller")}/";
		$this->appController = $mysidia->input->get("appcontroller")->getValue();    
	}

	/**
     * The getField method, returns the data field to be used by TableBuilder.   
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
    public function execMethod($field, $method, $params = ""){
        if(!$params) return $this->$method($field);
        else return $this->$method($field, $params);
    }

	/**
     * The getImage method, wraps up an image url in an image object.   
     * @param String  $src 
     * @access protected
     * @return Image
     */
    protected function getImage($src){
        return new Image(new URL($src));
    }

	/**
     * The getLink method, wraps up an image url in a hyperlink object. 
     * @param String  $href   
     * @access protected
     * @return Link
     */
    protected function getLink($href){
        return new Link(new URL($href));
    }
	
	/**
     * The getText method, wraps up the table cell with text.   
     * @param String  $param
     * @access protected
     * @return Comment
     */
    protected function getText($text){
		if(!$text) return new Comment("N/A");
        else return new Comment($text);
    }	
	
	/**
     * The getYesImage method, wraps up the table cell with a yes image.   
     * @param String  $param
     * @access protected
     * @return Image
     */
    protected function getYesImage($param = ""){
        return new Image("templates/icons/yes.gif");
    }

	/**
     * The getNoImage method, wraps up the table cell with a no image.   
     * @param String  $param
     * @access protected
     * @return Image
     */
    protected function getNoImage($param = ""){
        return new Image("templates/icons/no.gif");
    }
	
	/**
     * The getStatusImage method, wraps up the table cell with a status image.   
     * @param String  $param
     * @access protected
     * @return Image
     */
    protected function getStatusImage($param){
		if($param == "active") return $this->getYesImage();
        else return $this->getNoImage();
    }

	/**
     * The getEditLink method, wraps up the table cell with a edit image/link.   
     * @param String  $param
     * @access protected
     * @return Link
     */
    protected function getEditLink($param){
	    $mysidia = Registry::get("mysidia");
        $image = new Image("templates/icons/cog.gif");	    
        $url = new URL("{$this->frontController}{$this->appController}/edit/{$param}");
        return new Link($url, $image);
    }
	
	/**
     * The getDeleteLink method, wraps up the table cell with a delete image/link.   
     * @param String  $param
     * @access protected
     * @return Link
     */
    protected function getDeleteLink($param){
	    $mysidia = Registry::get("mysidia");
        $image = new Image("templates/icons/delete.gif");
        $url = new URL("{$this->frontController}{$this->appController}/delete/{$param}");
        return new Link($url, $image);
    }
	
	/**
     * The getModerateLink method, wraps up the table cell with a moderate image/link.   
     * @param String  $param
     * @access protected
     * @return Link
     */
    protected function getModerateLink($param){
	    $mysidia = Registry::get("mysidia");
        $image = new Image("templates/icons/status.gif");	    
        $url = new URL("{$this->frontController}{$this->appController}/moderate/{$param}");
        return new Link($url, $image);
    }	

	/**
     * Magic method __toString for TableHelper class, it reveals that the object is a table helper.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia TableHelper class.");
	}    
} 
?>