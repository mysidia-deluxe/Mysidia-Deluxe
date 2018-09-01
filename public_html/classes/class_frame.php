<?php

use Resource\Native\Mystring;
use Resource\Collection\ArrayList;
use Resource\Collection\HashMap;

/**
 * The Frame Class, it is the top layor of all view components, including document, navlinks, sidebar and more.
 * A frame object is sent into the template file, its components can be displayed at any given locations.
 * @category Resource
 * @package Core
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 * @final
 *
 */

final class Frame extends Core implements Renderable
{

    /**
     * The controller property, it defines the front controller page the frame belongs to.
     * @access private
     * @var String
    */
    private $controller;

    /**
     * The header property, it stores the HTML header object with detailed information.
     * @access private
     * @var Header
    */
    private $header;
    
    /**
     * The document property, specifies the main document title and content.
     * It can be official contents, or admin-created custom pages.
     * @access private
     * @var Document
    */
    private $document;
    
    /**
     * The sitename property, holds a reference to the sitename.
     * @access private
     * @var String
    */
    private $sitename;
    
    /**
     * The menu property, stores the dropdown menu object.
     * @access private
     * @var Menu
    */
    private $menu;
    
    /**
     * The sidebar property, specifies the sidebar of this frame.
     * @access private
     * @var Sidebar
    */
    private $sidebar;
    
    /**
     * The footer property, determines the footer content of this frame.
     * @access private
     * @var Footer
    */
    private $footer;
    
    /**
     * The widgets property, defines a list of widgets not belonging to the above containers.
     * These custom widgets can be referenced in template file and manipulated by the admin.
     * @access private
     * @var ArrayList
    */
    private $widgets;
    
    /**
     * The renders property, stores a map of rendered GUI components ready to be sent to view.
     * @access private
     * @var HashMap
    */
    private $renders;
    
    /**
     * Constructor of Frame Class, it initializes basic frame properties.
     * @param String  $document
     * @access public
     * @return Void
     */
    public function __construct($document = "")
    {
        $this->getController();
        $this->getHeader();
        $this->getDocument($document);
        $this->getSitename();
        $this->getMenu();
        $this->getSidebar();
        $this->getFooter();
        $this->getWidgets();
    }

    /**
     * The getController method, getter method for property $controller.
     * @access public
     * @return String
     */
    public function getController()
    {
        if (!$this->controller) {
            if (strpos($_SERVER['REQUEST_URI'], "admincp") !== false) {
                $this->controller = "admincp";
            } else {
                $this->controller = "index";
            }
        }
        return $this->controller;
    }
    
    /**
     * The getHeader method, getter method for property $header.
     * @access public
     * @return Header
     */
    public function getHeader()
    {
        if (!$this->header) {
            $this->header = new Header;
        }
        return $this->header;
    }
 
    /**
     * The getDocument method, getter method for property $document.
     * The script determines if it is an official or custom document.
     * @access public
     * @return Document
     */
    public function getDocument($document = "")
    {
        if ($document) {
            $this->document = new CustomDocument($document);
        } elseif (!$this->document) {
            $this->document = new Document;
        }
        return $this->document;
    }
    
    /**
     * The getSitename method, getter method for property $sitename.
     * @access public
     * @return String
     */
    public function getSitename()
    {
        $mysidia = Registry::get("mysidia");
        if (!$this->sitename) {
            $this->sitename = $mysidia->settings->sitename;
        }
        return $this->sitename;
    }
    
    /**
     * The getMenu method, getter method for property $menu.
     * @access public
     * @return Menu
     */
    public function getMenu()
    {
        if (!$this->menu) {
            $this->menu = new Menu;
        }
        return $this->menu;
    }
    
    /**
     * The getSidebar method, getter method for property $sidebar.
     * @access public
     * @return Sidebar
     */
    public function getSidebar()
    {
        if (!$this->sidebar) {
            if ($this->controller == "admincp") {
                $this->sidebar = new AdminSidebar;
            } else {
                $this->sidebar = new Sidebar;
            }
        }
        return $this->sidebar;
    }
    
    /**
     * The getFooter method, getter method for property $footer.
     * @access public
     * @return Footer
     */
    public function getFooter()
    {
        if (!$this->footer) {
            $this->footer = new Footer;
        }
        return $this->footer;
    }
    
    /**
     * The getWidgets method, getter method for property $widgets.
     * This method will be updated in future.
     * @access public
     * @return ArrayList
     */
    public function getWidgets()
    {
        $mysidia = Registry::get("mysidia");
        $whereClause = "wid > 5 and status = 'enabled'";
        $whereClause .= ($this->controller == "admincp")?" and (controller = 'admincp' or controller = 'all')":" and (controller = 'main' or controller = 'all')";
        $stmt = $mysidia->db->select("widgets", array("wid", "name"), $whereClause);
        $size = $stmt->rowCount();
        if ($size == 0) {
            return null;
        } else {
            $this->widgets = new ArrayList($size);
        }
        while ($widget = $stmt->fetchObject()) {
            $this->widgets->add(new Widget($widget->wid, $widget->name));
        }
        return $this->widgets;
    }
    
    /**
     * The render method for Frame class, it renders all of its components.
     * @access public
     * @return HashMap
     */
    public function render()
    {
        $path = Registry::get("path");
        $this->renders = new HashMap;
        $this->renders->put(new Mystring("path"), new Mystring($path->getAbsolute()));
        $this->renders->put(new Mystring("frame"), $this);
        $this->renders->put(new Mystring("header"), $this->header);
        $this->renders->put(new Mystring("browser_title"), new Mystring($this->header->getBrowserTitle()));
        $this->renders->put(new Mystring("site_name"), new Mystring($this->sitename));
        $this->renders->put(new Mystring("document_title"), new Mystring($this->document->getTitle()));
        $this->renders->put(new Mystring("document_content"), $this->document);
        $this->renders->put(new Mystring("menu"), $this->menu);
        $this->renders->put(new Mystring("sidebar"), $this->sidebar);
        $this->renders->put(new Mystring("footer"), $this->footer);
        
        if ($this->widgets instanceof ArrayList) {
            $iterator = $this->widgets->iterator();
            while ($iterator->hasNext()) {
                $widget = $iterator->next();
                $this->renders->put(new Mystring($widget->getName()), $widget);
            }
        }
        return $this->renders;
    }
}
