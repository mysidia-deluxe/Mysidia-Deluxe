<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedList;

class StatsView extends View
{
    public function index()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        $document->setTitle($this->lang->title);
        $document->addLangvar($this->lang->default.$this->lang->top10.$this->lang->top10_text);
        $document->add($this->getTable("top10", $this->getField("top10")));
        $document->addLangvar($this->lang->random.$this->lang->random_text);
        $document->add($this->getTable("rand5", $this->getField("rand5")));
    }

    private function getTable($name, LinkedList $list)
    {
        $table = new TableBuilder($name);
        $table->setAlign(new Align("center", "middle"));
        $table->buildHeaders("Adoptable Image", "Adoptable Name", "Adoptable Owner", "Total Clicks", "Current Level");
        $table->setHelper(new AdoptTableHelper);
        
        $iterator = $list->iterator();
        while ($iterator->hasNext()) {
            $adopt = $iterator->next();
            $cells = new LinkedList;
            $cells->add(new TCell($table->getHelper()->getLevelupLink($adopt)));
            $cells->add(new TCell($adopt->getName()));
            $cells->add(new TCell($table->getHelper()->getOwnerProfile($adopt->getOwner())));
            $cells->add(new Mystring($adopt->getTotalClicks()));
            $cells->add(new TCell($adopt->getCurrentLevel()));
            $table->buildRow($cells);
        }
        return $table;
    }
}
