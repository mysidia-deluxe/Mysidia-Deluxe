<?php

use Resource\Native\Mystring;
use Resource\Collection\LinkedHashMap;

class ACPUserView extends View
{
    public function index()
    {
        parent::index();
        $mysidia = Registry::get("mysidia");
        $stmt = $this->getField("stmt")->get();
        $document = $this->document;

        $fields = new LinkedHashMap;
        $fields->put(new Mystring("uid"), null);
        $fields->put(new Mystring("username"), new Mystring("getProfileLink"));
        $fields->put(new Mystring("email"), null);
        $fields->put(new Mystring("ip"), null);
        $fields->put(new Mystring("usergroup"), null);
        $fields->put(new Mystring("uid::edit"), new Mystring("getEditLink"));
        $fields->put(new Mystring("uid::delete"), new Mystring("getDeleteLink"));
        
        $userTable = new TableBuilder("user");
        $userTable->setAlign(new Align("center", "middle"));
        $userTable->buildHeaders("uid", "Username", "Email", "IP", "Usergroup", "Edit", "Delete");
        $userTable->setHelper(new UserTableHelper);
        $userTable->buildTable($stmt, $fields);
        $document->add($userTable);
    }
    
    public function edit()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        if (!$mysidia->input->get("uid")) {
            $this->index();
            return;
        }
        $user = new Member($mysidia->input->get("uid"));
        
        if ($mysidia->input->post("submit")) {
            $document->setTitle($this->lang->edited_title);
            $document->addLangvar($this->lang->edited);
        } else {
            $document->setTitle($this->lang->edit_title);
            $document->addLangvar($this->lang->edit);
            $userForm = new FormBuilder("editform", $mysidia->input->get("uid"), "post");
            $userForm->add(new Comment("<br><br>"));
            $userForm->add(new Image("templates/icons/delete.gif"));
            $userForm->buildCheckBox(" Delete This User. <strong>This cannot be undone!</strong>", "delete", "yes")
                     ->buildComment("Assign New Password: ", false)->buildPasswordField("password", "pass1", "", true)
                     ->buildComment("Passwords may contain letters and numbers only. Leave the box blank to keep the current password.")
                     ->buildCheckBox(" Email the user the new password (Only takes effect if setting a new password) ", "emailpwchange", "yes")
                     ->buildComment("Change Email Address: ", false)->buildTextField("email", $user->getemail())
                     ->buildCheckBox(" Ban this user's rights to click adoptables", "canlevel", "no")
                     ->buildCheckBox(" Ban this user's rights to post profile comments", "canvm", "no")
                     ->buildCheckBox(" Ban this user's rights to make trade offers", "cantrade", "no")
                     ->buildCheckBox(" Ban this user's rights to send friend requests", "canfriend", "no")
                     ->buildCheckBox(" Ban this user's rights to breed adoptables", "canbreed", "no")
                     ->buildCheckBox(" Ban this user's rights to abandon adoptables", "canpound", "no")
                     ->buildCheckBox(" Ban this user's rights to visit Shops", "canshop", "no");
                     
            $userForm->add(new Comment("<u>{$user->username}'s Current Usergroup:</u> Group {$user->usergroup}"));
            $userForm->add(new Comment("Change {$user->username}'s Usergroup To:", false));
            $userForm->buildDropdownList("level", "UsergroupList", $user->usergroup->gid)
                     ->buildButton("Edit User", "submit", "submit");
            $document->add($userForm);
        }
    }
    
    public function delete()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        if (!$mysidia->input->get("uid")) {
            $this->index();
            return;
        }
        $document->setTitle($this->lang->delete_title);
        $document->addLangvar($this->lang->delete);
        header("Refresh:3; URL='../../index'");
    }
}
