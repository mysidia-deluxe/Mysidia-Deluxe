<?php

/**
 * The Path Class, it is one of Mysidia system core classes.
 * It acts as an initializer and wrapper for Mysidia-specific paths.
 * It implements PHP basic path functions, and adds enhanced features upon them.
 * An instance of Path class is generated upon Mysidia system object's creation. 
 * This specific instance is available from Registry, just like any other Mysidia core objects. 
 * @category Resource
 * @package Core
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.2
 * @todo Improvement over include_path methods to enable better auto-loading.
 */

class Path extends Core implements Initializable{

	/**
	 * The absolute property, which stores the absolute path of the main site. 
	 * @access private
	 * @var String
    */
    private $absolute;

	/**
	 * The root property, which defines the current file root directory.
	 * @access private
	 * @var String
    */
    private $root;

	/**
	 * The tempRoot property, which defines the root directory used in template files.
	 * @access private
	 * @var String
    */
    private $tempRoot;

	/**
	 * The dir property, which stores the current file sub directory.	 
	 * @access private
	 * @var String
    */
    private $dir;

	/**
	 * The path property, it specifies important file paths to be included.
	 * @access private
	 * @var ArrayObject
    */	
    private $path;

	/**
     * Constructor of Path Class, it initializes basic path properties.    
     * @access public
     * @return Void
     */	
    public function __construct(){
		$this->absolute = "http://".DOMAIN.SCRIPTPATH."/";
        $this->root = getenv('DOCUMENT_ROOT').SCRIPTPATH."/";
        $this->tempRoot = SCRIPTPATH."/";
        $this->path = new ArrayObject(array("{$this->root}classes/core", "{$this->root}classes/exception", "{$this->root}classes/user", "{$this->root}classes/message", "{$this->root}classes/item", "{$this->root}classes/shop"));	
        // MVC structure has yet been established, for now comment out the include path setup.
        //$this->initialize();		
    }

	/**
     * The initialize method, which handles basic include path operations.  
     * @access public
     * @return Void
     */		
	public function initialize(){
	    if(empty($this->dir) or empty($this->path)) throw new Exception('Cannot set basic include paths.');
	    foreach($this->path as $path){
		    $this->setIncludePath($path);  
		}
	}

	/**
     * The getAbsolute method, which retrieves private property absolute.  
     * @access public
     * @return String
     */	
    public function getAbsolute(){
        return $this->absolute;
    
    }
	
	/**
     * The getRoot method, which retrieves private property root.  
     * @access public
     * @return String
     */	
    public function getRoot(){
        return $this->root;
    
    }

	/**
     * The getScriptRoot method, which retrieves private property scriptRoot.  
     * This can be used for css stylesheet and javascript loading in header template file.
     * @access public
     * @return String
     */	
    public function getTempRoot(){
        return $this->tempRoot;
    
    }

 
	/**
     * The getDirectory method, which obtains the current directory.
     * By default this value is null, it must be assigned first in front controller. 
     * @access public
     * @return String
     */	
    public function getDirectory(){
        return $this->dir;
    }

	/**
     * The setDirectory method, set the private property dir.
     * @access public
     * @return Void
     */
    public function setDirectory($dir){
        $this->dir = $dir;
    }

	/**
     * The includes method, simulates the include and include_once function in OO way.
     * @access public
     * @return Void
     */		
	public function includes($file, $mode = NULL){
	    if($mode = "once") include_once $file;
		else include $file;
	}

	/**
     * The requires method, simulates the require and require_once function in OO way.
     * @access public
     * @return Void
     */			
	public function requires($file){
	    if($mode = "once") require_once $file;
		else require $file;
	}

	/**
     * The getIncludePath method, similar to get_include_path() function in PHP.
	 * Its functionality will expand in future releases.
     * @access public
     * @return String
     */			
	public function getIncludePath(){
	    return get_include_path();
	}

	/**
     * The setIncludePath method, similar to set_include_path() function in PHP.
	 * This method significantly simplifies multiple include path operations.
     * @access public
     * @return Void
     */		
    public function setIncludePath($path){
        set_include_path($this->getIncludePath().PATH_SEPARATOR.$path); 
    }

	/**
     * The restoreIncludePath method, similar to restore_include_path() function in PHP.
	 * Its functionality will expand in future releases.
     * @access public
     * @return Void
     */		
    public function restoreIncludePath(){
        restore_include_path();
    }	
}
?>