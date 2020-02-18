<?php

namespace Resource\Collection;

/**
 * The SubListIterator Class, extending from the ListIterator Class.
 * It defines a standard Iterator for SubList, it will come in handy.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class SubListIterator extends ListIterator
{

    /**
     * The offset property, it determines the offset between fromIndex and toIndex
     * @access private
     * @var Int
     */
    private $offset;
    
    /**
     * The size property, it specifies the current size of the ArrayList.
     * @access private
     * @var Int
     */
    private $size;

    /**
     * Constructor of SubListIterator Class, it initializes the ListIterator with basic properties.
     * @param Int|Collective  $param
     * @access public
     * @return Void
     */
    public function __construct(Lists $list, $fromIndex, $toIndex)
    {
        $this->offset = $fromIndex;
        $this->size = $toIndex - $fromIndex;
        parent::__construct($fromIndex, $list);
    }

    /**
     * The hasNext method, checks if the iterator has not reached the end of its iteration yet.
     * @access public
     * @return Boolean
     */
    public function hasNext()
    {
        return ($this->nextIndex() < $this->size);
    }
    
    /**
     * The hasPrevious method, checks if the list iterator has objects before its current index.
     * @access public
     * @return Boolean
     */
    public function hasPrevious()
    {
        return ($this->previousIndex() >= 0);
    }
}
