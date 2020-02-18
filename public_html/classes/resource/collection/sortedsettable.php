<?php

namespace Resource\Collection;

use Resource\Native\Objective;

/**
 * The SortedSettable Interface, extending from the Settable interface.
 * It defines a standard interface for a linked set that provides ordering on its elements.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

interface SortedSettable extends Settable
{
    
    /**
     * The comparator method, returns the comparator object used to order the elements in this Set.
     * @access public
     * @return Comparative
     */
    public function comparator();

    /**
     * The first method, obtains the first object stored in this Set.
     * @access public
     * @return Objective
     */
    public function first();
    
    /**
     * The headSet method, acquires a portion of the Set ranging from the first element to the supplied element.
     * @param Objective  $toElement
     * @access public
     * @return SortedSettable
     */
    public function headSet(Objective $toElement);

    /**
     * The last method, obtains the last object stored in this Set.
     * @access public
     * @return Objective
     */
    public function last();

    /**
     * The tailSet method, acquires a portion of the Set ranging from the supplied element to the last element.
     * @param Objective  $fromElement
     * @access public
     * @return SortedSettable
     */
    public function tailSet(Objective $fromElement);
}
