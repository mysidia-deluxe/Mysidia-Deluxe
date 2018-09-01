<?php

use Resource\Native\Object;
use Resource\Native\Mystring;
use Resource\Collection\HashMap;

/**
 * The Dispatcher Class, it uses information from Router to generate resources.
 * It fills in the input class get property with useful information.
 * @category Resource
 * @package Utility
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo The dispatcher class will be revised once the input class is overhauled.
 */

final class Dispatcher extends Object
{

    /**
     * The router property, holds a reference to the Router Object.
     * @access private
     * @var Router
    */
    private $router;
    
    /**
     * The map property, stores all get variables that will be available in Input Object.
     * @access private
     * @var Map
    */
    private $map;
    
    /**
     * Constructor of Dispatcher Class, it assigns a reference if Router to its property.
     * @param Router  $router
     * @access public
     * @return Void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * The getRouter method, getter method for property $getRouter.
     * @access public
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * The dispatch method, it is where information from router is converted into resources.
     * @access public
     * @return Void
     */
    public function dispatch()
    {
        if ($this->map) {
            throw new Exception("Request already dispatched previously...");
        }
        $mysidia = Registry::get("mysidia");
        $this->map = new HashMap;
        
        $frontcontroller = $this->router->getFrontController();
        $this->map->put(new Mystring("frontcontroller"), new Mystring($mysidia->input->secure($frontcontroller)));
        
        $appcontroller = $this->router->getAppController();
        $this->map->put(new Mystring("appcontroller"), new Mystring($mysidia->input->secure($appcontroller)));
        
        $action = $this->router->getAction();
        $this->map->put(new Mystring("action"), new Mystring($mysidia->input->secure($action)));
        
        $params = $this->router->getParams();
        if ($params) {
            foreach ($params as $key => $param) {
                $this->map->put(new Mystring($key), new Mystring($mysidia->input->secure($param)));
            }
        }
        
        $input = new ReflectionClass("Input");
        $get = $input->getProperty("get");
        $get->setAccessible(true);
        $get->setValue($mysidia->input, $this->map);
        
        $action = $input->getProperty("action");
        $action->setAccessible(true);
        $action->setValue($mysidia->input, $this->map->get(new Mystring("action")));
        $mysidia->lang->load();
    }
}
