<?php

namespace Resource\Collection;

use Resource\Native\Objective;

/**
 * The Settable Interface, extending from the Collective interface.
 * It defines a standard interface for Set type Collection objects.
 * @category Resource
 * @package Collection
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

interface Settable extends Collective
{

    /**
     * The subSet method, acquires a portion of the Set ranging from the supplied two elements.
     * @param Objective  $fromElement
     * @param Objective  $toElement
     * @access public
     * @return Settable
     */
    public function subSet(Objective $fromElement, Objective $toElement);
}
