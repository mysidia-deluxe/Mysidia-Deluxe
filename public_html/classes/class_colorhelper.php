<?php

/**
 * The ColorHelper Class, extends from abstract GUIHelper class.
 * It is a standard helper for handling validation and transformation of color code.
 * @category Resource
 * @package GUI
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class ColorHelper extends GUIHelper{

    /**
	 * The rgbMap property, stores the rgb-name pairs.
	 * @access protected
	 * @var ArrayObject
    */	
	protected $rgbMap;
	
	/**
	 * The codeMap property, stores the code-name pairs.
	 * @access protected
	 * @var ArrayObject
    */	
	protected $CodeMap;
	
    /**
     * Constructor of ColorHelper Class, which assigns basic helper properties
	 * @param Color  $color	 
     * @access public
     * @return Void
     */
	public function __construct(Color $color){
	    parent::__construct($color);
        $this->rgbMap = new ArrayObject();
        $this->codeMap = new ArrayObject();		
	}
	
	/**
     * The getRGB method, assigns RGB property based on color code or name. 
     * @access public
     * @return Void
     */
	public function getRGB(){
    	if($this->resource->getFormat() == "code") $this->findRGBByCode();
	    elseif($this->resource->getFormat() == "name") $this->findRGBByName();
        else return;	
	}
	
	/**
     * The getCode method, assigns Code property based on color rgb or name.
     * @access public
     * @return Void
     */
	public function getCode(){
	    if($this->resource->getFormat() == "rgb") $this->findCodeByRGB();
	    elseif($this->resource->getFormat() == "name") $this->findCodeByName();
        else return;   
	}
	
	/**
     * The getName method, assigns Name property based on color rgb or code.
     * @access public
     * @return Void
     */
	public function getName(){
	    if($this->resource->getFormat() == "rgb") $this->findNameByRGB();
	    elseif($this->resource->getFormat() == "code") $this->findNameByCode();
        else return;    
	}
	
	/**
     * The findRGBByCode method, find the rgb property of color object given its hex code.
     * @access protected
     * @return Void
     */
	protected function findRGBByCode(){	
		$hexCode = str_replace("#", "", $this->resource->getCode());
		$hexCodes = str_split($hexCode, 2);
		$this->resource->setRGB(hexdec($hexCodes[0]), hexdec($hexCodes[1]), hexdec($hexCodes[2]));
	}
	
	/**
     * The findRGBByName method, find the rgb property of color object given its name.
     * @access protected
     * @return Void
     */
	protected function findRGBByName(){
	    if($this->rgbMap->count() == 0) $this->getRGBMap();
		$rgb = $this->rgbMap->offsetGet($this->resource->getName());
		
		if(!$rgb) throw new GUIException("The specfied color name is invalid.");
		$this->resource->setRGB($rgb[0], $rgb[1], $rgb[2]);
	}
	
	/**
     * The findCodeByRGB method, find the code property of color object given its rgb values.
     * @access protected
     * @return Void
     */
	protected function findCodeByRGB(){
	    $rgb = $this->resource->getRGB();
	    $hexCode = "#".dechex($rgb[0]).dechex($rgb[1]).dechex($rgb[2]);
		$this->resource->setCode($hexCode);
	}
	
	/**
     * The findCodeByName method, find the code property of color object given its name.
     * @access protected
     * @return Void
     */
	protected function findCodeByName(){
	    if($this->codeMap->count() == 0) $this->getCodeMap();
		$hexCode = $this->codeMap->offsetGet($this->resource->getName());
		
		if(!$hexCode) throw new GUIException("The specfied color name is invalid.");
		$this->resource->setCode($hexCode);
	}
	
	/**
     * The findNameByRGB method, find the name property of color object given its rgb values.
     * @access protected
     * @return Void
     */
	protected function findNameByRGB(){
	    if($this->rgbMap->count() == 0) $this->getRGBMap();
        $rgb = $this->rgbMap->getArrayCopy();
		$name = array_keys($rgb, $this->resource->getRGB()->getArrayCopy());
		$this->resource->setName($name[0]);
	}
	
	/**
     * The findNameByCode method, find the name property of color object given its hex code.
     * @access protected
     * @return Void
     */
	protected function findNameByCode(){
	    if($this->codeMap->count() == 0) $this->getCodeMap();
        $hexCode = $this->codeMap->getArrayCopy();
		$name = array_keys($hexCode, $this->resource->getCode());
		$this->resource->setName($name[0]);
	}
	
	/**
     * The getRGBMap method, initialize the RGBMap property for future use.
     * @access protected
     * @return Void
     */	
	protected function getRGBMap(){
	    $this->rgbMap->offsetSet("aliceblue", array(240, 248, 255));
	    $this->rgbMap->offsetSet("black", array(0, 0, 0));
		$this->rgbMap->offsetSet("blue", array(0, 0, 255));
		$this->rgbMap->offsetSet("brown", array(165,42,42));
		$this->rgbMap->offsetSet("coral", array(255,127,80));
        $this->rgbMap->offsetSet("cyan", array(0,255,255));
		$this->rgbMap->offsetSet("fuchsia", array(255,0,255));
		$this->rgbMap->offsetSet("gold", array(255,215,0));
		$this->rgbMap->offsetSet("green", array(0,255,0));
	    $this->rgbMap->offsetSet("grey", array(128,128,128));
		$this->rgbMap->offsetSet("indigo", array(75,0,130));
		$this->rgbMap->offsetSet("lavander", array(230,230,250));
		$this->rgbMap->offsetSet("maroon", array(128,0,0));
		$this->rgbMap->offsetSet("navy", array(0,0,128));
		$this->rgbMap->offsetSet("orange", array(255,165,0));
        $this->rgbMap->offsetSet("pink", array(255,192,203));
		$this->rgbMap->offsetSet("purple", array(128,0,128));
		$this->rgbMap->offsetSet("red", array(255,0,0));
		$this->rgbMap->offsetSet("silver", array(192,192,192));
		$this->rgbMap->offsetSet("turquoise", array(64,224,208));
        $this->rgbMap->offsetSet("violet", array(238,130,238));
		$this->rgbMap->offsetSet("white", array(255,255,255));
		$this->rgbMap->offsetSet("yellow", array(255,255,0));
	}
	
	/**
     * The getCodeMap method, initialize the CodeMap property for future use.
     * @access protected
     * @return Void
     */	
	protected function getCodeMap(){
	    $this->rgbMap->offsetSet("aliceblue", "#F0F8FF");
	    $this->codeMap->offsetSet("black", "#000000");
		$this->codeMap->offsetSet("blue", "#0000FF");
		$this->codeMap->offsetSet("brown", "#A52A2A");
		$this->codeMap->offsetSet("coral", "#FF7F50");
        $this->codeMap->offsetSet("cyan", "#00FFFF");
		$this->codeMap->offsetSet("fuchsia", "#FF00FF");
		$this->codeMap->offsetSet("gold", "#FFD700");
		$this->codeMap->offsetSet("green", "#00FF00");
	    $this->codeMap->offsetSet("grey", "#808080");
		$this->codeMap->offsetSet("indigo", "#4B0082");
		$this->codeMap->offsetSet("lavander", "#E6E6FA");
		$this->codeMap->offsetSet("maroon", "#800000");
		$this->codeMap->offsetSet("navy", "#000080");
		$this->codeMap->offsetSet("orange", "#FFA500");
        $this->codeMap->offsetSet("pink", "#FFC0CB");
		$this->codeMap->offsetSet("purple", "#800080");
		$this->codeMap->offsetSet("red", "#FF0000");
		$this->codeMap->offsetSet("silver", "#C0C0C0");
		$this->codeMap->offsetSet("turquoise", "#40E0D0");
        $this->codeMap->offsetSet("violet", "#EE82EE");
		$this->codeMap->offsetSet("white", "#FFFFFF");
		$this->codeMap->offsetSet("yellow", "#FFFF00");
	}

	/**
     * Magic method __toString for ColorHelper class, it reveals that the object is a color helper.
     * @access public
     * @return String
     */
    public function __toString(){
	    return new Mystring("This is an instance of Mysidia ColorHelper class.");
	}    
} 
?>