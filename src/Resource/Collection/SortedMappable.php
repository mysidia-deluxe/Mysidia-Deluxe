<?php

namespace Resource\Collection;
use Resource\Native\Objective;

/**
 * The SortedMappable Interface, extending from the Mappable interface.
 * It defines a standard interface for a linked Map that provides ordering on its keys.
 * @category Resource
 * @package Collection
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

interface SortedMappable extends Mappable{
	
	/**
     * The comparator method, returns the comparator object used to order the keys in this Map.
     * @access public
     * @return Comparative
     */		
	public function comparator();	

	/**
     * The firstKey method, obtains the first key object stored in this Map.
     * @access public
     * @return Objective
     */		
	public function firstKey();		
	
	/**
     * The headMap method, acquires a portion of the Map ranging from the first key to the supplied key.
	 * @param Objective  $toKey
     * @access public
     * @return SortedMappable
     */		
	public function headMap(Objective $toKey);		

	/**
     * The lastKey method, obtains the last key object stored in this Map.
     * @access public
     * @return Objective
     */		
	public function lastKey();		
	
	/**
     * The subMap method, acquires a portion of the Map ranging from the supplied two keys.
	 * @param Objective  $fromKey
	 * @param Objective  $toKey
     * @access public
     * @return SortedMappable
     */		
	public function subMap(Objective $fromKey, Objective $toKey);	

	/**
     * The tailMap method, acquires a portion of the Map ranging from the supplied key to the last key.
	 * @param Objective  $fromKey
     * @access public
     * @return SortedMappable
     */		
	public function tailMap(Objective $fromKey);		
	
}   
?>