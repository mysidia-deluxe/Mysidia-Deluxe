<?php

namespace Resource\Utility;
use Resource\Native\Objective;

/**
 * The Comparable Interface, it defines objects that can be compared with another.
 * It is a standard interface for objects that can be compared.
 * @category Resource
 * @package Utility
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */
 
interface Comparable{

	/**
     * The compareTo method, compares this object with another.
	 * @param Objective  $object
     * @access public
     * @return Int
     */
    public function compareTo(Objective $object);

}
?>