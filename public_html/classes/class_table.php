<?php

use Resource\Collection\ArrayList;
use Resource\Collection\LinkedList;

/**
 * The Table Class, extends from abstract TableContainer class.
 * It is a flexible PHP table class, can perform a series of operations.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */
 
class Table extends TableContainer{
	
	/**
	 * The bordered property, defines if the table comes with a border
	 * @access protected
	 * @var Boolean
    */
	protected $bordered = TRUE;
	
	/**
	 * The collapsed property, it specifies whether or not table borders should be collapsed.
	 * @access protected
	 * @var Boolean
    */
	protected $collapsed = FALSE;
	
	/**
	 * The spacing property, determines the distance between the borders of adjacent cells.
	 * @access protected
	 * @var String
    */
	protected $spacing;
	
	/**
	 * The caption property, stores the placement of a table caption.
	 * @access protected
	 * @var String
    */
	protected $caption;
	
	/**
	 * The empty property, it specifies whether or not to display borders and background on empty cells in a table
	 * @access protected
	 * @var String
    */
	protected $empty;
	
	/**
	 * The layout property, sets the layout algorithm to be fixed or auto.
	 * @access protected
	 * @var Boolean
    */
	protected $fixed;
	
	/**
     * Constructor of Table Class, sets up basic Table properties and calls parent constructor.   
	 * @param String  $name
	 * @param String  $width
	 * @param Boolean  $border
	 * @param String  $event
	 * @param ArrayObject  $components
     * @access publc
     * @return Void
     */
	public function __construct($name = "", $width = "", $bordered = TRUE, $event = "", $components = ""){
        parent::__construct($name, $width, $event, $components); 
		if($bordered) $this->setBordered(TRUE);				
	}
	
	/**
     * The isBordered method, getter method for property $bordered.    
     * @access public
     * @return Boolean
     */
	public function isBordered(){
	    return $this->bordered;    
	}

	/**
     * The setBordered method, setter method for property $bordered.
	 * @param Boolean  $bordered    
     * @access public
     * @return Void
     */
	public function setBordered($bordered){
	    $this->bordered = $bordered;
		if($this->bordered) $this->setAttributes("Bordered");
	}
	
	/**
     * The isCollapsed method, getter method for property $collapsed.    
     * @access public
     * @return Boolean
     */
	public function isCollapsed(){
	    return $this->collapsed;    
	}

	/**
     * The setCollapsed method, setter method for property $collapsed.
	 * @param Boolean  $collapsed   
     * @access public
     * @return Void
     */
	public function setCollapsed($collapsed){
	    $this->collapsed = $collapsed;
		$this->setTableAttributes("Collapsed");
	}
	
	/**
     * The getSpacing method, getter method for property $spacing.    
     * @access public
     * @return String
     */
	public function getSpacing(){
	    return $this->spacing;    
	}

	/**
     * The setSpacing method, setter method for property $spacing.
	 * @param Int|String  $spacing    
     * @access public
     * @return Void
     */
	public function setSpacing($spacing){
	    if(is_numeric($spacing)) $this->spacing = "{$spacing}px";
	    else $this->spacing = $spacing;
		$this->setTableAttributes("Spacing");
	}
	
	/**
     * The getCaption method, getter method for property $caption.    
     * @access public
     * @return String
     */
	public function getCaption(){
	    return $this->caption;    
	}

	/**
     * The setCaption method, setter method for property $caption.
	 * @param String  $caption    
     * @access public
     * @return Void
     */
	public function setCaption($caption){
	    $this->caption = $caption;
		$this->setTableAttributes("Caption");
	}
	
	/**
     * The getEmpty method, getter method for property $empty.    
     * @access public
     * @return String
     */
	public function getEmpty(){
	    return $this->empty;    
	}

	/**
     * The setEmpty method, setter method for property $empty.
	 * @param String  $empty    
     * @access public
     * @return Void
     */
	public function setEmpty($empty){
	    $this->empty = $empty;
		$this->setTableAttributes("Empty");
	}
	
	/**
     * The isFixed method, getter method for property $fixed.    
     * @access public
     * @return Boolean
     */
	public function isFixed(){
	    return $this->fixed;    
	}

	/**
     * The setFixed method, setter method for property $fixed.
	 * @param Boolean  $fixed 
     * @access public
     * @return Void
     */
	public function setFixed($fixed){
	    $this->fixed = $fixed;
		$this->setTableAttributes("Fixed");
	}
	
	/**
     * The fill method, fill in this table with table rows and cells.
	 * @param LinkedList  $rows
     * @param ArrayList  $cells
     * @param Int  $index	 
     * @access public
     * @return Void
     */
	public function fill(LinkedList $rows, ArrayList $cells = NULL, $index = -1){
		if($index != -1) $this->currentIndex = $index;		
		$iterator = $rows->iterator();
		
		$i = 0;
		while($iterator->hasNext()){
		    $row = $iterator->next();
			if(!($rows instanceof TRow)) throw new GUIException("The supplied row is not an instance of TableRow.");
            if($cells instanceof ArrayList) $rows->fill($cells->get($i));
		    $this->add($row, $index);
			if($index != -1) $index++;	
			$i++;
		}
	}
	
	/**
     * Magic method __toString for Table class, it reveals that the class is a Table.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is The Table class.");
	}
}
?>