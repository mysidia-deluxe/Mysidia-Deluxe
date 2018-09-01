<?php

namespace Resource\Collection;

/**
 * The KeyTreeIterator Class, extending from the abstract TreeMapIterator Class.
 * It defines a standard key iterator for TreeMap, which will come in handy.
 * This is a final class, and thus no child class shall inherit from it.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 * @final
 *
 */

final class KeyTreeIterator extends TreeMapIterator
{
        
    /**
     * The next method, returns the next key in iteration.
     * @access public
     * @return Objective
     */
    public function next()
    {
        return $this->nextEntry()->getKey();
    }
    
    /**
     * The nextValue method, returns the next value in iteration.
     * @access public
     * @return Objective
     */
    public function nextValue()
    {
        return $this->nextEntry()->getValue();
    }
}
