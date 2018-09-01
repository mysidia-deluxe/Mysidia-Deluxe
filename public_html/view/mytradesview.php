<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedList;

class MytradesView extends View
{
    public function index()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        $document->setTitle($mysidia->user->username.$this->lang->title);
        $document->addLangvar($this->lang->default.$this->lang->warning);
        $stmt = $this->getField("stmt")->get();
                
        $tradeTable = new TableBuilder("tradetable", 700);
        $tradeTable->setAlign(new Align("center", "middle"));
        $tradeTable->buildHeaders("ID", "Sender", "Adopt Offered", "Adopt Wanted", "Item Offered", "Item Wanted", "Cash Offered", "Message", "Accept", "Decline");
        $tradeHelper = $this->getField("tradeHelper");
        $tradeHelper->setView($this);
        
        while ($tid = $stmt->fetchColumn()) {
            $trade = new TradeOffer($tid);
            $cells = new LinkedList;
            $cells->add(new TCell($tid));
            $cells->add(new TCell($trade->getSender()));
            $cells->add(new TCell($tradeHelper->getAdoptImages($trade->getAdoptOffered())));
            $cells->add(new TCell($tradeHelper->getAdoptImages($trade->getAdoptWanted())));
            $cells->add(new TCell($tradeHelper->getItemImages($trade->getItemOffered())));
            $cells->add(new TCell($tradeHelper->getItemImages($trade->getItemWanted())));
            $cells->add(new TCell($trade->getCashOffered()));
            $cells->add(new TCell($trade->getMessage()));
            $cells->add(new TCell(new Link("mytrades/accept/{$tid}", new Image("templates/icons/yes.gif"))));
            $cells->add(new TCell(new Link("mytrades/decline/{$tid}", new Image("templates/icons/delete.gif"))));
            $tradeTable->buildRow($cells);
        }
        $document->add($tradeTable);
    }
            
    public function accept()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        if ((string)$mysidia->input->get("confirm")) {
            $document->setTitle($this->lang->accepted_title);
            $document->addLangvar($this->lang->accepted);
            return;
        }
        
        $document->setTitle($this->lang->accept_title);
        $document->addLangvar($this->lang->accept);
        $tradeOffer = $this->getField("tradeOffer");
        $tradeHelper = $this->getField("tradeHelper");
        $tradeHelper->setView($this);
 
        $document->addLangvar($this->lang->review);
        $document->add(new Image("templates/icons/warning.gif"));
        $document->add(new Comment($this->lang->review_partner.$tradeOffer->getSender(), true, "b"));
        $document->add(new Comment);
        $document->add(new Image("templates/icons/next.gif"));
        $document->addLangvar($this->lang->review_adoptoffered);
        $document->add($tradeHelper->getAdoptImages($tradeOffer->getAdoptOffered(), false));
        $document->add(new Image("templates/icons/next.gif"));
        $document->addLangvar($this->lang->review_adoptwanted);
        $document->add($tradeHelper->getAdoptImages($tradeOffer->getAdoptWanted(), false));

        $document->add(new Image("templates/icons/next.gif"));
        $document->addLangvar($this->lang->review_itemoffered);
        $document->add($tradeHelper->getItemImages($tradeOffer->getItemOffered(), false));
        $document->add(new Image("templates/icons/next.gif"));
        $document->addLangvar($this->lang->review_itemwanted);
        $document->add($tradeHelper->getItemImages($tradeOffer->getItemWanted(), false));

        $document->add(new Image("templates/icons/next.gif"));
        $document->addLangvar($this->lang->review_cashoffered.$tradeOffer->getCashOffered()." ".$mysidia->settings->cost);
        $document->add(new Comment("<br>"));
        $document->add(new Image("templates/icons/warning.gif"));
        $document->addLangvar($this->lang->review_message);
        $document->add(new Paragraph(new Comment($tradeOffer->getMessage(), true, "b")));
        $document->add(new Link("mytrades/accept/{$mysidia->input->get("tid")}/confirm", "Yes, I confirm my action!", true));
        $document->add(new Link("mytrades", "No, take me back to the tradeoffer list."));
    }
    
    public function decline()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        if ((string)$mysidia->input->get("confirm")) {
            $document->setTitle($this->lang->declined_title);
            $document->addLangvar($this->lang->declined);
            $document->add(new Link("mytrades", "Click here to see all of your pending trade requests."));
            return;
        }
        $document->setTitle($this->lang->decline_title);
        $document->addLangvar($this->lang->decline);
        $document->add(new Link("mytrades/decline/{$mysidia->input->get("tid")}/confirm", "Yes, I confirm my action!", true));
        $document->add(new Link("mytrades", "No, take me back to the tradeoffer list."));
    }
}
