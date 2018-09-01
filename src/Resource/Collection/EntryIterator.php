<?php

namespace Resource\Collection;

/**
 * The EntryIterator Class, extending from the abstract HashMapIterator Class.
 * It defines a standard entry iterator for HashMap, subclasses of HashMap may have own implementations.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */
 
class EntryIterator extends HashMapIterator
{
        
    /**
     * The next method, returns the next entry in iteration.
     * @access public
     * @return Entry
     */
    public function next()
    {
        return $this->nextEntry();
    }
    
    /**
     * The nextKey method, returns the next key in iteration.
     * @access public
     * @return Objective
     */
    public function nextKey()
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
