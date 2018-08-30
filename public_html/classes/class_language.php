<?php

/**
 * The Language Class, it locates and stores lang vars to be used in document.
 * A frame object is sent into the template file, its components can be displayed at any given locations.
 * @category Resource
 * @package Core
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.2
 * @todo Not much at this point.
 * @final
 *
 */

final class Language extends Core implements Initializable{

	/**
	 * The dir property, it stores a reference of the directory of lang file.
	 * @access private
	 * @var String
    */
    private $dir;
	
	/**
	 * The file property, it stores a copy of the lang file object for reference.
	 * @access private
	 * @var File
    */
    private $file;
	
	/**
	 * The global property, it defines global lang vars available in every script file.
	 * @access public
	 * @var ArrayObject
    */	
    public $global;
	
	/**
	 * The lang property, it specifies local lang vars only available in a specific script file.
	 * @access public
	 * @var ArrayObject
    */	
    public $lang;

	/**
     * Constructor of Language Class, it initializes basic language properties.   
     * @param Path  $path
     * @param File  $file	 
     * @access public
     * @return Void
     */
    public function __construct(Path $path, File $file){ 
        $this->dir = $path->getRoot();
	    $this->file = $file;
	    $this->initialize();
    }
	
  	/**
     * The magic method get, retrieves a lang var from the language collection.
     * @access public
     * @return String
     */
    public function __get($property){
        if(strpos($property, 'global') !== FALSE) return $this->global->{$property};
        elseif(isset($this->lang->{$property})) return $this->lang->{$property};
        else throw new LanguageException("Language var {$property} does not exist."); 
    }

	/**
     * The initialize method, this operation sets up the entire language object. 
     * @access public
     * @return Void
     */	
    public function initialize(){
        $globallangfile = "{$this->dir}lang/lang_global.php";
	    require $globallangfile;
        $this->global = new ArrayObject($lang, ArrayObject::ARRAY_AS_PROPS);
    }
 
 	/**
     * The load method, it loads local lang vars into the language object for future use.
     * @access public
     * @return Void
     */
    public function load(){	 
        $mysidia = Registry::get("mysidia"); 
	    $thisfile = $this->file->getBasename();	
	    $thislangfile = $this->locate($thisfile);
        $langfile = new File($thislangfile);
   
	    if($langfile->isReadable()){ 
            require $thislangfile;
		    if(!is_array($lang)) throw new Exception("Failed to load language vars in file {$langfile}.");	
            $this->lang = new ArrayObject($lang, ArrayObject::ARRAY_AS_PROPS);	
	    }	 
    }

	 /**
     * The locate method, finds the directories and files that store lang vars.
	 * This method should be deprecated in Mys v1.4.0 after fixing up file structure.
     * @access private
     * @return Void
     */	
    private function locate($file){
        $mysidia = Registry::get("mysidia");
        if($mysidia->input->get("frontcontroller") != "index"){
            $controller = "{$mysidia->input->get("frontcontroller")}/";
        }
        return "{$this->dir}lang/{$controller}lang_{$mysidia->input->get("appcontroller")}.php";
    }

	/**
     * The format method, it formats a lang var with given placeholders.
	 * Its not functioning yet at this point, future work is needed for this method to be useful.
     * @access public
     * @return Void
     */
    public function format($langvar){	 
	    $placeholders = func_get_args();
	    $num = func_num_args();	 
	    for($i = 1; $i < $num; $i++){
	        $langvar = str_replace('{'.$i.'}', $placeholders[$i], $langvar);
	    }
	    return $langvar;
    }  
}
?>