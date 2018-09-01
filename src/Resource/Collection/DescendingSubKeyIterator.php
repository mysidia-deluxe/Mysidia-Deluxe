<?php

namespace Resource\Collection;

/**
 * The DescendingSubKeyIterator Class, extending from the abstract SubMapIterator Class.
 * It defines a standard descending key iterator for SubMap, it traverses in reverse order.
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

final class DescendingSubKeyIterator extends SubMapIterator
{
        
    /**
     * The next method, returns the next key in iteration.
     * @access public
     * @return Objective
     */
    public function next()
    {
        return $this->prevEntry()->getKey();
    }
    
    /**
     * The nextValue method, returns the next value in iteration.
     * @access public
     * @return Objective
     */
    public function nextValue()
    {
        return $this->prevEntry()->getValue();
    }

    /**
     * The remove method, removes from the underlying value associated with the current key in iteration.
     * @access public
     * @return Void
     */
    public function remove()
    {
        $this->removeDescending();
    }
}
