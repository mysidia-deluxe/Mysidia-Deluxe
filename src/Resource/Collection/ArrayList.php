<?php

namespace Resource\Collection;
use Resource\Native\Objective;
use Resource\Native\Arrays;
use Resource\Exception\IllegalArgumentException;

/**
 * The ArrayList Class, extending from abstract List class.
 * It defines a standard class to handle ArrayList type collections, similar to Java's ArrayList.
 * @category Resource
 * @package Collection
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */
 
class ArrayList extends Lists{

	/**
	 * serialID constant, it serves as identifier of the object being ArrayList.
     */
    const SERIALID = "8683452581122892189L";
	
    /**
	 * The array property, it stores the data passed to this ArrayList.
	 * @access private
	 * @var Arrays
     */
    private $array;
	
    /**
	 * The size property, it specifies the current size of the ArrayList.
	 * @access private
	 * @var Int
     */	
    private $size = 0;

	/**
     * Constructor of ArrayList Class, it initializes the ArrayList given its size or another Collection Object.    
     * @param Int|Collective  $param
     * @access public
     * @return Void
     */	
	public function __construct($param = 10){
	    parent::__construct();
		if(is_int($param)) $this->array = new Arrays($param);
		elseif($param instanceof Collective){
            $this->size = $param->size();
		    $this->array = new Arrays($this->size);
            $iterator = $param->iterator();
            for($i = 0; $i < $this->size; $i++){
                $this->array[$i] = $iterator->next();
            }
		}
        else throw new IllegalArgumentException;
	}

 	/**
     * The add method, append an object to the end of the ArrayList.
     * @param Objective  $object 
     * @access public
     * @return Boolean
     */	
	public function add(Objective $object){
	    $this->ensureCapacity($this->size + 1);
	    $this->array[$this->size++] = $object;
        return TRUE;		
	}

 	/**
     * The addAll method, append a collection of objects to the end of the ArrayList.
     * @param Collective  $collection
     * @access public
     * @return Boolean
     */		
	public function addAll(Collective $collection){
		$iterator = $collection->iterator();
		$boolean = FALSE;
		while($iterator->hasNext()){
		    $boolean = $this->add($iterator->next());
		}
		return $boolean;
	}	

 	/**
     * The clear method, drops all objects currently stored in ArrayList.
     * @access public
     * @return Void
     */			
	public function clear(){
	    $this->size = 0;
		$this->array = new Arrays(10);
	}	

 	/**
     * The contains method, checks if a given object is already on the ArrayList.
     * @param Objective  $object 
     * @access public
     * @return Boolean
     */		
    public function contains(Objective $object){
        return ($this->indexOf($object) >= 0);
    }			
	
 	/**
     * The delete method, removes an Object at the supplied index and returns the deleted object.
     * @param Int  $index
     * @access public
     * @return Objective
     */		
	public function delete($index){
	    $this->rangeCheck($index); 
        $deleted = $this->array[$index];
        $newSize = $this->size - 1;
		
		for($i = $index; $i < $newSize; $i++){
		    $this->array[$i] = $this->array[$i+1];
            $this->array[$i+1] = NULL;
		}
        $this->size--;
        return $deleted;		
	}

 	/**
     * The ensureCapacity method, ensures the capacity of the internal array holding the List's data.
     * @param Int  $capacity
     * @access public
     * @return Void
     */		
	public function ensureCapacity($capacity){
	    if($capacity > $this->array->length()){
		    $default = $this->array->length() * 2;
		    if($capacity > $default) $this->grow($capacity);
		    else $this->grow($default);
        }			
	}

 	/**
     * The get method, acquires the object stored at a given index.
     * @param Int  $index
     * @access public
     * @return Objective
     */			
	public function get($index){
	    $this->rangeCheck($index);
		return $this->array[$index];
	}	

 	/**
     * The getArray method, retrieves an instance of the internal array object.
     * @access public
     * @return Arrays
     */			
	public function getArray(){
	    return $this->array;
	}

 	/**
     * The grow method, increases the size of the internal array so that it can hold more objects. 
     * @param Int  $capacity
     * @access private
     * @return Void
     */			
	private function grow($capacity){
	    $this->array->setSize($capacity);
	}

	/**
     * The indexOf method, returns the first index found for a given object.
     * @param Objective  $object 
     * @access public
     * @return Int
     */	
	public function indexOf(Objective $object){
	    if($object == NULL){
		    for($i = 0; $i < $this->size; $i++){
			    if($this->array[$i] == NULL) return $i;
		    }	
		}
        else{
		    for($i = 0; $i < $this->size; $i++){
			    if($object->equals($this->array[$i])) return $i;
		    }			
		}
		return -1;
	}

	/**
     * The insert method, inserts an object to any given index available in the ArrayList.
	 * @param Int  $index
     * @param Objective  $object 
     * @access public
     * @return Void
     */	
	public function insert($index, Objective $object){
	    $this->rangeCheck($index);
		$this->ensureCapacity($this->size + 1);
		$last = $this->size - 1;
		for($i = $last; $i >= $index; $i--){
		    $this->array[$i+1] = $this->array[$i];
		}
		$this->array[$index] = $object;
		$this->size++;
	} 

	/**
     * The insertAll method, inserts a collection of objects at a given index.
	 * @param Int  $index
     * @param Collective  $collection
     * @access public
     * @return Void
     */	
	public function insertAll($index, Collective $collection){
	    $this->rangeCheck($index);
		$this->ensureCapacity($this->size + $collection->size());
		$last = $this->size - 1;
		$offset = $collection->size();
		for($i = $last; $i >= $index; $i--){
            $this->array[$i+$offset] = $this->array[$i];    
        }		
       	
		$iterator = $collection->iterator();
		for($i = $index; $i < $index + $offset; $i++){
		    $this->array[$i] = $iterator->next();
		}
		$this->size += $offset;
	}

	/**
     * The lastIndexOf method, returns the last index found for a given object.
     * @param Objective  $object 
     * @access public
     * @return Int
     */		
	public function lastIndexOf(Objective $object){
	    if($object == NULL){
		    for($i = $this->size - 1; $i >= 0; $i--){
			    if($this->array[$i] == NULL) return $i;
		    }	
		}
        else{
		    for($i = $this->size - 1; $i >= 0; $i--){
			    if($object->equals($this->array[$i])) return $i;
		    }			
		}
		return -1;
	}		

	/**
     * The removeRange method, removes a collection of objects from a starting to ending index.
	 * @param Int  $fromIndex
     * @param Int  $toIndex 
     * @access public
     * @return Void
     */		
    public function removeRange($fromIndex, $toIndex){
        $this->rangeCheck($index);
        for($i = $fromIndex; $i < $toIndex; $i++){
		    $this->array[$i] = NULL;
		}
		
		$offset = $toIndex - $fromIndex;
		for($i = $fromIndex; $i< $this->size - $offset; $i++){
		    $this->array[$i] = $this->array[$i+$offset];
            $this->array[$i+$offset] = NULL;
		}
		$this->size -= $offset;
	}

	/**
     * The set method, updates a supplied index with a given object.
	 * @param Int  $index
     * @param Objective  $object 
     * @access public
     * @return Void
     */		
	public function set($index, Objective $object){
	    $this->rangeCheck($index);
        $element = $this->array[$index];
        $this->array[$index] = $object;
        return $element;	    
	}
	
	/**
     * The size method, returns the current size of this ArrayList.
     * @access public
     * @return Int
     */			
	public function size(){
	    return $this->size;
	}			
	
	/**
     * The toArray method, acquires the data stored in ArrayList in Array format.
     * @access public
     * @return Array
     */			
	public function toArray(){
	    $this->trimSize();
	    return $this->array->toArray();
	}	

	/**
     * The trimSize method, cuts down the internal array's size to the current ArrayList size.
     * @access public
     * @return Void
     */		
	public function trimSize(){
	    if($this->size < $this->array->length()) $this->array->setSize($this->size);
	}	
}
?>