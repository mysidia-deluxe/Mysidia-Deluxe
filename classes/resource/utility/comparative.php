<?php

namespace Resource\Utility;
use Resource\Native\Objective;

/**
 * The Comparative Interface, it defines special objects that can compare two other objects.
 * It basically serves as an interface for utility classes that can handle complex comparison algorithm.
 * @category Resource
 * @package Utility
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */
 
interface Comparative{

    /**
     * The compare method, compares two objects with each other with its internal algorithm.
     * @param Objective  $object
     * @param Objective  $object2	 
     * @access public
     * @return Int
     */
    public function compare(Objective $object, Objective $object2);

}
?>