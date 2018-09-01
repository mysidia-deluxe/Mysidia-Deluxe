<?php

require("classes/class_controller.php");
require("classes/class_frontcontroller.php");
require("classes/class_initializer.php");

//***************//
//  START SCRIPT //
//***************//

class IndexController extends FrontController
{
    public function handleRequest()
    {
        $mysidia = Registry::get("mysidia");
        $class = $mysidia->input->get("appcontroller")->capitalize();
        $controller = "{$class}Controller";
        $action = $mysidia->input->action();
        
        try {
            $this->appController = new $controller;
            $this->appController->setFrontController($this);
            $this->appController->$action();
            $this->action = $action;
            return true;
        } catch (GuestNoaccessException $gne) {
            $this->setFlags("global_guest_title", $gne->getmessage());
            return false;
        } catch (InvalidActionException $iae) {
            $this->setFlags("global_action_title", $iae->getmessage());
            return false;
        } catch (NoPermissionException $npe) {
            $this->setFlags("global_error", $npe->getmessage());
            return false;
        } catch (InvalidIDException $iie) {
            $this->setFlags("global_id_title", $iie->getmessage());
            return false;
        } catch (DuplicateIDException $die) {
            $this->setFlags("global_id_title", $die->getmessage());
            return false;
        } catch (AlreadyLoggedinException $ale) {
            $this->setFlags("global_login_title", $ale->getmessage());
            return false;
        } catch (MemberNotfoundException $mne) {
            $this->setFlags("global_id_title", $mne->getmessage());
            return false;
        } catch (Exception $e) {
            $error = strtolower(str_replace("Exception", "_error", get_class($e)));
            $this->setFlags($error, $e->getmessage());
            return false;
        }
    }
    
    public function index()
    {
    }
    
    public static function main()
    {
        $init = new Initializer;
        $mysidia = Registry::get("mysidia");
        $index = new IndexController;
        if ($index->getRequest()) {
            $index->handleRequest();
        } else {
            $index->index();
        }
        $index->getView();
        $index->render();
    }
}

IndexController::main();
