<?php

use Resource\Native\Objective;
use Resource\Native\Object;
use Resource\Native\Mystring;
use Resource\Collection\Collective;
use Resource\Collection\ArrayList;
use Resource\Collection\HashMap;

/**
 * The Registry Class, is acts as an important object storage medium.
 * It incorporates singleton design, although it holds more information than a simple singleton class.
 * @category Resource
 * @package Utility
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.2
 * @todo Not much at this point.
 *
 */

class Registry
{

    /**
     * The core property, specfies core objects that cannot be removed from registry by client users.
     * @access protected
     * @var ArrayList
     */
    protected $core;

    /**
     * The objects property, stores all objects set in this Registry with a HashMap.
     * @access protected
     * @var HashMap
     */
    protected $objects;
    
    /**
     * The instance property, defines an instance of the Registry singleton object.
     * @access protected
     * @var Registry
     * @static
     */
    protected static $instance;

    /**
     * Constructor of Registry Class, it initializes the singleton instance of this Registry Class.
     * This constructor is protected, which means it can only be called within the class or its child classes.
     * @access public
     * @return Void
     */
    protected function __construct()
    {
        $this->core = new ArrayList(16);
        $this->objects = new HashMap;
    }
 
    /**
     * The magic method clone, for Registry the clone operation is disabled.
     * @access public
     * @return Boolean
     */
    public function __clone()
    {
        return false;
    }
 
    /**
     * The clear method, unset all registered objects, except for system objects
     * This is not a static method, must call Registry::getInstance() before to use it.
     * @access public
     * @return Void
     */
    public function clear()
    {
        $this->objects->clear();
    }
 
    /**
     * The contains method, checks if an object exists in the Registry.
     * @param Objective  $key
     * @access public
     * @return Boolean
     * @static
     */
    public static function contains(Objective $key)
    {
        return self::$instance->getObjects()->containsKey($key);
    }
 
    /**
     * The extract method, acquires a collection of stored objects from the Registry.
     * This is not a static method, must call Registry::getInstance() before to use it.
     * @access public
     * @return HashMap
     */
    public function extract()
    {
        $num = func_num_args();
        $keys = func_get_args();
        if ($num == 0) {
            return $this->objects;
        }
        
        $objects = new HashMap;
        foreach ($keys as $key) {
            $objects->put(new Mystring($key), self::get($key));
        }
        return $objects;
    }
 
    /**
     * The get method, obtains an object from the Registry if it exists.
     * @param String  $key
     * @access public
     * @return Object
     * @static
     */
    public static function get($key)
    {
        $key = new Mystring($key);
        if (!self::contains($key)) {
            throw new Exception("Cannot retrieve registered object");
        }
        return self::$instance->getObjects()->get($key);
    }

    /**
     * The getCore method, getter method for property $core.
     * @access protected
     * @return ArrayList
     */
    public function getCore()
    {
        return $this->core;
    }
    
    /**
     * The getObjects method, getter method for property $objects.
     * @access protected
     * @return HashMap
     */
    public function getObjects()
    {
        return $this->objects;
    }

    /**
     * The getInstance method, getter method for static property $instance.
     * An instance is created if it does not exist, or this instance is immediately returned.
     * @access public
     * @return Registry
     * @static
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Registry;
        }
        return self::$instance;
    }
    
    /**
     * The lock method, registers an object as system object so they are not deletable.
     * @param Objective  $key
     * @access public
     * @return Void
     */
    public function lock(Objective $key)
    {
        $this->core->add($key);
    }
    
    /**
     * The insert method, fill the Registry with a collection of objects.
     * This is not a static method, must call Registry::getInstance() before to use it.
     * @param Mappable  $map
     * @param Boolean  $overwrite
     * @access public
     * @return Void
     */
    public function insert(Mappable $map, $overwrite = true)
    {
        $iterator = $map->iterator();
        while ($iterator->hasNext()) {
            $next = $iterator->next();
            self::set($next->getKey(), $next->getValue(), $overwrite);
        }
    }
    
    /**
     * The remove method, removes an object from Registry.
     * @param Objective  $key
     * @access public
     * @return Void
     * @static
     */
    public static function remove(Objective $key)
    {
        if (self::$instance->getCore()->contains($key)) {
            throw new Exception("Cannot remove core objects from Registry!");
        }
        self::$instance->getObjects()->remove($key);
    }
    
    /**
     * The set method, assigns an object to Registry at a given key.
     * If the last parameter is supplied, Registry will not allow overwrite if an object with the given key already exists.
     * @param Objective  $key
     * @param Objective  $object
     * @param Boolean  $overwrite
     * @param Boolean  $lock
     * @access public
     * @return Void
     * @static
     */
    public static function set(Objective $key, Objective $object, $overwrite = true, $lock = false)
    {
        if ($lock) {
            self::$instance->lock($key);
        }
        if (!$overwrite and self::contains($key)) {
            throw new Exception("Cannot overwrite registered object");
        } else {
            self::$instance->getObjects()->put($key, $object);
        }
    }
}
