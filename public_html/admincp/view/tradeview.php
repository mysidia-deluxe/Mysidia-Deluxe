<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedList;
use Resource\Collection\LinkedHashMap;

class ACPTradeView extends View
{
    public function index()
    {
        parent::index();
        $mysidia = Registry::get("mysidia");
        $stmt = $this->getField("stmt")->get();
        $document = $this->document;
        $fields = new LinkedHashMap;
        $fields->put(new Mystring("tid"), null);
        $fields->put(new Mystring("type"), null);
        $fields->put(new Mystring("sender"), null);
        $fields->put(new Mystring("recipient"), new Mystring("getText"));
        $fields->put(new Mystring("message"), null);
        $fields->put(new Mystring("status"), null);
        $fields->put(new Mystring("tid::edit"), new Mystring("getEditLink"));
        $fields->put(new Mystring("tid::delete"), new Mystring("getDeleteLink"));
        
        $tradeTable = new TableBuilder("trade");
        $tradeTable->setAlign(new Align("center", "middle"));
        $tradeTable->buildHeaders("ID", "Type", "Sender", "Recipient", "Message", "Status", "Edit", "Delete");
        $tradeTable->setHelper(new TableHelper);
        $tradeTable->buildTable($stmt, $fields);
        $document->add($tradeTable);
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
        $tradeForm = new FormBuilder("addform", "add", "post");
        $tradeTypes = new LinkedHashMap;
        $tradeTypes->put(new Mystring("Private"), new Mystring("private"));
        $tradeTypes->put(new Mystring("Public"), new Mystring("public"));
        $tradeTypes->put(new Mystring("Partial"), new Mystring("partial"));
        $date = new DateTime;
        
        $tradeForm->add(new Comment("<hr>Basic Information:", true, "b"));
        $tradeForm->add(new Comment("Sender: ", false, "i"));
        $tradeForm->add(new TextField("sender"));
        $tradeForm->add(new Comment($this->lang->sender_explain));
        $tradeForm->add(new Comment("Recipient: ", false, "i"));
        $tradeForm->add(new TextField("recipient"));
        $tradeForm->add(new Comment($this->lang->recipient_explain));
        $tradeForm->add(new Comment("Adopt Provided: ", false, "i"));
        $tradeForm->add(new TextField("adoptOffered"));
        $tradeForm->add(new Comment($this->lang->adopt_offered_explain));
        $tradeForm->add(new Comment("Adopt Requested: ", false, "i"));
        $tradeForm->add(new TextField("adoptWanted"));
        $tradeForm->add(new Comment($this->lang->adopt_wanted_explain));
        $tradeForm->add(new Comment("Item Provided: ", false, "i"));
        $tradeForm->add(new TextField("itemOffered"));
        $tradeForm->add(new Comment($this->lang->item_offered_explain));
        $tradeForm->add(new Comment("Item Requested: ", false, "i"));
        $tradeForm->add(new TextField("itemWanted"));
        $tradeForm->add(new Comment($this->lang->item_wanted_explain));
        $tradeForm->add(new Comment("Cash Offered: ", false, "i"));
        $tradeForm->add(new TextField("cashOffered", 0));
        $tradeForm->add(new Comment($this->lang->cash_offered_explain));

        $tradeForm->add(new Comment("<hr>Additional Information:", true, "b"));
        $tradeForm->add(new Comment("Trade Type: ", false, "i"));
        $tradeForm->buildRadioList("type", $tradeTypes, "private");
        $tradeForm->add(new Comment($this->lang->type_explain));
        $tradeForm->add(new Comment("Trade Message: ", true, "i"));
        $tradeForm->add(new TextArea("message", "Enter a short message here."));
        $tradeForm->add(new Comment($this->lang->message_explain));
        $tradeForm->add(new Comment("Trade Status: ", false, "i"));
        $tradeForm->add(new TextField("status", "pending"));
        $tradeForm->add(new Comment($this->lang->status_explain));
        $tradeForm->add(new Comment("Trade DateTime: ", false, "i"));
        $tradeForm->add(new TextField("date", $date->format("y-m-d")));
        $tradeForm->add(new Comment($this->lang->date_explain));
        $tradeForm->add(new Button("Initiate Trade Offer", "submit", "submit"));
        $document->add($tradeForm);
    }
    
    public function edit()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        if (!$mysidia->input->get("tid")) {
            // An item has yet been selected, return to the index page.
            $this->index();
            return;
        } elseif ($mysidia->input->post("submit")) {
            $document->setTitle($this->lang->edited_title);
            $document->addLangvar($this->lang->edited);
            return;
        } else {
            $trade = $this->getField("trade")->get();
            $document->setTitle($this->lang->edit_title);
            $document->addLangvar($this->lang->edit);
            $tradeForm = new FormBuilder("editform", $mysidia->input->get("tid"), "post");
            $tradeTypes = new LinkedHashMap;
            $tradeTypes->put(new Mystring("Private"), new Mystring("private"));
            $tradeTypes->put(new Mystring("Public"), new Mystring("public"));
            $tradeTypes->put(new Mystring("Partial"), new Mystring("partial"));
        
            $tradeForm->add(new Comment("<hr>Basic Information:", true, "b"));
            $tradeForm->add(new Comment("Sender: ", false, "i"));
            $tradeForm->add(new TextField("sender", $trade->sender));
            $tradeForm->add(new Comment($this->lang->sender_explain));
            $tradeForm->add(new Comment("Recipient: ", false, "i"));
            $tradeForm->add(new TextField("recipient", $trade->recipient));
            $tradeForm->add(new Comment($this->lang->recipient_explain));
            $tradeForm->add(new Comment("Adopt Provided: ", false, "i"));
            $tradeForm->add(new TextField("adoptOffered", $trade->adoptoffered));
            $tradeForm->add(new Comment($this->lang->adopt_offered_explain));
            $tradeForm->add(new Comment("Adopt Requested: ", false, "i"));
            $tradeForm->add(new TextField("adoptWanted", $trade->adoptwanted));
            $tradeForm->add(new Comment($this->lang->adopt_wanted_explain));
            $tradeForm->add(new Comment("Item Provided: ", false, "i"));
            $tradeForm->add(new TextField("itemOffered", $trade->itemoffered));
            $tradeForm->add(new Comment($this->lang->item_offered_explain));
            $tradeForm->add(new Comment("Item Requested: ", false, "i"));
            $tradeForm->add(new TextField("itemWanted", $trade->itemwanted));
            $tradeForm->add(new Comment($this->lang->item_wanted_explain));
            $tradeForm->add(new Comment("Cash Offered: ", false, "i"));
            $tradeForm->add(new TextField("cashOffered", $trade->cashoffered));
            $tradeForm->add(new Comment($this->lang->cash_offered_explain));

            $tradeForm->add(new Comment("<hr>Additional Information:", true, "b"));
            $tradeForm->add(new Comment("Trade Type: ", false, "i"));
            $tradeForm->buildRadioList("type", $tradeTypes, $trade->type);
            $tradeForm->add(new Comment($this->lang->type_explain));
            $tradeForm->add(new Comment("Trade Message: ", true, "i"));
            $tradeForm->add(new TextArea("message", $trade->message));
            $tradeForm->add(new Comment($this->lang->message_explain));
            $tradeForm->add(new Comment("Trade Status: ", false, "i"));
            $tradeForm->add(new TextField("status", $trade->status));
            $tradeForm->add(new Comment($this->lang->status_explain));
            $tradeForm->add(new Comment("Trade DateTime: ", false, "i"));
            $tradeForm->add(new TextField("date", $trade->date));
            $tradeForm->add(new Comment($this->lang->date_explain));
            $tradeForm->add(new Button("Update Trade Offer", "submit", "submit"));
            $document->add($tradeForm);
        }
    }

    public function delete()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        if (!$mysidia->input->get("tid")) {
            // A trade offer has yet been selected, return to the index page.
            $this->index();
            return;
        }
        $document->setTitle($this->lang->delete_title);
        $document->addLangvar($this->lang->delete);
    }
    
    public function moderate()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        if ($mysidia->input->get("tid")) {
            // A trade offer has been selected for moderation, let's go over it!
            if ($mysidia->input->post("submit")) {
                $status = (string)$this->getField("status", new Mystring("status"));
                $document->setTitle($this->lang->moderated_title);
                $document->addLangvar($this->lang->{$status});
                return;
            }
            
            $trade = $this->getField("trade");
            $tradeHelper = $this->getField("tradeHelper");
            $tradeHelper->setView($this);
            $statusTypes = new LinkedHashMap;
            $statusTypes->put(new Mystring("Approve"), new Mystring("pending"));
            $statusTypes->put(new Mystring("Disapprove"), new Mystring("canceled"));
            
            $document->setTitle($this->lang->moderate_title);
            $document->addLangvar($this->lang->review);
            $document->add(new Comment("<br>Type: {$trade->getType()}"));
            $document->add(new Comment("<br>Sender: {$trade->getSender()}"));
            $document->add(new Comment("<br>Recipient: {$trade->getRecipient()}"));
            
            $document->add(new Comment("<br>AdoptOffered: "));
            $document->add($tradeHelper->getAdoptImages($trade->getAdoptOffered(), false));
            $document->add(new Comment("<br>AdoptWanted: "));
            $document->add(($trade->getType() == "public")?$tradeHelper->getAdoptList($trade->getAdoptWanted()):$tradeHelper->getAdoptImages($trade->getAdoptWanted(), false));
            $document->add(new Comment("<br>ItemOffered: "));
            $document->add($tradeHelper->getItemImages($trade->getItemOffered(), false));
            $document->add(new Comment("<br>ItemWanted: "));
            $document->add(($trade->getType() == "public")?$tradeHelper->getItemList($trade->getItemWanted()):$tradeHelper->getItemImages($trade->getItemWanted(), false));
            $document->add(new Comment("<br>CashOffered: {$trade->getCashOffered()} {$mysidia->settings->cost}"));
            $document->add(new Comment("<br>Message: "));
            $document->add(new Paragraph(new Comment($trade->getMessage(), true, "i"), "message"));
            
            $tradeForm = new FormBuilder("moderateform", $mysidia->input->get("tid"), "post");
            $tradeForm->add(new Comment("<br>You can now approve or disapprove this trade offer: "));
            $tradeForm->buildRadioList("status", $statusTypes, "pending");
            $tradeForm->add(new Button("Moderate Trade Offer", "submit", "submit"));
            $document->add($tradeForm);
            return;
        }
        
        $document->setTitle($this->lang->moderate_title);
        $document->addLangvar($this->lang->moderate);
        $stmt = $this->getField("stmt")->get();
        $fields = new LinkedHashMap;
        $fields->put(new Mystring("tid"), null);
        $fields->put(new Mystring("type"), null);
        $fields->put(new Mystring("sender"), null);
        $fields->put(new Mystring("recipient"), new Mystring("getText"));
        $fields->put(new Mystring("message"), null);
        $fields->put(new Mystring("status"), null);
        $fields->put(new Mystring("tid::moderate"), new Mystring("getModerateLink"));
        
        $tradeTable = new TableBuilder("item");
        $tradeTable->setAlign(new Align("center", "middle"));
        $tradeTable->buildHeaders("ID", "Type", "Sender", "Recipient", "Message", "Status", "Moderate");
        $tradeTable->setHelper(new TableHelper);
        $tradeTable->buildTable($stmt, $fields);
        $document->add($tradeTable);
    }
    
    public function settings()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        if ($mysidia->input->post("submit")) {
            $document->setTitle($this->lang->settings_changed_title);
            $document->addLangvar($this->lang->settings_changed);
            return;
        }
        
        $tradeSettings = $this->getField("tradeSettings");
        $document->setTitle($this->lang->settings_title);
        $document->addLangvar($this->lang->settings);
        $settingsForm = new FormBuilder("settingsform", "settings", "post");
        $tradeSystem = new LinkedHashMap;
        $tradeSystem->put(new Mystring("Enabled"), new Mystring("enabled"));
        $tradeSystem->put(new Mystring("Disabled"), new Mystring("disabled"));
        $tradeMultiple = clone $tradeSystem;
        $tradePartial = clone $tradeSystem;
        $tradePublic = clone $tradeSystem;
        $tradeModerate = clone $tradeSystem;
        
        $settingsForm->buildComment("Trade System Enabled:   ", false)->buildRadioList("system", $tradeSystem, $tradeSettings->system)
                     ->buildComment("Multiple Adopts/Items Enabled:   ", false)->buildRadioList("multiple", $tradeMultiple, $tradeSettings->multiple)
                     ->buildComment("Partial Trade Enabled:   ", false)->buildRadioList("partial", $tradePartial, $tradeSettings->partial)
                     ->buildComment("Public Trade Enabled:   ", false)->buildRadioList("public", $tradePublic, $tradeSettings->public)
                     ->buildComment("Ineligible Species(separate by comma):   ", false)->buildTextField("species", ($tradeSettings->species)?implode(",", $tradeSettings->species):"")
                     ->buildComment("Interval/wait-time(days) between successive trade offers:	 ", false)->buildTextField("interval", $tradeSettings->interval)
                     ->buildComment("Maximum Number of adoptables/items allowed:   ", false)->buildTextField("number", $tradeSettings->number)
                     ->buildComment("Number of days till Trade is still valid(or expiring):   ", false)->buildTextField("duration", $tradeSettings->duration)
                     ->buildComment("Tax for each Trade Offer:	 ", false)->buildTextField("tax", $tradeSettings->tax)
                     ->buildComment("Usergroup(s) permitted to trade(separate by comma):	", false)->buildTextField("usergroup", ($tradeSettings->usergroup == "all")?$tradeSettings->usergroup:implode(",", $tradeSettings->usergroup))
                     ->buildComment("Ineligible/non-tradable Item(s)(separate by comma):	", false)->buildTextField("item", ($tradeSettings->item)?implode(",", $tradeSettings->item):"")
                     ->buildComment("Moderation Required:   ", false)->buildRadioList("moderate", $tradeModerate, $tradeSettings->moderate)
                     ->buildButton("Change Trade Settings", "submit", "submit");
        $document->add($settingsForm);
    }
}
