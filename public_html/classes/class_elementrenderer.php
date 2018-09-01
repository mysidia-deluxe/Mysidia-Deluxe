<?php

/**
 * The ElementRenderer Class, extends from abstract GUIRenderer class.
 * It is responsible for rendering GUI CSS Elements.
 * @category Resource
 * @package GUI
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class ElementRenderer extends GUIRenderer
{
    
    /**
     * Constructor of AccessoryRenderer Class, assigns the text reference and determines its tag.
     * @access public
     * @return Void
     */
    public function __construct(GUIElement $element)
    {
        $this->component = $element;
        if ($element instanceof Font) {
            $this->tag = "span";
        } elseif ($element instanceof Color) {
            $this->tag = null;
        } else {
            $this->tag = strtolower(get_class($element));
        }
    }
    
    /**
     * The renderHorizontal method, renders the horizontal property of an align Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderHorizontal()
    {
        if ($this->component->getHorizontal()) {
            $this->setRender(" text-align:{$this->component->getHorizontal()};");
        }
        return $this;
    }
    
    /**
     * The renderVertical method, renders the vertical property of an align Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderVertical()
    {
        if ($this->component->getVertical()) {
            $this->setRender(" vertical-align:{$this->component->getVertical()};");
        }
        return $this;
    }
    
    /**
     * The renderMargin method, renders the EUIElement object as a margin.
     * @access public
     * @return ElementRenderer
     */
    public function renderMargin()
    {
        $this->setRender(" margin");
        if ($this->component->getDirection()) {
            $this->setRender("-");
            $this->renderDirection();
        } else {
            $this->setRender(":");
        }
        return $this;
    }
    
    /**
     * The renderPadding method, renders the GUIElement object as a padding.
     * @access public
     * @return ElementRenderer
     */
    public function renderPadding()
    {
        $this->setRender(" padding");
        if ($this->component->getDirection()) {
            $this->setRender("-");
            $this->renderDirection();
        } else {
            $this->setRender(":");
        }
        return $this;
    }
    
    /**
     * The renderBorder method, renders the GUIElement object as a border.
     * @access public
     * @return ElementRenderer
     */
    public function renderBorder()
    {
        if ($this->component->getColor()) {
            $this->setRender(" border-{$this->component->getDirection()}-");
            $this->renderColor();
        }
        if ($this->component->getStyle()) {
            $this->setRender(" border-{$this->component->getDirection()}-style:{$this->component->getStyle()};");
        }
        if ($this->component->getWidth()) {
            $this->setRender(" border-{$this->component->getDirection()}-width:{$this->component->getWidth()};");
        }
        return $this;
    }
    
    /**
     * The renderBorders method, renders the GUIElement object as borders.
     * @access public
     * @return ElementRenderer
     */
    public function renderBorders()
    {
        if ($this->component->getColor()) {
            $this->setRender(" border-");
            $this->renderColor();
        }
        if ($this->component->getStyle()) {
            $this->setRender(" border-style:{$this->component->getStyle()};");
        }
        if ($this->component->getWidth()) {
            $this->setRender(" border-width:{$this->component->getWidth()};");
        }
        return $this;
    }
    
    /**
     * The renderDirection method, renders the direction property of a GUIElement Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderDirection()
    {
        $this->setRender("{$this->component->getDirection()}:");
        return $this;
    }
    
    /**
     * The renderWidth method, renders the width property of a dimension/spacing Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderWidth()
    {
        if ($this->component->getWidth()) {
            if ($this->component instanceof Dimension) {
                $this->setRender(" width:{$this->component->getWidth()};");
            } else {
                $this->setRender(" {$this->component->getWidth()};");
            }
        }
        return $this;
    }

    /**
     * The renderHeight method, renders the height property of a dimension Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderHeight()
    {
        if ($this->component->getHeight()) {
            $this->setRender(" height:{$this->component->getHeight()};");
        }
        return $this;
    }
    
    /**
     * The renderImage method, renders the image property of a GUIElement Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderImage()
    {
        $image = $this->component->getImage();
        if ($image instanceof Image) {
            if ($this->component instanceof Background) {
                $this->setRender(" background-image:");
            } elseif ($this->component instanceof Borders) {
                $this->setRender(" border-image:");
                if ($image->getWidth()) {
                    $this->setRender(" {$image->getWidth()} {$image->getHeight()}");
                }
            }
            $this->setRender(" url({$image->getSrc()->getURL()})");
            $this->setRender(";");
        }
        return $this;
    }
    
    /**
     * The renderRadius method, renders the radius property of a border Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderRadius()
    {
        if ($this->component->getRadius()) {
            $this->setRender(" border-radius:{$this->component->getRadius()};");
        }
        return $this;
    }

    /**
     * The renderSize method, renders the size property of a font Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderSize()
    {
        if ($this->component->getSize()) {
            $this->setRender(" font-size: {$this->component->getSize()}px;");
        }
        return $this;
    }

    /**
     * The renderFamily method, renders the family property of a font Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderFamily()
    {
        if ($this->component->getFamily()) {
            $this->setRender(" font-family: {$this->component->getFamily()};");
        }
        return $this;
    }
    
    /**
     * The renderVariant method, renders the variant property of a font Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderVariant()
    {
        if ($this->component->getVariant()) {
            $this->setRender(" font-variant: {$this->component->getVariant()};");
        }
        return $this;
    }
    
    /**
     * The renderWeight method, renders the weight property of a font Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderWeight()
    {
        if ($this->component->getWeight()) {
            $this->setRender(" font-weight: {$this->component->getWeight()};");
        }
        return $this;
    }
    
    /**
     * The getColorAttribute method, retrieves the color attribute to its caller method.
     * @param Color  $color
     * @access protected
     * @return String
     */
    protected function getColorAttribute(Color $color)
    {
        switch ($color->getFormat("")) {
            case "rgb":
                $attribute = "rgb({$color->getRed()},{$color->getGreen()},{$color->getBlue()})";
                break;
            case "code":
                $attribute = $color->getCode();
                break;
            case "name":
                $attribute = $color->getName();
                break;
            default:
                throw GUIException("THhe specified color rendering format is invalid.");
        }
        return $attribute;
    }
        
    /**
     * The renderForeground method, renders the foreground color property of a GUI Component.
     * @access public
     * @return ElementRenderer
     */
    public function renderForeground()
    {
        $foreground = $this->component;
        $attribute = $this->getColorAttribute($foreground);
        $this->setRender(" color:{$attribute};");
        return $this->render;
    }

    /**
     * The renderAttachment method, renders the attachment property of a Background Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderAttachment()
    {
        $this->setRender(" background-attachment:{$this->component->getAttachment()};");
        return $this;
    }
    
    /**
     * The renderColor method, renders the background color of a GUIElement.
     * @access public
     * @return ElementRenderer
     */
    public function renderColor()
    {
        $color = $this->component->getColor();
        $attribute = $this->getColorAttribute($color);
        $this->setRender(" background-color:{$attribute};");
        return $this->render;
    }

    /**
     * The renderPosition method, renders the position property of a Background Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderPosition()
    {
        $this->setRender(" background-position:{$this->component->getPosition()};");
        return $this;
    }
    
    /**
     * The renderRepeat method, renders the repeat property of a Background Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderRepeat()
    {
        $this->setRender(" background-repeat:{$this->component->getRepeat()};");
        return $this;
    }
    
    /**
     * The renderClip method, renders the clip property of a Background Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderClip()
    {
        $this->setRender(" background-clip:{$this->component->getClip()};");
        return $this;
    }
    
    /**
     * The renderOrigin method, renders the origin property of a Background Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderOrigin()
    {
        $this->setRender(" background-origin:{$this->component->getOrigin()};");
        return $this;
    }
        
    /**
     * The renderStyle method, renders the style property of a GUIElement.
     * @access public
     * @return ElementRenderer
     */
    public function renderStyle()
    {
        if ($this->component->getStyle()) {
            $this->setRender(" style: {$this->component->getStyle()};");
        }
        return $this;
    }
    
    /**
     * The renderCount method, renders the count property of a MCol Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderCount()
    {
        $this->setRender(" {$this->component->getBrowser()}column-count:{$this->component->getCount()};");
        return $this;
    }
    
    /**
     * The renderGap method, renders the gap property of a MCol Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderGap()
    {
        $this->setRender(" {$this->component->getBrowser()}column-gap:{$this->component->getGap()};");
        return $this;
    }
    
    /**
     * The renderRule method, renders the rule property of a MCol Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderRule()
    {
        $this->setRender(" {$this->component->getBrowser()}column-rule:{$this->component->getRule()};");
        return $this;
    }
    
    /**
     * The renderSpan method, renders the span property of a MCol Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderSpan()
    {
        $this->setRender(" {$this->component->getBrowser()}column-span:{$this->component->getSpan()};");
        return $this;
    }
    
    /**
     * The renderColWidth method, renders the colWidth property of a MCol Object.
     * @access public
     * @return ElementRenderer
     */
    public function renderColWidth()
    {
        $this->setRender(" {$this->component->getBrowser()}column-width:{$this->component->getColWidth()};");
        return $this;
    }
}
