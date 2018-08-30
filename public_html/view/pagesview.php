<?php

class PagesView extends View{

    public function view(){
	    if($this->flags) $this->redirect(3, "../../index");
    }
}