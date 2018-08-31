<?php

namespace Resource\Collection;
use Resource\Native\Objective;

/**
 * The MapEntry Class, extending from the abstract Entry Class.
 * It has full implementation of a MapEntry, though it can still be further extended by child classes.
 * @category Resource
 * @package Collection
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class MapEntry extends Entry{

	/**
	 * serialID constant, it serves as identifier of the object being MapEntry.
     */
    const SERIALID = "-8499721149061103585L"; 

	/**
     * Constructor of MapEntry Class, it initializes an MapEntry with a key and a value.
     * @param Objective  $key
	 * @param Objective  $value
     * @access public
     * @return Void
     */	
	public function __construct(Objective $key = NULL, Objective $value = NULL){
	    parent::__construct($key, $value);
	}
	
	/**
     * The hashCode method, returns the hash code for this MapEntry.
	 * Note the hashCode for a MapEntry is an integer.
     * @access public
     * @return Int
     */		
	public function hashCode(){
	    $keyHash = ($this->key == NULL)?0:$this->key->hashCode();
		$valueHash = ($this->value == NULL)?0:$this->value->hashCode();
		return ($keyHash ^ $valueHash);
	}

 	/**
     * The initialize method, initializes properties of this MapEntry from another Entry.
     * @param Entry  $entry
     * @access public
     * @return Boolean
     */			
	public function initialize(Entry $entry){
	    $this->key = $entry->getKey();
		$this->value = $entry->getValue();
	    return TRUE;
	}
}
?>