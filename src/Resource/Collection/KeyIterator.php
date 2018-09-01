<?php

namespace Resource\Collection;

/**
 * The KeyIterator Class, extending from the abstract HashMapIterator Class.
 * It defines a standard key iterator for HashMap, subclasses of HashMap may have own implementations.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class KeyIterator extends HashMapIterator
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
