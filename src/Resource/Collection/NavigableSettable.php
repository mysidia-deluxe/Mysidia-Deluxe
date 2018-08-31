<?php

namespace Resource\Collection;
use Resource\Native\Objective;

/**
 * The NavigableSettable Interface, extending from the SortedSettable interface.
 * It defines an extended sorted set interface with navigation methods.
 * @category Resource
 * @package Collection
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

interface NavigableSettable extends SortedSettable{

	/**
     * The ceiling method, obtains the least element in this set greater than or equal to the given object.
	 * @param Objective  $object
     * @access public
     * @return Objective
     */		
	public function ceiling(Objective $object);

	/**
     * The descendingIterator method, acquires an instance of DescendingIterator object of this navigable set.
	 * This method returns an iterator with objects in reverse order as the set.
     * @access public
     * @return DescendingSetIterator
     */		
	public function descendingIterator();
		
	/**
     * The descendingSet method, returns a set with elements in reverse order as this set.
     * @access public
     * @return NavigableSettable
     */		
	public function descendingSet();		
	
	/**
     * The floor method, obtains the greatest element in this set less than or equal to the given object.
	 * @param Objective  $object
     * @access public
     * @return Objective
     */		
	public function floor(Objective $object);	

	/**
     * The headSets method, acquires a portion of the Set ranging from the first element to the supplied element.
	 * If a boolean TRUE value is supplied, the returned set will contain the supplied element at its tail.
	 * @param Objective  $toElement
	 * @param Boolean  $inclusive
     * @access public
     * @return SortedSettable
     */		
	public function headSets(Objective $toElement, $inclusive);		
	
	/**
     * The higher method, obtains the least element in this set strictly greater than the given object.
	 * @param Objective  $object
     * @access public
     * @return Objective
     */		
	public function higher(Objective $object);		

	/**
     * The lower method, obtains the greatest element in this set strictly less than the given object.
	 * @param Objective  $object
     * @access public
     * @return Objective
     */		
	public function lower(Objective $object);	
		
	/**
     * The pollFirst method, retrieves and removes the first/lowest element in the set.
     * @access public
     * @return Objective
     */		
	public function pollFirst();	

	/**
     * The pollLast method, retrieves and removes the last/greatest element in the set.
     * @access public
     * @return Objective
     */		
	public function pollLast();

	/**
     * The subSets method, acquires a portion of the Set ranging from the supplied two elements.
	 * If boolean value TRUE is supplied for $inclusive, the return set will contain $fromElement and/or $toElement.
	 * @param Objective  $fromElement
	 * @param Boolean  $fromInclusive
	 * @param Objective  $toElement
	 * @param Boolean  $toInclusive
     * @access public
     * @return Settable
     */		
	public function subSets(Objective $fromElement, $fromInclusive, Objective $toElement, $toInclusive);
	
	/**
     * The tailSets method, acquires a portion of the Set ranging from the supplied element to the last element.
	 * If a boolean TRUE value is supplied for $inclusive, the returned set will contain the supplied element at its head.
	 * @param Objective  $fromElement
	 * @param Boolean  $inclusive
     * @access public
     * @return SortedSettable
     */		
	public function tailSets(Objective $fromElement, $inclusive);	
	
}   
?>