<?php

/**
 * The GroupTableHelper Class, extends from TableHelper class.
 * It is a specialized helper class to manipulate group related tables.
 * @category Resource
 * @package Helper
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class GroupTableHelper extends TableHelper
{

    /**
     * Constructor of GroupTableHelper Class, it simply calls parent constructor.
     * @access public
     * @return Void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * The getPermissionImage method, wraps up the table cell with a permission image.
     * @param String  $param
     * @access protected
     * @return Image
     */
    protected function getPermissionImage($param)
    {
        if ($param == "yes") {
            return $this->getYesImage();
        } else {
            return $this->getNoImage();
        }
    }
    
    /**
     * The getDeleteLink method, wraps up the table cell with a delete image/link.
     * It overrides the TableHelper's getDeleteLink() method.
     * @param String  $param
     * @access protected
     * @return Link
     */
    protected function getDeleteLink($param)
    {
        if ($param == 1 or $param == 3) {
            return "N/A";
        }
        return parent::getDeleteLink($param);
    }

    /**
     * Magic method __toString for GroupTableHelper class, it reveals that the object is a group table helper.
     * @access public
     * @return String
     */
    public function __toString()
    {
        return "This is an instance of Mysidia GroupTableHelper class.";
    }
}
