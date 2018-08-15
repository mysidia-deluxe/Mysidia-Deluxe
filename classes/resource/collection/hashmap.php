<?php

namespace Resource\Collection;
use Resource\Native\Objective;
use Resource\Native\Arrays;
use Resource\Exception\IllegalArgumentException; 

/**
 * The HashMap Class, extending from the abstract Map Class.
 * It is a standard hash table based implementation, but does not guarantee the order of the Map.
 * @category Resource
 * @package Collection
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class HashMap extends Map{

	/**
	 * serialID constant, it serves as identifier of the object being HashMap.
     */
    const SERIALID =  "362498820763181265L";
	
	/**
	 * defaultCapacity constant, it defines the initial capacity used if no such argument is specified.
     */
    const DEFAULTCAPACITY = 16;	

	/**
	 * defaultLoad constant, it specifies the initial load factor used if no such argument is specified.
     */
    const DEFAULTLOAD = 0.75;		
	
    /**
	 * The entries property, it stores an array of Entrys specified in the HashMap.
	 * @access protected
	 * @var Arrays
     */
    protected $entries;	
	
    /**
	 * The entrySet property, it stores entries of this HashMap in Set Format, ready to iterate.
	 * @access protected
	 * @var Settable
    */
	protected $entrySet;	

	/**
	 * The loadFactor property, it stores the floating value load factor for the HashMap
	 * @access protected
	 * @var Float
     */
    protected $loadFactor;		
	
    /**
	 * The size property, it specifies the current size of the Entrys inside the HashMap.
	 * @access protected
	 * @var Int
     */
    protected $size;

    /**
	 * The threshold property, it defines the next size value that the internal array in HashMap needs to increase.
	 * @access protected
	 * @var Int
     */
    protected $threshold;
	
	/**
     * Constructor of HashMap Class, it initializes the HashMap given its capacity or another Collection Object.    
     * @param Int|Mappable  $param
	 * @param Float  $loadFactor
     * @access public
     * @return Void
     */	
	public function __construct($param = self::DEFAULTCAPACITY, $loadFactor = self::DEFAULTLOAD){
	    if(is_int($param)){
            if($param <= 0) throw new IllegalArgumentException("The initial Capacity of HashMap cannot be less than 0.");  
			if($loadFactor <= 0 or !is_numeric($loadFactor)) throw new IllegalArgumentException("The load factor for HashMap must be a positive number.");			
			$capacity = 1;
			while($capacity < $param) $capacity = $capacity << 1;
			$this->initialize($capacity, $loadFactor);
        }
        elseif($param instanceof Mappable){
            $capacity = (int)($param->size()/self::DEFAULTLOAD + 1);
			$capacity = ($capacity > self::DEFAULTCAPACITY)?$capacity:self::DEFAULTCAPACITY;
			$this->initialize($capacity, $loadFactor);
			$this->createAll($param);
        }		
        else throw new IllegalArgumentException("Invalid Argument specified.");
	}

	/**
     * The addEntry method, adds an entry with a specific key, value and hash code. 
	 * @param Int  $hash
     * @param Objective  $key
	 * @param Objective  $value
	 * @param Int  $index
     * @access public
     * @return Void
     */		
	public function addEntry($hash = 0, Objective $key = NULL, Objective $value = NULL, $index = 0){
	    $entry = $this->entries[$index];
        $this->entries[$index] = new HashMapEntry($hash, $key, $value, $entry);
        if($this->size++ >= $this->threshold) $this->resize(2*$this->entries->length());		
	}		

	/**
     * The capacity method, obtains the capacity of this HashMap.
     * @access public
     * @return Int
     */		
	public function capacity(){
	    return $this->entries->length();
	}	
	
 	/**
     * The clear method, drops all key-value pairs currently stored in this HashMap.
     * @access public
     * @return Void
     */			
	public function clear(){
	    $entries = $this->entries;
        for($i = 0; $i < $entries->length(); $i++){
            $entries[$i] = NULL;
        }
        $this->size = 0;		
	}	
	
	/**
     * The containsKey method, checks if the HashMap contains a specific key among its key-value pairs.
     * @param Objective  $key
     * @access public
     * @return Boolean
     */		
	public function containsKey(Objective $key = NULL){
	    return ($this->getEntry($key) != NULL);
	}		

	/**
     * The containsNull method, checks if the HashMap contains a Null value among its key-value pairs.
     * @access private
     * @return Boolean
     */		
	private function containsNull(){
		$entries = $this->entries;
		for($i = 0; $i < $entries->length(); $i++){
		    for($entry = $entries[$i]; $entry != NULL; $entry = $entry->getNext()){
                if($entry->getValue() == NULL) return TRUE;
            }			
		}
        return FALSE;
    }		
	
	/**
     * The containsValue method, checks if the HashMap contains a specific value among its key-value pairs.
     * @param Objective  $object 
     * @access public
     * @return Boolean
     */		
	public function containsValue(Objective $value = NULL){
	    if($value == NULL) return $this->containsNull();
		$entries = $this->entries;
		for($i = 0; $i < $entries->length(); $i++){
		    for($entry = $entries[$i]; $entry != NULL; $entry = $entry->getNext()){
                if($value->equals($entry->getValue())) return TRUE;
            }			
		}
        return FALSE;
    }		
	
	/**
     * The create method, it is used instead of put by constructors if a Mappable object is supplied.
     * @param Objective  $key
	 * @param Objective  $value
     * @access private
     * @return Void
     */		
	private function create(Objective $key = NULL, Objective $value = NULL){
 	    $hash = ($key == NULL)?0:$this->hash($key->hashCode());
		$index = $this->indexFor($hash, $this->entries->length());
		for($entry = $this->entries[$index]; $entry != NULL; $entry = $entry->getNext()){
		    $object = $entry->getKey();
            if($entry->getHash() == $hash and ($object == $key or ($key != NULL and $key->equals($object)))){
                $entry->setValue($value);
				return;
            }			
		}
		$this->createEntry($hash, $key, $value, $index);
		return NULL;       		
	}

	/**
     * The createAll method, it is used instead of put by constructors if a Mappable object is supplied.
     * @param Mappable  $map
     * @access private
     * @return Void
     */		
	private function createAll(Mappable $map){
	    $iterator = $map->iterator();
 	    while($iterator->hasNext()){
            $entry = $iterator->next();
			$this->create($entry->getKey(), $entry->getValue());
        }		
	}

	/**
     * The createEntry method, it is similar to addEntry but is only used in HashMap Constructor.
	 * It has an advantage of not having to worry about the Entries size.
	 * @param Int  $hash
     * @param Objective  $key
	 * @param Objective  $value
	 * @param Int  $index
     * @access public
     * @return Void
     */		
	public function createEntry($hash = 0, Objective $key = NULL, Objective $value = NULL, $index = 0){
	    $entry = $this->entries[$index];
        $this->entries[$index] = new HashMapEntry($hash, $key, $value, $entry);
        $this->size++;	
	}		

	/**
     * The entryIterator method, acquires an instance of the EntryIterator object of this HashMap.
     * @access public
     * @return EntryIterator
     */			
	public function entryIterator(){
        return new EntryIterator($this);	
    }

	/**
     * The entrySet method, returns a Set of entries contained in this HashMap.
     * @access public
     * @return EntrySet
     */		
	public function entrySet(){
        $entrySet = ($this->entrySet == NULL)?new EntrySet($this):$this->entrySet;
		return $entrySet;
    }	
	
 	/**
     * The get method, acquires the value stored in the HashMap given its key.
     * @param Objective  $key
     * @access public
     * @return Objective
     */		
 	public function get(Objective $key){
	    if($key == NULL) return $this->getNull();
	    $hash = $this->hash($key->hashCode());
		$index = $this->indexFor($hash, $this->entries->length());
		for($entry = $this->entries[$index]; $entry != NULL; $entry = $entry->getNext()){
		    $object = $entry->getKey();
            if($entry->getHash() == $hash and ($object == $key or $key->equals($object))) return $entry->getValue();			
		}
		return NULL;
	}
	
	/**
     * The getEntry method, returns the entry associated with the specified key in HashMap.
	 * This is a final method, and thus can not be overriden by child class.
     * @param Objective  $key
     * @access public
     * @return Entry
	 * @final
     */		
	public final function getEntry(Objective $key = NULL){
	    $hash = ($key == NULL)?0:$this->hash($key->hashCode());
		$index = $this->indexFor($hash, $this->entries->length());
		for($entry = $this->entries[$index]; $entry != NULL; $entry = $entry->getNext()){
		    $object = $entry->getKey();
			if($entry->getHash() == $hash and ($object == $key or ($object != NULL and $key->equals($object)))) return $entry;
		}
		return NULL;
	}	

	/**
     * The getEntries method, acquires the Entries Array stored inside the HashMap.
     * @param Objective  $key
     * @access public
     * @return Arrays
     */		
	public function getEntries(){
	    return $this->entries;
	}		
	
 	/**
     * The getNull method, acquires a value from the Null Key stored in HashMap.
     * @access private
     * @return Objective
     */	
    private function getNull(){
	    for($entry = $this->entries[0]; $entry != NULL; $entry = $entry->getNext()){
            if($entry->getKey() == NULL) return $entry->getValue();
        }
        return NULL;		
    }

	/**
     * The hash method, it applies supplemental hash function to a given HashCode.
	 * @param Int  $hash
     * @access public
     * @return Int
     */			
    public function hash($hash){
	    $hash = ($hash >> 20) ^ ($hash >> 12);
		return ($hash ^ ($hash >> 7) ^ ($hash >> 4));
	}

	/**
     * The indexFor method, it returns index for HashCode $hash.
	 * @param Int  $hash
	 * @param Int  $length
     * @access public
     * @return Int
     */			
    public function indexFor($hash, $length = 1){
	    return ($hash & ($length - 1)); 
	}		
	
 	/**
     * The initialize method, initializes basic HashMap properties.
     * @param Int  $capacity
	 * @param Float  $loadFactor
     * @access private
     * @return Objective
     */	
    private function initialize($capacity, $loadFactor){
	    $this->loadFactor = $loadFactor;
		$this->threshold = (int)($capacity * $loadFactor);
		$this->entries = new Arrays($capacity);        
    }

	/**
     * The keyIterator method, acquires an instance of the KeyIterator object of this HashMap.
     * @access public
     * @return KeyIterator
     */			
	public function keyIterator(){
        return new KeyIterator($this);	
    }

	/**
     * The keySet method, returns a Set of keys contained in this HashMap.
     * @access public
     * @return KeySet
     */		
	public function keySet(){
        $keySet = ($this->keySet == NULL)?new KeySet($this):$this->keySet;
        return $keySet;       
    }	

	/**
     * The loadFactor method, obtains the load factor of this HashMap.
     * @access public
     * @return Float
     */		
	public function loadFactor(){
	    return $this->loadFactor;
	}	
	
	/**
     * The put method, associates a specific value with the specific key in this HashMap.
     * @param Objective  $key
	 * @param Objective  $value
     * @access public
     * @return Objective
     */		
	public function put(Objective $key = NULL, Objective $value = NULL){
 	    if($key == NULL) return $this->putNull($value);  
 	    $hash = $this->hash($key->hashCode());
		$index = $this->indexFor($hash, $this->entries->length());
		for($entry = $this->entries[$index]; $entry != NULL; $entry = $entry->getNext()){
		    $object = $entry->getKey();
            if($entry->getHash() == $hash and ($object == $key or $key->equals($object))){
                $oldValue = $entry->getValue();
				$entry->setValue($value);
				$entry->recordAccess($this);
				return $oldValue;
            }			
		}
		$this->addEntry($hash, $key, $value, $index);
		return NULL;       		
	}

 	/**
     * The putAll method, copies all of the mappings from a specific map to this HashMap.
	 * @param Mappable  $map
     * @access public
     * @return Void
     */	
    public function putAll(Mappable $map){
	    $size = $map->size();
        if($size == 0) return;

        if($size > $this->threshold){
            $targetCapacity = (int)($size/$this->loadFactor + 1);
			$newCapacity = $this->entries->length();
			while($newCapacity < $targetCapacity) $newCapacity = $newCapacity << 1;
			if($newCapacity > $this->entries->length()) $this->resize($newCapacity);
        }

		$iterator = $map->iterator();
        while($iterator->hasNext()){
            $entry = $iterator->next();
			$this->put($entry->getKey(), $entry->getValue());
        }		
    }		
	
 	/**
     * The putNull method, associates a specific value with a null key in this HashMap.
	 * @param Objective  $value
     * @access private
     * @return Objective
     */	
    private function putNull(Objective $value = NULL){
	    for($entry = $this->entries[0]; $entry != NULL; $entry = $entry->getNext()){
            if($entry->getKey() == NULL){
			    $oldValue = $entry->getValue();
				$entry->setValue($value);
				$entry->recordAccess($this);
				return $oldValue;
			}
        }
		$this->addEntry(0, NULL, $value, 0);
        return NULL;		
    }	

 	/**
     * The remove method, removes a specific key-value pair from the HashMap.
     * @param Objective  $key
     * @access public
     * @return Objective
     */		
	public function remove(Objective $key = NULL){
        $entry = $this->removeKey($key);
        return(($entry == NULL)?NULL:$entry->getValue());		
	}

 	/**
     * The removeKey method, removes and returns an entry given a specific key in the HashMap.
	 * This is a final method, and thus cannot be overriden by child class.
     * @param Objective  $key
     * @access public
     * @return Entry
	 * @final
     */		
	public final function removeKey(Objective $key = NULL){
        $hash = ($key == NULL)?0:$this->hash($key->hashCode());
		$index = $this->indexFor($hash, $this->entries->length());	
        $prev = $this->entries[$index];
        $entry = $prev;

        while($entry != NULL){
            $next = $entry->getNext();
			$object = $entry->getKey();
			if($entry->getHash() == $hash and ($object == $key or ($key != NULL and $key->equals($object)))){
			    $this->size--;
				if($prev == $entry) $this->entry[$index] = $next;
				else $prev->setNext($next);
				$entry->recordRemoval($this);
				return $entry;
			}
			$prev = $entry;
			$entry = $next;
        }		
        return $entry;		
	}		

 	/**
     * The removeMapping method, it is a special version for removal of EntrySet.
	 * This is a final method, and thus cannot be overriden by child class.
     * @param Entry  $object
     * @access public
     * @return Entry
	 * @final
     */		
	public final function removeMapping(Entry $object = NULL){
	    if($object == NULL) return NULL;
		$key = $object->getKey();		
        $hash = ($key == NULL)?0:$this->hash($key->hashCode());
		$index = $this->indexFor($hash, $this->entries->length());	
        $prev = $this->entries[$index];
        $entry = $prev;

        while($entry != NULL){
            $next = $entry->getNext();
			if($entry->getHash() == $hash and $entry->equals($object)){
			    $this->size--;
				if($prev == $entry) $this->entries[$index] = $next;
				else $prev->setNext($next);
				$entry->recordRemoval($this);
				return $entry;
			}
			$prev = $entry;
			$entry = $next;
        }		
        return $entry;		
	}
	
	/**
     * The resize method, resizes the EntrySet that holds records of this HashMap.
	 * @param Int  $newCapacity
     * @access public
     * @return Void
     */			
	public function resize($newCapacity){    
        $newEntries = new Arrays($newCapacity);
        $this->transfer($newEntries);
        $this->entries = $newEntries;
        $this->threshold = (int)($newCapacity * $this->loadFactor);		
	}		
	
	/**
     * The size method, returns the current size of this HashMap.
     * @access public
     * @return Int
     */			
	public function size(){
	    return $this->size;
	}		

	/**
     * The transfer method, transfers all old entries to new entries.
	 * @param Arrays  $newEntries
     * @access public
     * @return Void
     */			
	public function transfer(Arrays $newEntries){
	    $oldEntries = $this->entries;
		$newCapacity = $newEntries->length();
		for($i = 0; $i < $oldEntries->length(); $i++){
		    $entry = $oldEntries[$i];
            if($entry != NULL){
                $oldEntries[$i] = NULL;
                do{
                    $next = $entry->getNext();
					$index = $this->indexFor($entry->getHash(), $newCapacity);
					$entry->setNext($newEntries[$index]);
					$newEntries[$index] = $entry;
					$entry = $next;				
                }while($entry != NULL);				
            }			
		}
	}		

	/**
     * The valueIterator method, acquires an instance of the ValueIterator object of this HashMap.
     * @access public
     * @return ValueIterator
     */			
	public function valueIterator(){
        return new ValueIterator($this);	
    }
	
	/**
     * The valueSet method, returns a Set of values contained in this HashMap.
     * @access public
     * @return ValueSet
     */		
	public function valueSet(){
        $valueSet = ($this->valueSet == NULL)?new ValueSet($this):$this->valueSet;
		return $valueSet;
    }		
}
?>