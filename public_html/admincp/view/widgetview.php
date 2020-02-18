<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedHashMap;

class ACPWidgetView extends View
{
    public function index()
    {
        parent::index();
        $mysidia = Registry::get("mysidia");
        $stmt = $this->getField("stmt")->get();
        $document = $this->document;

        $fields = new LinkedHashMap;
        $fields->put(new Mystring("wid"), null);
        $fields->put(new Mystring("name"), null);
        $fields->put(new Mystring("controller"), null);
        $fields->put(new Mystring("order"), null);
        $fields->put(new Mystring("status"), null);
        $fields->put(new Mystring("wid::edit"), new Mystring("getEditLink"));
        $fields->put(new Mystring("wid::delete"), new Mystring("getDeleteLink"));
        
        $widgetTable = new TableBuilder("widgets");
        $widgetTable->setAlign(new Align("center", "middle"));
        $widgetTable->buildHeaders("ID", "Widget", "Controller", "Order", "Status", "Edit", "Delete");
        $widgetTable->setHelper(new TableHelper);
        $widgetTable->buildTable($stmt, $fields);
        $document->add($widgetTable);
    }
    
    public function add()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        if ($mysidia->input->post("submit")) {
            $document->setTitle($this->lang->added_title);
            $document->addLangvar($this->lang->added);
            return;
        }
        
        $document->setTitle($this->lang->add_title);
        $document->addLangvar($this->lang->add);
        $widgetForm = new FormBuilder("addform", "add", "post");
        $widgetForm->buildComment("Widget Name: ", false)->buildTextField("name")
                   ->buildComment("Controller Level: ", false)->buildTextField("controllers")
                   ->buildComment("<b>You may enter 'main', 'admincp' or leave the above field blank.</b>")
                   ->buildComment("Widget Order: ", false)->buildTextField("order", 0)
                   ->buildComment("Widget Status:(enabled or disabled) ", false)->buildTextField("status", "enabled")
                   ->buildButton("Create Widget", "submit", "submit");
        $document->add($widgetForm);
    }
    
    public function edit()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
      
        if (!$mysidia->input->get("wid")) {
            // A widget has yet been selected, return to the index page.
            $this->index();
            return;
        } elseif ($mysidia->input->post("submit")) {
            $document->setTitle($this->lang->edited_title);
            $document->addLangvar($this->lang->edited);
            return;
        } else {
            $document->setTitle($this->lang->edit_title);
            $document->addLangvar($this->lang->edit);
            $widget = $this->getField("widget")->get();
            $widgetForm = new FormBuilder("editform", $mysidia->input->get("wid"), "post");
            $widgetForm->buildComment("Widget Name: ", false)->buildTextField("name", $widget->name)
                       ->buildComment("Controller Level: ", false)->buildTextField("controllers", $widget->controller)
                       ->buildComment("<b>You may enter 'main', 'admincp' or leave the above field blank.</b>")
                       ->buildComment("Widget Order: ", false)->buildTextField("order", $widget->order)
                       ->buildComment("Widget Status:(enabled or disabled) ", false)->buildTextField("status", $widget->status)
                       ->buildButton("Change Widget", "submit", "submit");
            $document->add($widgetForm);
        }
    }
    
    public function delete()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        if (!$mysidia->input->get("wid")) {
            // A widget has yet been selected, return to the index page.
            $this->index();
            return;
        }
        $document->setTitle($this->lang->delete_title);
        $document->addLangvar($this->lang->delete);
    }
}
