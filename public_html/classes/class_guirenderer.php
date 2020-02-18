<?php

use Resource\Native\Object;

/**
 * The Abstract GuiRenderer Class, extends from abstract object class.
 * It is parent to all Mysidia GUI Renderer classes, but cannot be instantiated itself.
 * @category Resource
 * @package GUI
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 * @abstract
 *
 */
 
abstract class GUIRenderer extends Object implements Rendering
{

    /**
     * The tag property, stores the tag used in our rendering process.
     * @access protected
     * @var String
    */
    protected $tag;

    /**
     * The component property, stores a reference to the component to be rendered.
     * @access protected
     * @var GUIComponent
    */
    protected $component;
    
    /**
     * The render property, holds the result for current rendering.
     * @access protected
     * @var String
    */
    protected $render = "";
    
    /**
     * The status property, holds the status for current rendering.
     * @access protected
     * @var String
    */
    protected $status = "ready";
    
    /**
     * Constructor of GUIRenderer Class, assigns the component reference.
     * @access public
     * @return Void
     */
    public function __construct(GUIComponent $component)
    {
        $this->component = $component;
    }
    
    /**
     * The renderName method, renders the name of a GUI component.
     * @access public
     * @return GUIRenderer
     */
    public function renderID()
    {
        $this->setRender(" id='{$this->component->getID()}'");
        return $this;
    }
    
    /**
     * The renderClass method, renders the class of a GUI component.
     * @access public
     * @return GUIRenderer
     */
    public function renderClass()
    {
        $this->setRender(" class='{$this->component->getClass()}'");
        return $this;
    }
    
    /**
     * The renderText method, renders the text of a GUI Component.
     * @access public
     * @return GUIRenderer
     */
    public function renderText()
    {
        if (!is_null($this->component->getText())) {
            $this->setRender(">{$this->component->getText()}");
        } else {
            $this->setRender(">");
        }
        return $this;
    }
    
    /**
     * The renderName method, renders the name of a GUI component.
     * @access public
     * @return GUIRenderer
     */
    public function renderName()
    {
        $this->setRender(" name='{$this->component->getName()}'");
        return $this;
    }
    
    /**
     * The renderType method, renders the type of a GUI component.
     * @access public
     * @return ButtonRenderer
     */
    public function renderType()
    {
        $this->setRender(" type='{$this->component->getType()}'");
        return $this;
    }
    
    /**
     * The renderAutofocus method, renders the autofocus of a GUI component.
     * @access public
     * @return GUIRenderer
     */
    public function renderAutofocus()
    {
        $this->setRender(" autofocus='autofocus'");
        return $this;
    }
    
    /**
     * The renderDisabled method, renders the disabled of a GUI component.
     * @access public
     * @return GUIRenderer
     */
    public function renderDisabled()
    {
        $this->setRender(" disabled='disabled'");
        return $this;
    }
    
    /**
     * The renderTarget method, renders the target property of an Link or Form Object.
     * @access public
     * @return GUIRenderer
     */
    public function renderTarget()
    {
        $this->setRender(" target='_{$this->component->getTarget()}'");
        return $this;
    }
    
    /**
     * The renderLineBreak method, renders the linebreak of a GUI component.
     * @access public
     * @return GUIRenderer
     */
    public function renderLineBreak()
    {
        $this->setRender("<br>");
        return $this;
    }
    
    /**
     * The renderThematicBreak method, renders the thematicbreak of a GUI component.
     * @access public
     * @return GUIRenderer
     */
    public function renderThematicBreak()
    {
        $this->setRender("<hr>");
        return $this;
    }

    /**
     * The renderAttributes method, renders the attributes of a GUI component.
     * @access public
     * @return GUIRenderer
     */
    public function renderAttributes()
    {
        $iterator = $this->component->getAttributes()->iterator();
        while ($iterator->hasNext()) {
            $method = "render{$iterator->next()}";
            $this->$method();
        }
        return $this;
    }

    /**
     * The renderComponents, renders each components inside a GUIContainer.
     * @access public
     * @return GUIRenderer
     */
    public function renderComponents()
    {
        $iterator = $this->component->components()->iterator();
        while ($iterator->hasNext()) {
            $component = $iterator->next();
            $this->setRender($component->render());
            if ($component->isLineBreak()) {
                $this->renderLineBreak();
            }
            if ($this->thematicBreak) {
                $this->renderThematicBreak();
            }
        }
    }
    
    /**
     * The renderCSS method, renders the css of a GUI component.
     * Several css properties are only available for GUI Containers, thus a shortcut is taken.
     * @access public
     * @return GUIRenderer
     */
    public function renderCSS()
    {
        $this->setRender(" style='");
        $css = $this->component->getCSS();
        $iterator = $css->iterator();
        while ($iterator->hasNext()) {
            $method = "get{$iterator->next()}";
            $this->setRender($this->component->$method()->render());
        }
        $this->setRender("'");
        return $this;
    }
    
    /**
     * The getRender method, return the result of rendering.
     * @access public
     * @return String
     */
    public function getRender()
    {
        return $this->render;
    }
    
    /**
     * The setRender method, inserts a string to the rendered content.
     * @param String  $render
     * @access public
     * @return Void
     */
    public function setRender($render = "")
    {
        $this->render .= $render;
    }
    
    /**
     * The getStatus method, return the current status of rendering.
     * @access public
     * @return String
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * The start method for GUIRenderer class, initialize the rendering process.
     * @access public
     * @return GUIRenderer
     */
    public function start()
    {
        if ($this->tag) {
            $this->setRender("\n<{$this->tag}");
        }
        $this->status = "started";
        return $this;
    }
    
    /**
     * The pause method for GUIRenderer class, pauses the rendering process.
     * It is useful for container type objects that needs to process components rendering.
     * @access public
     * @return String
     */
    public function pause()
    {
        if ($this->tag) {
            $this->setRender(">\n");
        }
        return $this;
    }
    
    /**
     * The end method for GUIRenderer class, ends the rendering process.
     * @access public
     * @return Void
     */
    public function end()
    {
        if ($this->tag) {
            $this->setRender("\n</{$this->tag}>");
        }
        $this->status = "ended";
    }
}
